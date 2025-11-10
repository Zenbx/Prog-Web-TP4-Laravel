<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

/**
 * Contrôleur API pour la gestion des produits.
 * Ce contrôleur expose les produits via une API RESTful qui renvoie des données JSON.
 * Il permet à des applications tierces de consommer les données de la boutique.
 */
class ProductApiController extends Controller
{
    private const ITEMS_PER_PAGE = 12;
    private const SUCCESS_STATUS_CODE = 200;
    private const CREATED_STATUS_CODE = 201;
    private const BAD_REQUEST_STATUS_CODE = 400;
    private const NOT_FOUND_STATUS_CODE = 404;

    /**
     * Récupère la liste paginée de tous les produits avec possibilité de filtrage.
     * Cette méthode supporte les mêmes filtres que l'interface web pour cohérence.
     *
     * Paramètres query acceptés :
     * - category : Filtrer par catégorie
     * - brand : Filtrer par marque
     * - search : Recherche textuelle dans titre et description
     * - featured : Afficher uniquement les produits vedettes (boolean)
     * - new : Afficher uniquement les nouveaux produits (boolean)
     * - sort : Champ de tri (created_at, price, title, stock)
     * - order : Ordre de tri (asc, desc)
     * - per_page : Nombre d'éléments par page (max 100)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();

        // Application des filtres si présents dans la requête
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('brand')) {
            $query->byBrand($request->brand);
        }

        if ($request->filled('search')) {
            $search_term = $request->search;
            $query->where(function ($q) use ($search_term) {
                $q->where('title', 'like', "%{$search_term}%")
                  ->orWhere('desc', 'like', "%{$search_term}%");
            });
        }

        if ($request->boolean('featured')) {
            $query->featured();
        }

        if ($request->boolean('new')) {
            $query->new();
        }

        // Tri avec valeurs par défaut sécurisées
        $allowed_sort_fields = ['created_at', 'price', 'title', 'stock', 'id'];
        $sort_by = $request->get('sort', 'created_at');
        $sort_order = $request->get('order', 'desc');

        // Validation du champ de tri pour éviter les injections SQL
        if (!in_array($sort_by, $allowed_sort_fields)) {
            $sort_by = 'created_at';
        }

        if (!in_array($sort_order, ['asc', 'desc'])) {
            $sort_order = 'desc';
        }

        $query->orderBy($sort_by, $sort_order);

        // Pagination avec limite maximale pour éviter la surcharge serveur
        $per_page = min($request->get('per_page', self::ITEMS_PER_PAGE), 100);
        $products = $query->paginate($per_page);

        // Transformation des URLs d'images pour qu'elles soient complètes
        $products->getCollection()->transform(function ($product) {
            if ($product->img) {
                // Génère l'URL complète de l'image accessible depuis l'extérieur
                if (str_starts_with($product->img, 'http')) {
                    $product->image_url = $product->img;
                } else if (str_starts_with($product->img, 'products/')) {
                    $product->image_url = asset('storage/' . $product->img);
                } else {
                    $product->image_url = asset('storage/' . $product->img);
                }
            } else {
                $product->image_url = null;
            }
            return $product;
        });

        return response()->json([
            'success' => true,
            'message' => 'Produits récupérés avec succès',
            'data' => $products,
        ], self::SUCCESS_STATUS_CODE);
    }

    /**
     * Crée un nouveau produit dans la base de données.
     * Cette méthode accepte les données au format JSON ou multipart/form-data.
     *
     * Champs requis : title, category, brand, price, stock
     * Champs optionnels : desc, img, featured, new
     */
    public function store(Request $request): JsonResponse
    {
        // Validation des données entrantes
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'category' => 'required|string|max:100',
            'brand' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured' => 'boolean',
            'new' => 'boolean',
        ]);

        // Si la validation échoue, renvoie les erreurs en JSON
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreurs de validation',
                'errors' => $validator->errors(),
            ], self::BAD_REQUEST_STATUS_CODE);
        }

        $validated_data = $validator->validated();

        // Gestion de l'upload d'image si présente
        if ($request->hasFile('img')) {
            $image_path = $request->file('img')->store('products', 'public');
            $validated_data['img'] = $image_path;
        }

        // Gestion des booléens avec valeurs par défaut
        $validated_data['featured'] = $request->boolean('featured', false);
        $validated_data['new'] = $request->boolean('new', false);

        // Création du produit
        $product = Product::create($validated_data);

        // Ajout de l'URL complète de l'image dans la réponse
        if ($product->img) {
            $product->image_url = asset('storage/' . $product->img);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produit créé avec succès',
            'data' => $product,
        ], self::CREATED_STATUS_CODE);
    }

    /**
     * Récupère les détails complets d'un produit spécifique.
     * Inclut également une liste de produits similaires de la même catégorie.
     */
    public function show(Product $product): JsonResponse
    {
        // Récupération des produits similaires
        $similar_products = Product::byCategory($product->category)
            ->where('id', '!=', $product->id)
            ->inStock()
            ->limit(4)
            ->get();

        // Ajout des URLs complètes des images
        if ($product->img) {
            $product->image_url = asset('storage/' . $product->img);
        }

        $similar_products->transform(function ($similar_product) {
            if ($similar_product->img) {
                $similar_product->image_url = asset('storage/' . $similar_product->img);
            }
            return $similar_product;
        });

        return response()->json([
            'success' => true,
            'message' => 'Détails du produit récupérés avec succès',
            'data' => [
                'product' => $product,
                'similar_products' => $similar_products,
            ],
        ], self::SUCCESS_STATUS_CODE);
    }

    /**
     * Met à jour un produit existant.
     * Accepte des mises à jour partielles (seuls les champs fournis sont modifiés).
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        // Validation des données avec règles identiques à la création
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'desc' => 'nullable|string',
            'category' => 'sometimes|required|string|max:100',
            'brand' => 'sometimes|required|string|max:100',
            'price' => 'sometimes|required|integer|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured' => 'boolean',
            'new' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreurs de validation',
                'errors' => $validator->errors(),
            ], self::BAD_REQUEST_STATUS_CODE);
        }

        $validated_data = $validator->validated();

        // Gestion du remplacement de l'image
        if ($request->hasFile('img')) {
            // Suppression de l'ancienne image si elle existe
            if ($product->img && Storage::disk('public')->exists($product->img)) {
                Storage::disk('public')->delete($product->img);
            }

            $image_path = $request->file('img')->store('products', 'public');
            $validated_data['img'] = $image_path;
        }

        // Gestion des booléens
        if ($request->has('featured')) {
            $validated_data['featured'] = $request->boolean('featured');
        }

        if ($request->has('new')) {
            $validated_data['new'] = $request->boolean('new');
        }

        // Mise à jour du produit
        $product->update($validated_data);

        // Ajout de l'URL de l'image dans la réponse
        if ($product->img) {
            $product->image_url = asset('storage/' . $product->img);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produit mis à jour avec succès',
            'data' => $product,
        ], self::SUCCESS_STATUS_CODE);
    }

    /**
     * Supprime un produit de la base de données.
     * Supprime également l'image associée du stockage.
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            // Suppression de l'image si elle existe
            if ($product->img && Storage::disk('public')->exists($product->img)) {
                Storage::disk('public')->delete($product->img);
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produit supprimé avec succès',
            ], self::SUCCESS_STATUS_CODE);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du produit',
                'error' => $e->getMessage(),
            ], self::BAD_REQUEST_STATUS_CODE);
        }
    }

    /**
     * Récupère toutes les catégories uniques disponibles.
     * Utile pour créer des filtres dynamiques côté client.
     */
    public function categories(): JsonResponse
    {
        $categories = Product::distinct()->pluck('category')->values();

        return response()->json([
            'success' => true,
            'message' => 'Catégories récupérées avec succès',
            'data' => $categories,
        ], self::SUCCESS_STATUS_CODE);
    }

    /**
     * Récupère toutes les marques uniques disponibles.
     * Utile pour créer des filtres dynamiques côté client.
     */
    public function brands(): JsonResponse
    {
        $brands = Product::distinct()->pluck('brand')->values();

        return response()->json([
            'success' => true,
            'message' => 'Marques récupérées avec succès',
            'data' => $brands,
        ], self::SUCCESS_STATUS_CODE);
    }

    /**
     * Récupère des statistiques générales sur les produits.
     * Retourne le nombre total de produits, le stock total, les produits vedettes, etc.
     */
    public function statistics(): JsonResponse
    {
        $total_products = Product::count();
        $total_stock = Product::sum('stock');
        $featured_count = Product::featured()->count();
        $new_count = Product::new()->count();
        $out_of_stock = Product::where('stock', 0)->count();
        $categories_count = Product::distinct('category')->count('category');
        $brands_count = Product::distinct('brand')->count('brand');

        return response()->json([
            'success' => true,
            'message' => 'Statistiques récupérées avec succès',
            'data' => [
                'total_products' => $total_products,
                'total_stock' => $total_stock,
                'featured_products' => $featured_count,
                'new_products' => $new_count,
                'out_of_stock_products' => $out_of_stock,
                'total_categories' => $categories_count,
                'total_brands' => $brands_count,
            ],
        ], self::SUCCESS_STATUS_CODE);
    }
}
