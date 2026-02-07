<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Inter', sans-serif; color: #1e293b; }
        .header { background: #00429d; color: #ffde00; padding: 30px; }
        .footer { border-top: 2px solid #00429d; margin-top: 50px; padding-top: 10px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th { background: #f8fafc; text-align: left; padding: 10px; text-transform: uppercase; font-size: 12px; }
        td { padding: 10px; border-bottom: 1px solid #e2e8f0; }
        .total { font-weight: bold; color: #00429d; font-size: 20px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURE #{{ $order->order_number }}</h1>
        <p>Quincaillerie ARCS Pro - Expert en bâtiment</p>
    </div>

    <div style="margin-top: 20px;">
        <strong>Client :</strong> {{ $order->user->name }}<br>
        <strong>Date :</strong> {{ $order->created_at->format('d/m/Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Désignation</th>
                <th>Qté</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price_at_purchase_cents / 100, 2) }}€</td>
                <td>{{ number_format(($item->price_at_purchase_cents * $item->quantity) / 100, 2) }}€</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        TOTAL TTC : {{ number_format($order->total_amount_cents / 100, 2) }}€
    </div>

    <div class="footer">
        Quincaillerie ARCS - SIRET : 123 456 789 00012 - TVA Intracommunautaire : FR00123456789
    </div>
</body>
</html>