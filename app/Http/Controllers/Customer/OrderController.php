<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Customer/Orders', [
            'orders' => auth()->user()->orders()
                ->latest()
                ->get()
                ->map(fn($o) => [
                    'id' => $o->id,
                    'order_number' => $o->order_number,
                    'total' => number_format($o->total_amount_cents / 100, 2, ',', ' '),
                    'status' => $o->status,
                    'date' => $o->created_at->format('d/m/Y'),
                ])
        ]);
    }

    public function show(Order $order)
    {
        // Sécurité : Vérifier que la commande appartient bien à l'utilisateur
        if ($order->user_id !== auth()->id()) abort(403);

        return Inertia::render('Customer/OrderShow', [
            'order' => $order->load('items.product')
        ]);
    }
}