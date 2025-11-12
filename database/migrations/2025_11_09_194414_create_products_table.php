<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration pour créer la table des produits de la boutique en ligne.
 * Cette table stocke toutes les informations essentielles sur chaque produit.
 */
return new class extends Migration
{
    /**
     * Exécute la migration pour créer la table products.
     * Cette méthode définit la structure complète de la table avec tous ses champs et contraintes.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            // Clé primaire auto-incrémentée
            $table->id();

            // Informations de base du produit
            $table->string('title', 255);
            $table->text('desc')->nullable(); // Description peut être vide initialement

            // Classification du produit
            $table->string('category', 100);
            $table->string('brand', 100);

            // Informations commerciales
            $table->integer('price'); // Prix en centimes pour éviter les problèmes de précision
            $table->integer('stock')->default(0); // Quantité disponible en stock

            // Chemin vers l'image du produit
            $table->string('img', 500);

            // Indicateurs booléens pour le marketing
            $table->boolean('featured')->default(false); // Produit mis en avant
            $table->boolean('new')->default(false); // Nouveau produit

            // Timestamps automatiques (created_at, updated_at)
            $table->timestamps();

            // Index pour optimiser les requêtes fréquentes
            $table->index('category'); // Recherche par catégorie
            $table->index('brand'); // Recherche par marque
            $table->index(['featured', 'new']); // Recherche des produits vedettes et nouveaux
        });
    }

    /**
     * Annule la migration en supprimant la table products.
     * Utilisé lors d'un rollback pour revenir en arrière.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
