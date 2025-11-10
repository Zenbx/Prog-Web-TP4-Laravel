@extends('layouts.app')

@section('title', 'Ajouter un Produit')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Ajouter un nouveau produit</h1>
        <p class="text-gray-600">Remplissez tous les champs pour ajouter un produit à votre boutique</p>
    </div>

    <!-- Formulaire -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Titre -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Titre du produit <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title') }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror"
                    placeholder="Ex: iPhone 15 Pro Max"
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="desc" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea
                    name="desc"
                    id="desc"
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('desc') border-red-500 @enderror"
                    placeholder="Décrivez les caractéristiques principales du produit..."
                >{{ old('desc') }}</textarea>
                @error('desc')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catégorie et Marque -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="category"
                        id="category"
                        value="{{ old('category') }}"
                        list="categories-list"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('category') border-red-500 @enderror"
                        placeholder="Ex: Smartphones"
                    >
                    <datalist id="categories-list">
                        @foreach($categories as $category)
                            <option value="{{ $category }}">
                        @endforeach
                    </datalist>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">
                        Marque <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="brand"
                        id="brand"
                        value="{{ old('brand') }}"
                        list="brands-list"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('brand') border-red-500 @enderror"
                        placeholder="Ex: Apple"
                    >
                    <datalist id="brands-list">
                        @foreach($brands as $brand)
                            <option value="{{ $brand }}">
                        @endforeach
                    </datalist>
                    @error('brand')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Prix et Stock -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Prix (FCFA) <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="price"
                        id="price"
                        value="{{ old('price') }}"
                        min="0"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('price') border-red-500 @enderror"
                        placeholder="Ex: 850000"
                    >
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                        Stock disponible <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="stock"
                        id="stock"
                        value="{{ old('stock', 0) }}"
                        min="0"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('stock') border-red-500 @enderror"
                        placeholder="Ex: 5"
                    >
                    @error('stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image -->
            <div>
                <label for="img" class="block text-sm font-medium text-gray-700 mb-2">
                    Image du produit
                </label>
                <input
                    type="file"
                    name="img"
                    id="img"
                    accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('img') border-red-500 @enderror"
                >
                <p class="mt-1 text-sm text-gray-500">Formats acceptés : JPEG, PNG, JPG, GIF (Max : 2MB)</p>
                @error('img')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Checkboxes -->
            <div class="flex gap-6">
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        name="featured"
                        id="featured"
                        value="1"
                        {{ old('featured') ? 'checked' : '' }}
                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                    >
                    <label for="featured" class="ml-2 text-sm text-gray-700">
                        Produit vedette
                    </label>
                </div>

                <div class="flex items-center">
                    <input
                        type="checkbox"
                        name="new"
                        id="new"
                        value="1"
                        {{ old('new') ? 'checked' : '' }}
                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                    >
                    <label for="new" class="ml-2 text-sm text-gray-700">
                        Nouveau produit
                    </label>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex gap-4 pt-6">
                <button
                    type="submit"
                    class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold"
                >
                    Créer le produit
                </button>
                <a
                    href="{{ route('products.index') }}"
                    class="flex-1 bg-gray-200 text-gray-700 text-center px-6 py-3 rounded-lg hover:bg-gray-300 transition font-semibold"
                >
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
