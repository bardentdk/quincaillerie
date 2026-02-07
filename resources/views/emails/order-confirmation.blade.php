<!DOCTYPE html>
<html>
<head>
    <style>
        .btn { background: #ffde00; color: #00429d; padding: 12px 25px; text-decoration: none; font-weight: bold; border-radius: 8px; }
        .footer { font-size: 12px; color: #64748b; margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 20px; }
    </style>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #1e293b;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #00429d;">Merci pour votre commande !</h1>
        <p>Bonjour {{ $order->user->name }},</p>
        <p>Bonne nouvelle ! Votre paiement pour la commande <strong>#{{ $order->order_number }}</strong> a été validé.</p>
        
        <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin: 20px 0;">
            <h3 style="margin-top: 0;">Récapitulatif :</h3>
            <ul style="list-style: none; padding: 0;">
                @foreach($order->items as $item)
                    <li>{{ $item->quantity }}x {{ $item->product->name }} - {{ number_format($item->price_at_purchase_cents / 100, 2) }}€</li>
                @endforeach
            </ul>
            <hr>
            <p><strong>TOTAL TTC : {{ number_format($order->total_amount_cents / 100, 2) }}€</strong></p>
        </div>

        <p>Dès que votre colis quitte notre entrepôt, vous recevrez un nouveau mail avec votre numéro de suivi.</p>
        
        <a href="{{ route('home') }}" class="btn">Retourner sur la boutique</a>

        <div class="footer">
            Quincaillerie ARCS Pro - Expert en bâtiment<br>
            Ceci est un mail automatique, merci de ne pas y répondre.
        </div>
    </div>
</body>
</html>