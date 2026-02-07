<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function downloadInvoice(Order $order) {
        $pdf = Pdf::loadView('pdf.invoice', compact('order'));
        return $pdf->download('Facture-' . $order->order_number . '.pdf');
    }
}
