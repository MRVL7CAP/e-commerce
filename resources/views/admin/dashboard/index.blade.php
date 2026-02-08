@extends('layout')

@section('title', 'Admin')

@section('body')

<div class="min-h-[70vh] flex items-center justify-center px-4">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl">

        <a href="{{ route('products.index') }}"
           class="card bg-base-100 shadow-xl hover:shadow-2xl transition duration-300 hover:-translate-y-1">

            <div class="card-body items-center text-center p-10">

                <div class="text-5xl mb-4">📰</div>

                <h2 class="card-title text-2xl font-bold">
                    Articles
                </h2>

                <p class="opacity-70">
                    Gérer les articles du site
                </p>

                <div class="mt-4">
                    <span class="btn btn-primary btn-lg">
                        Voir les articles
                    </span>
                </div>

            </div>
        </a>

        <a href="{{ route('categories.index') }}"
           class="card bg-base-100 shadow-xl hover:shadow-2xl transition duration-300 hover:-translate-y-1">

            <div class="card-body items-center text-center p-10">

                <div class="text-5xl mb-4">📂</div>

                <h2 class="card-title text-2xl font-bold">
                    Catégories
                </h2>

                <p class="opacity-70">
                    Gérer les catégories
                </p>

                <div class="mt-4">
                    <span class="btn btn-secondary btn-lg">
                        Voir les catégories
                    </span>
                </div>

            </div>
        </a>

    </div>

</div>

@endsection
