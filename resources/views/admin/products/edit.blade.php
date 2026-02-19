@extends('layout')

@section('title', 'Edit product')

@section('body')
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-10">

        <div class="w-full max-w-4xl">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body p-8">

                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold">Edit product</h1>
                            <p class="opacity-70">Update product information</p>
                        </div>

                        <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">
                            ← Back
                        </a>
                    </div>

                    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data"
                        id="product-form" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf
                        @method('PUT')

                        {{-- LEFT --}}
                        <div class="space-y-5">

                            <div class="form-control">
                                <label class="label"><span class="label-text">Title</span></label>
                                <input type="text" name="title" value="{{ old('title', $product->title) }}"
                                    class="input input-bordered w-full @error('title') input-error @enderror" required>
                                @error('title')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text">Category</span></label>
                                <select name="category_id"
                                    class="select select-bordered w-full @error('category_id') select-error @enderror">
                                    <option value="">None</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id) == $cat->id)>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text">Image</span></label>
                                @if ($product->image)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            class="rounded w-24 h-24 object-cover" alt="{{ $product->title }}" />
                                    </div>
                                @endif
                                <input type="file" name="image" class="file-input file-input-bordered w-full" />
                                <label class="label">
                                    <span class="label-text-alt opacity-70">PNG/JPG, max 2MB (Leave empty to keep
                                        current)</span>
                                </label>
                                @error('image')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text">Price (€)</span></label>
                                    <input type="number" step="0.01" min="0" name="price"
                                        value="{{ old('price', $product->price) }}"
                                        class="input input-bordered w-full @error('price') input-error @enderror">
                                    @error('price')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Old price (€)</span></label>
                                    <input type="number" step="0.01" min="0" name="old_price"
                                        value="{{ old('old_price', $product->old_price) }}"
                                        class="input input-bordered w-full @error('old_price') input-error @enderror">
                                    @error('old_price')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text">Rating (0-5)</span></label>
                                    <input type="number" step="0.1" min="0" max="5" name="rating"
                                        value="{{ old('rating', $product->rating) }}"
                                        class="input input-bordered w-full @error('rating') input-error @enderror">
                                    @error('rating')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Rating count</span></label>
                                    <input type="number" min="0" name="rating_count"
                                        value="{{ old('rating_count', $product->rating_count) }}"
                                        class="input input-bordered w-full @error('rating_count') input-error @enderror">
                                    @error('rating_count')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-control">
                                <label class="cursor-pointer label justify-start gap-3">
                                    <input type="checkbox" name="is_published" class="toggle toggle-primary"
                                        @checked(old('is_published', $product->is_published)) />
                                    <span class="label-text">Published</span>
                                </label>
                            </div>

                        </div>

                        {{-- RIGHT --}}
                        <div class="space-y-5">

                            <div class="form-control">
                                <label class="label"><span class="label-text">Content</span></label>
                                <textarea name="content" rows="14"
                                    class="textarea textarea-bordered w-full @error('content') textarea-error @enderror" required>{{ old('content', $product->content) }}</textarea>
                                @error('content')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                        </div>

                    </form>

                    <div class="flex gap-3 justify-end mt-6">
                        <a href="{{ route('products.index') }}" class="btn btn-outline">Cancel</a>
                        <button type="submit" form="product-form" class="btn btn-primary">
                            Update product
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <script>
        // new SimpleMDE(document.querySelector(".textarea"))

        new MarkdownEditor('.textarea', {
            placeholder: 'Start writing...',
            toolbar: ['bold',
                'italic',
                'strikethrough',
                'ul',
                'ol',
                'checklist',
                'image',
                'link',
                'preview'
            ],
        });
    </script>
@endsection
