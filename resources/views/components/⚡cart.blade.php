<?php

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

new class extends Component {
    public $cart = [];

    public function mount()
    {
        $this->cart = Session::get('cart', []);
    }

    public function getCartItemsProperty()
    {
        if (empty($this->cart)) {
            return [];
        }

        $products = Product::find(array_keys($this->cart));
        $items = [];

        foreach ($products as $product) {
            $items[] = [
                'product' => $product,
                'quantity' => $this->cart[$product->id],
                'subtotal' => $product->price * $this->cart[$product->id],
            ];
        }
        return $items;
    }

    public function updateSession(): void
    {
        Session::put('cart', $this->cart);
    }

    public function increment(int $id): void
    {
        if (isset($this->cart[$id])) {
            $this->cart[$id]++;
            $this->updateSession();
            $this->cart = $this->cart; // Trigger reactivity
        }
    }
    public function decrement(int $id): void
    {
        if (isset($this->cart[$id])) {
            if ($this->cart[$id] > 1) {
                $this->cart[$id]--;
                $this->updateSession();
            }
        }
    }

    public function remove(int $id): void
    {
        if (isset($this->cart[$id])) {
            unset($this->cart[$id]);
            $this->updateSession();
        }
    }

    public function getTotalProperty()
    {
        $total = 0;
        foreach ($this->cartItems as $item) {
            $total += $item['subtotal'];
        }
        return $total;
    }
};
?>



<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Panier</h1>

    @if (empty($this->cartItems))
        <p class="text-gray-500">Votre panier est vide.</p>
    @else
        <div class="overflow-x-auto">
            <table class="table w-full">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                        <th>Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->cartItems as $item)
                        <tr>
                            <td class="flex items-center space-x-4">
                                @if (isset($item['product']->image))
                                    <img src="{{ $item['product']->image }}" alt="{{ $item['product']->name }}"
                                        class="w-16 h-16 object-cover rounded">
                                @endif
                                <span>{{ $item['product']->title }}</span>
                            </td>
                            <td>
                                <button wire:click="decrement({{ $item['product']->id }})">-</button>
                                {{ $item['quantity'] }}
                                <button wire:click="increment({{ $item['product']->id }})">+</button>
                            </td>
                            <td>{{ number_format($item['product']->price, 2) }} €</td>
                            <td>{{ number_format($item['subtotal'], 2) }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex justify-end mt-6">
                <div class="text-right">
                    <h2 class="text-xl font-semibold">
                        Total : {{ number_format($this->total, 2) }} €
                    </h2>
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <button class="btn btn-primary mt-3">Passer à la commande</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
