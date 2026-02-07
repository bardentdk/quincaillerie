<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Inertia\Inertia;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];
        $totalAmountCents = 0;

        // On crée la commande en attente de paiement
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'CMD-' . strtoupper(Str::random(10)),
            'total_amount_cents' => 0, // Sera mis à jour
            'status' => 'pending',
            'delivery_address' => 'Adresse test client', // À lier à un formulaire plus tard
        ]);

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['id']);
            
            // Calcul du montant total pour cette ligne (ex: 1.5 * 10000 cents)
            $lineTotal = (int) ($product->price_cents * $item['quantity']);

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $product->name . " ({$item['quantity']} {$product->unit})",
                    ],
                    'unit_amount' => $lineTotal, // On envoie le prix total calculé
                ],
                'quantity' => 1, // On fige la quantité à 1 pour Stripe
            ];
        }

        $order->update(['total_amount_cents' => $totalAmountCents]);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'metadata' => ['order_id' => $order->id]
        ]);

        $order->update(['stripe_payment_id' => $session->id]);

        return Inertia::location($session->url);
    }

    public function success()
    {
        return Inertia::render('Checkout/Success');
    }
}