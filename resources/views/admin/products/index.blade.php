@extends('layout')

@section('title', 'products')

@section('body')
    <div class="p-6">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold">products</h1>
                <p class="opacity-70">Manage your products</p>
            </div>

            <a href="{{ route('products.create') }}" class="btn btn-primary">
                + New product
            </a>
        </div>

        <div class="mt-4">
            <form method="GET" action="{{ route('products.index') }}" class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..."
                    class="input input-bordered w-full" />
                <button class="btn btn-outline">Search</button>
            </form>
        </div>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @forelse($products as $product)
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition duration-300">

                    <figure class="px-5 pt-5">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x400' }}"
                            class="rounded-xl w-full object-cover h-40" alt="{{ $product->title }}" />
                    </figure>

                    <div class="card-body pt-4">
                        <h2 class="card-title text-lg leading-tight">
                            {{ $product->title }}
                        </h2>

                        <div class="text-sm opacity-70">
                            {{ $product->created_at?->format('d/m/Y') }}
                            @if (isset($product->is_published))
                                •
                                @if ($product->is_published)
                                    <span class="badge badge-success badge-sm">Published</span>
                                @else
                                    <span class="badge badge-ghost badge-sm">Draft</span>
                                @endif
                            @endif
                        </div>

                        <div class="card-actions justify-end mt-3">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline btn-info">✏️</a>

                            <form method="POST" action="{{ route('products.destroy', $product) }}"
                                onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline btn-error">🗑</button>
                            </form>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center opacity-60 py-16">
                    No products yet.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>

    </div>
@endsection
