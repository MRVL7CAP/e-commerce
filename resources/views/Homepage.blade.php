@extends('layout')

@section('title', 'Accueil')

@section('body')

<div class="container">
    <h1>Bienvenue sur notre site de vente de produits en ligne !</h1>
    <p>Découvrez notre large sélection de produits de qualité à des prix compétitifs. Que vous cherchiez des vêtements, des accessoires, des gadgets ou des articles pour la maison, nous avons tout ce dont vous avez besoin.</p>
    <p>Profitez de nos offres spéciales et de nos promotions exclusives pour faire de bonnes affaires. Notre équipe est dédiée à vous offrir une expérience d'achat agréable et sécurisée.</p>
    <p>N'hésitez pas à parcourir notre catalogue et à nous contacter si vous avez des questions ou besoin d'assistance. Nous sommes là pour vous aider !</p>
</div>

<h2>Produits</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($products as $product)
        <div class="card bg-base-100 shadow-xl">
            <figure><img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover"></figure>
            <div class="card-body">
                <h3 class="card-title">{{ $product->name }}</h3>
                <p>{{ $product->description }}</p>
                <div class="card-actions justify-end">
                    <span class="text-lg font-bold text-primary">${{ $product->price }}</span>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Voir le produit</a>
                    <p>prix : ${{ $product->price }}</p>
                    <p>catégorie : {{ $product->category->name ?? 'Aucune catégorie' }}</p>
                </div>
@endforeach

<h2>Catégories</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($categories as $category)
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h3 class="card-title">{{ $category->name }}</h3>
                <p>{{ $category->description }}</p>
                <div class="card-actions justify-end">
                    <a href="{{ route('categories.show', $category->id) }}" class="btn btn-secondary">Voir la catégorie</a>
                </div>
            </div>
        </div>
    @endforeach
{{ $collection->links() }}
            </div> class="mt-4">
            {{ $products->links() }}
        </div>
@endsection
