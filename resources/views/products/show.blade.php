@extends('layout')

@section('body')
@php

  if (!empty($product->image)) {
      $isUrl = str_starts_with($product->image, 'http://') || str_starts_with($product->image, 'https://');
      $imgSrc = $isUrl ? $product->image : asset('storage/'.$product->image);
  } else {
      $imgSrc = 'https://placehold.co/900x900?text=Produit';
  }

  $rating = (float) ($product->rating ?? 0);
  $ratingCount = (int) ($product->rating_count ?? 0);
  $fullStars = (int) floor($rating);

  $price = number_format((float)$product->price, 2, ',', ' ') . ' €';
  $oldPrice = $product->old_price ? number_format((float)$product->old_price, 2, ',', ' ') . ' €' : null;
@endphp

<section class="max-w-6xl mx-auto px-4 py-8">
  {{-- Breadcrumb --}}
  <div class="text-sm breadcrumbs mb-6">
    <ul>
      <li><a href="{{ route('home') }}">Accueil</a></li>
      @if($product->category)
        <li>
          <a href="{{ route('home', ['category' => $product->category_id]) }}">
            {{ $product->category->title ?? 'Catégorie' }}
          </a>
        </li>
      @endif
      <li>{{ $product->title }}</li>
    </ul>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- Image --}}
    <div class="card bg-base-100 border border-base-200 shadow-sm">
      <figure class="p-6">
        <img
          src="{{ $imgSrc }}"
          alt="{{ $product->title }}"
          class="w-full max-h-[520px] object-contain rounded-xl"
          loading="lazy"
        />
      </figure>
    </div>

    {{-- Infos --}}
    <div class="space-y-4">
      <div class="flex flex-wrap items-center gap-2">
        <h1 class="text-2xl font-bold">{{ $product->title }}</h1>

        @if($product->category)
          <span class="badge badge-outline">
            {{ $product->category->title ?? 'Catégorie' }}
          </span>
        @endif
      </div>

      {{-- Rating --}}
      <div class="flex items-center gap-2">
        <div class="rating rating-sm">
          @for($i=1; $i<=5; $i++)
            @php $filled = $i <= $fullStars; @endphp
            <input
              type="radio"
              class="mask mask-star-2 {{ $filled ? 'bg-orange-400' : 'bg-base-300' }}"
              disabled
              {{ $filled ? 'checked' : '' }}
            />
          @endfor
        </div>

        <span class="font-medium">{{ number_format($rating, 1, ',', ' ') }}/5</span>
        <span class="text-base-content/60">({{ $ratingCount }} avis)</span>
      </div>

      {{-- Prix --}}
      <div class="card bg-base-100 border border-base-200">
        <div class="card-body">
          <div class="text-sm text-base-content/70">À partir de</div>

          <div class="flex items-end gap-3">
            <div class="text-3xl font-bold">{{ $price }}</div>

            @if($oldPrice)
              <div class="text-base text-base-content/60 line-through pb-1">
                {{ $oldPrice }}
              </div>
            @endif
          </div>

          @if($oldPrice)
            <div class="text-sm text-base-content/60 mt-1">
              Prix neuf : <span class="line-through">{{ $oldPrice }}</span>
            </div>
          @endif

          <div class="card-actions mt-4">
            {{-- Boutons (adapte à ton système: panier, contact, etc.) --}}
            <form action="{{route ('cart.store')}}" method="POST">
            @csrf
            <input name="product_id" value="{{ $product->id }}" type="hidden">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-primary flex-1">Ajouter au panier</button>
            </form>
            <a href="{{ route('home') }}" class="btn btn-ghost">Retour</a>
          </div>
        </div>
      </div>

      {{-- Description --}}
      <div class="card bg-base-100 border border-base-200">
        <div class="card-body">
          <h2 class="card-title text-lg">Description</h2>

          @if(!empty($product->content))
            <div class="prose lg:prose-xl">
              {!! $product->content !!}
            </div>
          @else
            <p class="text-base-content/70">
              Aucune description disponible pour ce produit.
            </p>
          @endif
        </div>
      </div>

      {{-- Infos rapides (optionnel) --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="stats shadow border border-base-200 bg-base-100">
          <div class="stat">
            <div class="stat-title">Disponibilité</div>
            <div class="stat-value text-lg">En stock</div>
            <div class="stat-desc">Livraison selon options</div>
          </div>
        </div>

        <div class="stats shadow border border-base-200 bg-base-100">
          <div class="stat">
            <div class="stat-title">Référence</div>
            <div class="stat-value text-lg">#{{ $product->id }}</div>
            <div class="stat-desc">Slug : {{ $product->slug }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
