@extends('layout')

@section('title', 'Modifier categorie')

@section('body')

<div class="min-h-[70vh] flex items-center justify-center px-4">

    <div class="w-full max-w-3xl">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-8">

                <div class="flex items-center justify-between mb-4">
                    <h2 class="card-title text-2xl font-bold">
                        Modifier la catégorie
                    </h2>

                    <a href="{{ route('categories.index') }}"
                       class="btn btn-sm btn-outline">
                        ← Retour
                    </a>
                </div>

                <form method="POST"
                      action="{{ route('categories.update', $category) }}"
                      class="space-y-6">

                    @csrf
                    @method('PUT')

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-base">
                                Nom
                            </span>
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name', $category->name) }}"
                               class="input input-bordered input-lg w-full"
                               required>
                    </div>

                    <div class="card-actions justify-end pt-4">
                        <button class="btn btn-primary btn-lg">
                            Enregistrer
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>

@endsection
