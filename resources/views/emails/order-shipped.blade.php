<!DOCTYPE html>
<html>
<head>
    <style>
        .card { background: #00429d; color: white; padding: 30px; border-radius: 20px; text-align: center; }
        .highlight { color: #ffde00; font-size: 24px; font-weight: bold; }
    </style>
</head>
<body style="font-family: 'Helvetica', sans-serif; color: #334155; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 40px 20px;">
        <div class="card">
            <h1 style="margin: 0; text-transform: uppercase; font-style: italic;">En route !</h1>
            <p>Votre commande <strong>#{{ $order->order_number }}</strong> a quitté notre quincaillerie.</p>
        </div>

        <div style="margin-top: 30px; border: 1px solid #e2e8f0; padding: 20px; border-radius: 15px;">
            <p><strong>Contenu de votre colis :</strong></p>
            <ul style="list-style: none; padding: 0;">
                @foreach($order->items as $item)
                    <li style="padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                        <strong>{{ $item.quantity }} {{ $item->product->unit === 'unit' ? 'pce(s)' : $item->product->unit }}</strong> - {{ $item.product.name }}
                    </li>
                @endforeach
            </ul>
        </div>

        <p style="text-align: center; margin-top: 30px;">
            Nos transporteurs font le maximum pour vous livrer dans les plus brefs délais.
        </p>
        
        <p style="font-size: 11px; color: #94a3b8; text-align: center; margin-top: 50px;">
            Quincaillerie ARCS Pro - SIRET 123 456 789<br>
            Ceci est un message automatique, merci de ne pas y répondre.
        </p>
    </div>
</body>
</html>