{{-- resources/views/home.blade.php --}}
@extends('layout')

@section('body')
<section class="max-w-6xl mx-auto px-4 py-10">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach($products as $product)
      @php
        // Image: accepte URL directe ou chemin storage
        $img = $product->image;
        $isUrl = $img && (str_starts_with($img, 'http://') || str_starts_with($img, 'https://'));
        $imgSrc = $img ? ($isUrl ? $img : asset('storage/'.$img)) : 'https://placehold.co/420x420';

        // Rating
        $rating = (float) ($product->rating ?? 0);
        $ratingCount = (int) ($product->rating_count ?? 0);

        // Prix (format FR)
        $price = number_format((float)$product->price, 2, ',', ' ') . ' €';
        $oldPrice = $product->old_price ? number_format((float)$product->old_price, 2, ',', ' ') . ' €' : null;

        // Etoiles pleines/vides (arrondi au 0.5 si tu veux, ici simple)
        $fullStars = (int) floor($rating);
        $hasHalf = ($rating - $fullStars) >= 0.5;
      @endphp

      <article class="card bg-base-100 shadow-sm border border-base-200">
        <figure class="p-6">
          <img
            src="{{ $imgSrc }}"
            alt="{{ $product->title }}"
            class="w-full max-w-[260px] mx-auto object-contain"
            loading="lazy"
          />
        </figure>

        <div class="card-body pt-0">
          <h3 class="card-title text-base font-semibold">
            {{ $product->title }}
          </h3>

          <div class="flex items-center gap-2 text-sm">
            <div class="rating rating-sm">
              {{-- 5 étoiles --}}
              @for($i=1; $i<=5; $i++)
                @php
                  $filled = $i <= $fullStars;
                  // Si tu veux gérer une demi-étoile proprement, dis-moi (daisyUI a un mask-star-2 mais pas half natif)
                @endphp
                <input
                  type="radio"
                  class="mask mask-star-2 {{ $filled ? 'bg-orange-400' : 'bg-base-300' }}"
                  aria-label="star {{ $i }}"
                  disabled
                  {{ $filled ? 'checked' : '' }}
                />
              @endfor
            </div>

            <span class="font-medium">
              {{ number_format($rating, 1, ',', ' ') }}/5
            </span>
            <span class="text-base-content/60">
              ({{ $ratingCount }})
            </span>
          </div>

          <div class="mt-2">
            <div class="text-sm text-base-content/70">À partir de</div>

            <div class="flex items-end gap-2">
              <div class="text-xl font-bold">{{ $price }}</div>

              @if($oldPrice)
                <div class="text-sm text-base-content/60 line-through pb-0.5">
                  {{ $oldPrice }}
                </div>
              @endif
            </div>

            {{-- Optionnel: petit badge "neuf" comme ton screenshot --}}
            @if($oldPrice)
              <div class="mt-1 text-sm text-base-content/60">
                <span class="line-through">{{ $oldPrice }}</span>
                <span class="ml-1">• neuf</span>
              </div>
            @endif
          </div>

          <div class="card-actions mt-4 justify-end">
            <a href="{{ route('products.show', $product->slug) }}"
               class="btn btn-primary btn-sm">
              Voir
            </a>
          </div>
        </div>
      </article>
    @endforeach

  </div>
</section>
@endsection
