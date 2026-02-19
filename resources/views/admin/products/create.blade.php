@extends('layout')

@section('title', 'Create product')

@section('body')
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-10">

        <div class="w-full max-w-4xl">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body p-8">

                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold">Create product</h1>
                            <p class="opacity-70">Add a new product</p>
                        </div>

                        <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">
                            ← Back
                        </a>
                    </div>

                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data"
                        class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf

                        {{-- LEFT --}}
                        <div class="space-y-5">

                            <div class="form-control">
                                <label class="label"><span class="label-text">Title</span></label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="input input-bordered w-full" required>
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text">Category</span></label>
                                <select name="category_id" class="select select-bordered w-full">
                                    <option value="">None</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text">Image</span></label>
                                <input type="file" name="image" class="file-input file-input-bordered w-full" />
                                <label class="label">
                                    <span class="label-text-alt opacity-70">PNG/JPG, max 2MB</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text">Price (€)</span></label>
                                    <input type="number" step="0.01" min="0" name="price"
                                        value="{{ old('price') }}" class="input input-bordered w-full">
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Old price (€)</span></label>
                                    <input type="number" step="0.01" min="0" name="old_price"
                                        value="{{ old('old_price') }}" class="input input-bordered w-full">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text">Rating (0-5)</span></label>
                                    <input type="number" step="0.1" min="0" max="5" name="rating"
                                        value="{{ old('rating') }}" class="input input-bordered w-full">
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Rating count</span></label>
                                    <input type="number" min="0" name="rating_count"
                                        value="{{ old('rating_count', 0) }}" class="input input-bordered w-full">
                                </div>
                            </div>

                            <div class="form-control">
                                <label class="cursor-pointer label justify-start gap-3">
                                    <input type="checkbox" name="is_published" class="toggle toggle-primary"
                                        @checked(old('is_published')) />
                                    <span class="label-text">Published</span>
                                </label>
                            </div>

                        </div>

                        {{-- RIGHT --}}
                        <div class="space-y-5">

                            <div class="form-control">
                                <label class="label"><span class="label-text">Content</span></label>
                                <textarea name="content" rows="14" class="textarea textarea-bordered w-full" required>{{ old('content') }}</textarea>
                            </div>

                            <div class="flex justify-end gap-2">
                                <a href="{{ route('products.index') }}" class="btn btn-ghost">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-lg">Create</button>
                            </div>

                        </div>

                    </form>

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
