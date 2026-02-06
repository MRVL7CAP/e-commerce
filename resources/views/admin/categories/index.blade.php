@extends('layout')

@section('title', 'Categorie')

@section('body')

    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Créer une catégorie</h2>
                    <form method="POST" action="{{ route('categories.store') }}" class="space-y-4">
                        @csrf

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nom</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="input input-bordered w-full" required>
                        </div>

                        <div class="card-actions justify-end">
                            <button class="btn btn-primary">Créer</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <h2 class="card-title">Catégories</h2>
                        <div class="badge badge-primary">{{ $categories->count() }}</div>
                    </div>

                    <form method="GET" action="{{ route('categories.create') }}" class="mt-2">
                        <input type="text" name="q" placeholder="Rechercher..." value="{{ request('q') }}"
                            class="input input-bordered w-full" />
                    </form>

                    <div class="mt-4 space-y-2 max-h-[420px] overflow-y-auto">
                        @forelse($categories as $category)
                            <div class="flex items-center justify-between bg-base-200 rounded-lg p-3">
                                <div class="font-medium">{{ $category->name }}</div>

                                <div class="flex gap-2">
                                    <a href="{{ route('categories.edit', $category) }}"
                                        class="btn btn-sm btn-outline btn-info">✏️</a>

                                    <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                        onsubmit="return confirm('Supprimer cette catégorie ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline btn-error">🗑</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center opacity-60 py-10">
                                Aucune catégorie pour le moment
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
