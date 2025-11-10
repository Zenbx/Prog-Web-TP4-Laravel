<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Modèle représentant un produit dans la boutique en ligne.
 * Ce modèle gère toutes les interactions avec la table products.
 */
class Product extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     * Laravel utilise par défaut le pluriel snake_case du nom de la classe,
     * mais nous le définissons explicitement pour plus de clarté.
     */
    protected $table = 'products';

    /**
     * Les attributs qui peuvent être assignés en masse.
     * Cela protège contre les vulnérabilités d'assignation de masse.
     */
    protected $fillable = [
        'title',
        'desc',
        'category',
        'brand',
        'price',
        'stock',
        'img',
        'featured',
        'new',
    ];

    /**
     * Les attributs qui doivent être castés vers des types natifs.
     * Cela permet à Laravel de convertir automatiquement les types de données.
     */
    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
        'featured' => 'boolean',
        'new' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope pour récupérer uniquement les produits mis en avant.
     * Utilisation : Product::featured()->get()
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    /**
     * Scope pour récupérer uniquement les nouveaux produits.
     * Utilisation : Product::new()->get()
     */
    public function scopeNew(Builder $query): Builder
    {
        return $query->where('new', true);
    }

    /**
     * Scope pour filtrer par catégorie.
     * Utilisation : Product::byCategory('Smartphones')->get()
     */
    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    /**
     * Scope pour filtrer par marque.
     * Utilisation : Product::byBrand('Apple')->get()
     */
    public function scopeByBrand(Builder $query, string $brand): Builder
    {
        return $query->where('brand', $brand);
    }

    /**
     * Scope pour récupérer les produits en stock.
     * Utilisation : Product::inStock()->get()
     */
    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Vérifie si le produit est disponible en stock.
     * Retourne true si le stock est supérieur à zéro.
     */
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Formate le prix pour l'affichage avec le séparateur de milliers.
     * Par exemple : 850000 devient "850 000"
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', ' ');
    }

    /**
     * Retourne le prix avec la devise.
     * Par exemple : "850 000 FCFA"
     */
    public function getPriceWithCurrencyAttribute(): string
    {
        return $this->formatted_price . ' FCFA';
    }
}
