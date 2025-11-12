<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Contrôleur gérant toutes les opérations CRUD pour les produits.
 * Ce contrôleur suit le pattern RESTful de Laravel.
 */
class ProductController extends Controller
{
    private const ITEMS_PER_PAGE = 12;

    /**
     * Affiche la liste de tous les produits avec pagination et filtres.
     * Supporte le filtrage par catégorie, marque, et recherche textuelle.
     */
    public function index(Request $request): View
    {
        $query = Product::query();

        // Filtre par catégorie si présent
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filtre par marque si présent
        if ($request->filled('brand')) {
            $query->byBrand($request->brand);
        }

        // Recherche textuelle sur le titre et la description
        if ($request->filled('search')) {
            $search_term = $request->search;
            $query->where(function ($q) use ($search_term) {
                $q->where('title', 'like', "%{$search_term}%")
                  ->orWhere('desc', 'like', "%{$search_term}%");
            });
        }

        // Filtre produits en vedette
        if ($request->boolean('featured')) {
            $query->featured();
        }

        // Filtre nouveaux produits
        if ($request->boolean('new')) {
            $query->new();
        }

        // Tri (par défaut : plus récents en premier)
        $sort_by = $request->get('sort', 'created_at');
        $sort_order = $request->get('order', 'desc');
        $query->orderBy($sort_by, $sort_order);

        // Pagination
        $products = $query->paginate(self::ITEMS_PER_PAGE);

        // Récupération des catégories et marques uniques pour les filtres
        $categories = Product::distinct()->pluck('category');
        $brands = Product::distinct()->pluck('brand');

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau produit.
     */
    public function create(): View
    {
        $categories = Product::distinct()->pluck('category');
        $brands = Product::distinct()->pluck('brand');

        return view('products.create', compact('categories', 'brands'));
    }

    /**
     * Enregistre un nouveau produit dans la base de données.
     * Valide les données et gère l'upload de l'image.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated_data = $request->validate([
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

        // Gestion de l'upload d'image
        if ($request->hasFile('img')) {
            $image_path = $request->file('img')->store('products', 'public');
            $validated_data['img'] = $image_path;
        }

        // Gestion des booléens (checkbox non cochée = null)
        $validated_data['featured'] = $request->boolean('featured');
        $validated_data['new'] = $request->boolean('new');

        Product::create($validated_data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produit créé avec succès !');
    }

    /**
     * Affiche les détails d'un produit spécifique.
     */
    public function show(Product $product): View
    {
        // Produits similaires (même catégorie, excluant le produit actuel)
        $similar_products = Product::byCategory($product->category)
            ->where('id', '!=', $product->id)
            ->inStock()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'similar_products'));
    }

    /**
     * Affiche le formulaire d'édition d'un produit existant.
     */
    public function edit(Product $product): View
    {
        $categories = Product::distinct()->pluck('category');
        $brands = Product::distinct()->pluck('brand');

        return view('products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Met à jour un produit existant dans la base de données.
     * Gère la mise à jour de l'image si une nouvelle est uploadée.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated_data = $request->validate([
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

        // Gestion de l'upload d'une nouvelle image
        if ($request->hasFile('img')) {
            // Suppression de l'ancienne image si elle existe dans le storage
            if ($product->img && Storage::disk('public')->exists($product->img)) {
                Storage::disk('public')->delete($product->img);
            }

            $image_path = $request->file('img')->store('products', 'public');
            $validated_data['img'] = $image_path;
        }

        // Gestion des booléens
        $validated_data['featured'] = $request->boolean('featured');
        $validated_data['new'] = $request->boolean('new');

        $product->update($validated_data);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Produit mis à jour avec succès !');
    }

    /**
     * Supprime un produit de la base de données.
     * Supprime également l'image associée si elle existe.
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            // Suppression de l'image si elle existe dans le storage
            if ($product->img && Storage::disk('public')->exists($product->img)) {
                Storage::disk('public')->delete($product->img);
            }

            $product->delete();

            return redirect()
                ->route('products.index')
                ->with('success', 'Produit supprimé avec succès !');
        } catch (\Exception $e) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Erreur lors de la suppression du produit.');
        }
    }
}
