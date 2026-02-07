<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price_cents', 
        'stock_quantity', 'sku', 'category_id', 'seo_metadata', 'is_active',
        'image', 'unit', // On ajoute ce champ
    ];

    protected $casts = [
        'seo_metadata' => 'array',
        'is_active' => 'boolean',
    ];

    // Relation : Un produit appartient à une seule catégorie
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relation : Un produit peut être dans plusieurs lignes de commande
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Accessor : Convertit les centimes en euros pour l'affichage (ex: 18990 -> 189.90)
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->price_cents / 100,
        );
    }
}