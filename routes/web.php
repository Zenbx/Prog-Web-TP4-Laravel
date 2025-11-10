<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/**
 * Route d'accueil qui redirige vers la liste des produits.
 */
Route::get('/', function () {
    return redirect()->route('products.index');
});

/**
 * Routes RESTful pour la gestion complète des produits.
 * Génère automatiquement toutes les routes CRUD :
 *
 * GET    /products                → index()   (liste)
 * GET    /products/create         → create()  (formulaire création)
 * POST   /products                → store()   (enregistrer)
 * GET    /products/{product}      → show()    (détails)
 * GET    /products/{product}/edit → edit()    (formulaire édition)
 * PUT    /products/{product}      → update()  (mettre à jour)
 * DELETE /products/{product}      → destroy() (supprimer)
 */
Route::resource('products', ProductController::class);
