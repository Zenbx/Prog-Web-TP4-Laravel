<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->id();   //id dans la BD
            $table->string('name');   //Nom du Produit
            $table->text('description')->nullable();   //Description du produit
            $table->decimal('price', 10, 2);   //Prix du produit
            $table->integer('stock')->default(0);  //Quantité disponible en Stock du produit
            $table->string('sku')->nullable();  //Identifiant unique d'un produit
            $table->string('image')->nullable();        // Lien ou chemin de l'image
            $table->string('brand')->nullable();        // Marque du produit
            $table->string('category')->nullable();     // Catégorie (ex: téléphone, vêtement)
            $table->boolean('featured')->default(false); // Produit mis en avant
            $table->boolean('is_new')->default(true);  //Produit marqué comme "Nouveau
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('products');
    }
};
