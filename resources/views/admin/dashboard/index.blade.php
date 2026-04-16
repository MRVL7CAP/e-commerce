@extends('layout')

@section('title', 'Admin')

@section('body')

<div class="max-w-7xl mx-auto px-4 py-10 space-y-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-8">
                <h1 class="text-3xl font-bold mb-4">Tableau de bord admin</h1>
                <p class="text-base-content/70">Vue d'ensemble des ventes et des performances produits.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="card bg-base-100 shadow-xl p-6">
                <p class="text-sm uppercase text-base-content/60">Ventes totales</p>
                <p class="text-3xl font-semibold mt-3">{{ number_format($totalSales, 2, ',', ' ') }} €</p>
            </div>
            <div class="card bg-base-100 shadow-xl p-6">
                <p class="text-sm uppercase text-base-content/60">Commandes totales</p>
                <p class="text-3xl font-semibold mt-3">{{ $totalOrders }}</p>
            </div>
            <div class="card bg-base-100 shadow-xl p-6">
                <p class="text-sm uppercase text-base-content/60">Commandes payées</p>
                <p class="text-3xl font-semibold mt-3">{{ $paidOrders }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-[1.4fr_1fr] gap-8">
        <div class="space-y-8">
            <div class="card bg-base-100 shadow-xl overflow-hidden">
                <div class="card-body p-6">
                    <h2 class="text-xl font-semibold mb-4">Ventes par trimestre</h2>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Trimestre</th>
                                    <th>Revenu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($salesByQuarter as $quarter)
                                    <tr>
                                        <td>{{ $quarter->quarter }}</td>
                                        <td>{{ number_format($quarter->revenue, 2, ',', ' ') }} €</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-6">Aucune vente enregistrée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl overflow-hidden">
                <div class="card-body p-6">
                    <h2 class="text-xl font-semibold mb-4">Meilleures ventes par produit</h2>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Revenu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $product)
                                    <tr>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->units }}</td>
                                        <td>{{ number_format($product->revenue, 2, ',', ' ') }} €</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-6">Aucun produit vendu.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="card bg-base-100 shadow-xl overflow-hidden">
                <div class="card-body p-6">
                    <h2 class="text-xl font-semibold mb-4">Ventes par catégorie</h2>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Catégorie</th>
                                    <th>Revenu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($salesByCategory as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ number_format($category->revenue, 2, ',', ' ') }} €</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-6">Aucune vente par catégorie.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <a href="{{ route('products.index') }}"
               class="card bg-base-100 shadow-xl hover:shadow-2xl transition duration-300 hover:-translate-y-1">
                <div class="card-body items-center text-center p-10">
                    <div class="text-5xl mb-4">📰</div>
                    <h2 class="card-title text-2xl font-bold">Articles</h2>
                    <p class="opacity-70">Gérer les articles du site</p>
                    <div class="mt-4">
                        <span class="btn btn-primary btn-lg">Voir les articles</span>
                    </div>
                </div>
            </a>

            <a href="{{ route('categories.index') }}"
               class="card bg-base-100 shadow-xl hover:shadow-2xl transition duration-300 hover:-translate-y-1">
                <div class="card-body items-center text-center p-10">
                    <div class="text-5xl mb-4">📂</div>
                    <h2 class="card-title text-2xl font-bold">Catégories</h2>
                    <p class="opacity-70">Gérer les catégories</p>
                    <div class="mt-4">
                        <span class="btn btn-secondary btn-lg">Voir les catégories</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection
