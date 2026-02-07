<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Customer/Dashboard', [
            'user' => auth()->user(),
            'recentOrders' => auth()->user()->orders()
                ->latest()
                ->take(3)
                ->get()
                ->map(fn($o) => [
                    'id' => $o->id,
                    'order_number' => $o->order_number,
                    'total_amount_cents' => $o->total_amount_cents,
                    'status' => $o->status,
                    'created_at' => $o->created_at->format('d/m/Y'),
                ])
        ]);
    }
}