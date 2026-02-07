<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'metrics' => [
                'revenue' => number_format(Order::where('status', '!=', 'pending')->sum('total_amount_cents') / 100, 2, ',', ' '),
                'orders_count' => Order::where('status', 'paid')->count(),
                'low_stock' => Product::where('stock_quantity', '<', 5)->count(),
            ],
            // Historique récent pour l'admin
            'recent_orders' => Order::with('user')->latest()->take(5)->get()->map(fn($o) => [
                'number' => $o->order_number,
                'customer' => $o->user->name,
                'total' => number_format($o->total_amount_cents / 100, 2) . '€',
                'status' => $o->status,
            ])
        ]);
    }

    public function financials()
    {
        // Revenus par jour sur les 30 derniers jours
        $stats = Order::where('status', '!=', 'pending')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount_cents) / 100 as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return Inertia::render('Admin/Financials', [
            'chartData' => [
                'labels' => $stats->pluck('date'),
                'datasets' => [[
                    'label' => 'Chiffre d\'affaires (€)',
                    'data' => $stats->pluck('total'),
                ]]
            ]
        ]);
    }
}