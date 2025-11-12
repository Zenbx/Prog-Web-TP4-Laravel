@extends('layouts.app')

@section('title', $product->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-indigo-600">
                    Produits
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-gray-500">{{ $product->title }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Contenu principal -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">
        <!-- Image du produit -->
        <div class="space-y-4">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                @if($product->img)
                    <img
                        src="{{ asset('storage/' . $product->img) }}"
                        alt="{{ $product->title }}"
                        class="w-full h-96 object-cover"
                    >
                @else
                    <div class="flex items-center justify-center h-96 bg-gray-200">
                        <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Badges -->
            <div class="flex gap-3">
                @if($product->featured)
                    <span class="badge-featured text-white text-sm font-bold px-4 py-2 rounded-full">
                        ⭐ PRODUIT VEDETTE
                    </span>
                @endif
                @if($product->new)
                    <span class="badge-new text-white text-sm font-bold px-4 py-2 rounded-full">
                        ✨ NOUVEAU
                    </span>
                @endif
            </div>
        </div>

        <!-- Informations du produit -->
        <div class="space-y-6">
            <!-- Catégorie et Marque -->
            <div class="flex items-center gap-4">
                <span class="bg-indigo-100 text-indigo-800 text-sm font-semibold px-4 py-2 rounded-full">
                    {{ $product->category }}
                </span>
                <span class="bg-gray-100 text-gray-800 text-sm font-semibold px-4 py-2 rounded-full">
                    {{ $product->brand }}
                </span>
            </div>

            <!-- Titre -->
            <h1 class="text-4xl font-bold text-gray-900">
                {{ $product->title }}
            </h1>

            <!-- Prix -->
            <div class="bg-indigo-50 rounded-lg p-6">
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-indigo-600">
                        {{ $product->formatted_price }}
                    </span>
                    <span class="text-2xl text-gray-600">FCFA</span>
                </div>
            </div>

            <!-- Statut du stock -->
            <div class="flex items-center gap-3">
                @if($product->isInStock())
                    <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-lg text-green-600 font-semibold">
                        En stock ({{ $product->stock }} disponibles)
                    </span>
                @else
                    <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-lg text-red-600 font-semibold">Rupture de stock</span>
                @endif
            </div>

            <!-- Description -->
            <div class="border-t border-gray-200 pt-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-3">Description</h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ $product->desc ?? 'Aucune description disponible pour ce produit.' }}
                </p>
            </div>

            <!-- Actions -->
            <div class="flex gap-4 pt-6">
                <a
                    href="{{ route('products.edit', $product) }}"
                    class="flex-1 bg-indigo-600 text-white text-center px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>

                <form action="{{ route('products.destroy', $product) }}" method="POST" class="flex-1" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Supprimer
                    </button>
                </form>
            </div>

            <!-- Informations supplémentaires -->
            <div class="bg-gray-50 rounded-lg p-6 space-y-3">
                <h3 class="font-semibold text-gray-900 mb-4">Informations supplémentaires</h3>
                <div class="flex justify-between">
                    <span class="text-gray-600">Référence :</span>
                    <span class="font-semibold text-gray-900">#{{ $product->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Catégorie :</span>
                    <span class="font-semibold text-gray-900">{{ $product->category }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Marque :</span>
                    <span class="font-semibold text-gray-900">{{ $product->brand }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Ajouté le :</span>
                    <span class="font-semibold text-gray-900">{{ $product->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Produits similaires -->
    @if($similar_products->count() > 0)
        <div class="border-t border-gray-200 pt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Produits similaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($similar_products as $similar_product)
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="relative h-48 bg-gray-200">
                            @if($similar_product->img)
                                <img
                                    src="{{ asset('storage/' . $similar_product->img) }}"
                                    alt="{{ $similar_product->title }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-gray-900 mb-2 line-clamp-2">
                                {{ $similar_product->title }}
                            </h3>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-indigo-600">
                                    {{ $similar_product->formatted_price }} FCFA
                                </span>
                                <a
                                    href="{{ route('products.show', $similar_product) }}"
                                    class="text-indigo-600 hover:text-indigo-700 text-sm font-medium"
                                >
                                    Voir →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
