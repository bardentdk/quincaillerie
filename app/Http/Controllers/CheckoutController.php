<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        // On récupère la clé secrète depuis le .env
        \Stripe\Stripe::setApiKey(config('cashier.secret'));

        // On crée la session Stripe avec les articles du panier
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Commande Quincaillerie Pro',
                    ],
                    'unit_amount' => $request->total * 100, // Montant en centimes
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
        ]);

        return Inertia::location($session->url);
    }
}