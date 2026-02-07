<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\BrevoMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class WebhookController extends Controller
{
    public function handle(Request $request, BrevoMailService $brevo)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Payload invalide'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Signature invalide'], 400);
        }

        // On ne traite que le succès du paiement
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            
            // On retrouve la commande via l'ID de session Stripe
            $order = Order::where('stripe_payment_id', $session->id)->first();

            if ($order && $order->status === 'pending') {
                $order->update(['status' => 'paid']);

                // 1. Mise à jour des stocks
                foreach ($order->items as $item) {
                    $item->product->decrement('stock_quantity', $item->quantity);
                    
                    // On recharge le produit pour avoir la quantité à jour
                    $product = $item->product->fresh();

                    // Seuil d'alerte : 5 unités ou 2 tonnes/kg pour les matériaux
                    $threshold = ($product->unit === 'unit') ? 5 : 2;

                    if ($product->stock_quantity <= $threshold) {
                        $brevo->sendLowStockAlert($product);
                    }
                }

                // 2. Envoi du mail de confirmation via Brevo
                $brevo->sendOrderConfirmation($order);

                Log::info("Commande #{$order->order_number} validée et mail envoyé.");
            }
        }

        return response()->json(['status' => 'success']);
    }
}