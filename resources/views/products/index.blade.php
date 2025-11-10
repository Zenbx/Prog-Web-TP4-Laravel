@extends('layouts.app')

@section('title', 'Liste des Produits')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- En-tête avec statistiques -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Catalogue Produits</h1>
        <p class="text-gray-600">{{ $products->total() }} produits disponibles</p>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Recherche -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                <input
                    type="text"
                    name="search"
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="Rechercher..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <!-- Catégorie -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                <select
                    name="category"
                    id="category"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Marque -->
            <div>
                <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Marque</label>
                <select
                    name="brand"
                    id="brand"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option value="">Toutes les marques</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                            {{ $brand }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tri -->
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                <select
                    name="sort"
                    id="sort"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Plus récents</option>
                    <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Prix</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Nom</option>
                    <option value="stock" {{ request('sort') == 'stock' ? 'selected' : '' }}>Stock</option>
                </select>
            </div>

            <!-- Boutons d'action -->
            <div class="md:col-span-4 flex gap-2">
                <button
                    type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Filtrer
                </button>
                <a
                    href="{{ route('products.index') }}"
                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 transition"
                >
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Grille de produits -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($products as $product)
                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Image du produit -->
                    <div class="relative h-64 bg-gray-200">
                        @if($product->img)
                            <img
                                src="{{ asset('storage/' . $product->img) }}"
                                alt="{{ $product->title }}"
                                class="w-full h-full object-cover"
                            >
                        @else
                            <div class="flex items-center justify-center h-full">
                                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif

                        <!-- Badges -->
                        <div class="absolute top-2 left-2 flex gap-2">
                            @if($product->featured)
                                <span class="badge-featured text-white text-xs font-bold px-3 py-1 rounded-full">
                                    VEDETTE
                                </span>
                            @endif
                            @if($product->new)
                                <span class="badge-new text-white text-xs font-bold px-3 py-1 rounded-full">
                                    NOUVEAU
                                </span>
                            @endif
                        </div>

                        <!-- Indicateur de stock -->
                        @if(!$product->isInStock())
                            <div class="absolute bottom-2 right-2">
                                <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                    RUPTURE
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Informations du produit -->
                    <div class="p-4">
                        <!-- Catégorie et Marque -->
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-gray-500 uppercase tracking-wide">{{ $product->category }}</span>
                            <span class="text-xs text-indigo-600 font-semibold">{{ $product->brand }}</span>
                        </div>

                        <!-- Titre -->
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                            {{ $product->title }}
                        </h3>

                        <!-- Description courte -->
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                            {{ $product->desc }}
                        </p>

                        <!-- Prix et Stock -->
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-2xl font-bold text-indigo-600">
                                    {{ $product->formatted_price }}
                                </span>
                                <span class="text-sm text-gray-500"> FCFA</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                Stock : <span class="font-semibold">{{ $product->stock }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <a
                                href="{{ route('products.show', $product) }}"
                                class="flex-1 bg-indigo-600 text-white text-center px-4 py-2 rounded-md hover:bg-indigo-700 transition text-sm font-medium"
                            >
                                Voir Détails
                            </a>
                            <a
                                href="{{ route('products.edit', $product) }}"
                                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <!-- Message si aucun produit -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun produit trouvé</h3>
            <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche ou de réinitialiser les filtres.</p>
            <a
                href="{{ route('products.index') }}"
                class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 transition"
            >
                Voir tous les produits
            </a>
        </div>
    @endif
</div>
@endsection
