<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\BrevoMailService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'number' => $order->order_number,
                    'customer' => $order->user->name,
                    'total' => number_format($order->total_amount_cents / 100, 2, ',', ' ') . ' €',
                    'status' => $order->status,
                    'date' => $order->created_at->format('d/m/Y H:i'),
                ];
            });

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders
        ]);
    }  
    public function show(Order $order)
    {
        // On charge les relations pour afficher les produits et les unités
        return Inertia::render('Admin/Orders/Show', [
            'order' => $order->load(['user', 'items.product.category'])
        ]);
    }

    public function updateStatus(Order $order, Request $request, BrevoMailService $brevo)
    {
        $validated = $request->validate([
            'status' => 'required|in:paid,shipped,delivered'
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $validated['status']]);

        // Si on passe en "Expédié", on déclenche le mail Brevo
        if ($validated['status'] === 'shipped' && $oldStatus !== 'shipped') {
            $brevo->sendShippingNotification($order);
        }

        return back()->with('message', "Commande mise à jour : Statut " . strtoupper($validated['status']));
    }
}