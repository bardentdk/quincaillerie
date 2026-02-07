<body style="font-family: sans-serif; background-color: #fef2f2; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; border-left: 8px solid #ef4444;">
        <h2 style="color: #991b1b; margin-top: 0;">⚠️ RUPTURE PROCHE</h2>
        <p>Le stock de l'article suivant a atteint le seuil critique :</p>
        
        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; margin: 20px 0;">
            <p><strong>Article :</strong> {{ $product->name }}</p>
            <p><strong>Référence (SKU) :</strong> {{ $product->sku }}</p>
            <p style="font-size: 20px; color: #ef4444;">
                <strong>Stock actuel : {{ $product->stock_quantity }} {{ $product->unit }}</strong>
            </p>
        </div>

        <a href="{{ route('admin.products.edit', $product->id) }}" 
           style="display: inline-block; background: #00429d; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold;">
            Commander du réapprovisionnement
        </a>
    </div>
</body>