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

        <div class="mt-6 overflow-x-auto bg-base-100 rounded-lg shadow">
            @forelse($products as $product)
                @if ($loop->first)
                    <table class="table table-zebra w-full">
                        <thead class="bg-base-200">
                            <tr>
                                <th class="text-base font-semibold">Image</th>
                                <th class="text-base font-semibold">Title</th>
                                <th class="text-base font-semibold">Price</th>
                                <th class="text-base font-semibold">Created</th>
                                <th class="text-base font-semibold">Status</th>
                                <th class="text-base font-semibold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                @endif
                            <tr class="hover:bg-base-200 transition">
                                <td>
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/100x80' }}"
                                        class="rounded w-16 h-12 object-cover" alt="{{ $product->title }}" />
                                </td>
                                <td>
                                    <p class="font-semibold">{{ $product->title }}</p>
                                </td>
                                <td>
                                    <p class="font-semibold text-lg">{{ number_format($product->price, 2) }} €</p>
                                </td>
                                <td>
                                    <p class="text-sm opacity-70">{{ $product->created_at?->format('d/m/Y') }}</p>
                                </td>
                                <td>
                                    @if (isset($product->is_published))
                                        @if ($product->is_published)
                                            <span class="badge badge-success badge-sm">Published</span>
                                        @else
                                            <span class="badge badge-ghost badge-sm">Draft</span>
                                        @endif
                                    @else
                                        <span class="badge badge-warning badge-sm">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-xs btn-outline btn-info">✏️</a>
                                        <form method="POST" action="{{ route('products.destroy', $product) }}"
                                            onsubmit="return confirm('Delete this product?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-xs btn-outline btn-error">🗑</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                @if ($loop->last)
                        </tbody>
                    </table>
                @endif
            @empty
                <div class="p-12 text-center opacity-60">
                    <p class="text-lg">No products yet.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>

    </div>
@endsection
