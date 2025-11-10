<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;

/**
 * Routes API pour la gestion des produits.
 * Toutes ces routes sont automatiquement préfixées par /api
 * et retournent des données au format JSON.
 *
 * Exemple : GET /api/products renvoie la liste des produits en JSON
 */

// Routes RESTful pour les opérations CRUD sur les produits
Route::apiResource('products', ProductApiController::class);

// Routes supplémentaires pour des fonctionnalités spécifiques
Route::get('products-categories', [ProductApiController::class, 'categories']);
Route::get('products-brands', [ProductApiController::class, 'brands']);
Route::get('products-statistics', [ProductApiController::class, 'statistics']);

/**
 * Route de test pour vérifier que l'API fonctionne.
 * Utile pour le debugging et les tests de connectivité.
 */
Route::get('health', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is running successfully',
        'timestamp' => now()->toDateTimeString(),
    ]);
});
