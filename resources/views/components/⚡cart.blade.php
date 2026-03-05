<?php

use Livewire\Component;
use App\Models\Product;


new class extends Component
{
    public $cart = [];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function getCartItemProperty()
    {
        if(empty($this->cart)) {
            return [];
        }

        $products = Product::find(array_keys($this->cart));
        $items = [];

        foreach ($products as $product) {
            $items[] = [
                'product' => $product,
                'quantity' => $this->cart[$product->id],
                'subtotal' => $product->price * $this->cart[$product->id]
        ];
        }
        return $items;
    }


    public function increment () {
        dd('increment');
    }
    public function decrement () {
        dd('decrement');
    }

};
?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Panier</h1>

    @if (empty($this->getCartItemProperty()))
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
                    @foreach ($this->getCartItemProperty() as $item)
                        <tr>
                            <td class="flex items-center space-x-4">
                                @if (isset($item['product']->image))
                                    <img src="{{ $item['product']->image }}" alt="{{ $item['product']->name }}"
                                        class="w-16 h-16 object-cover rounded">
                                @endif
                                <span>{{ $item['product']->title }}</span>
                            </td>
                            <td>
                                <button wire:click="decrement">-</button>
                                {{ $item['quantity'] }}
                                <button wire:click="increment">+</button>
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
                        Total : {{ number_format(collect($this->getCartItemProperty())->sum('subtotal'), 2) }} €
                    </h2>
                    <button class="btn btn-primary mt-3">Passer à la commande</button>
                </div>
            </div>
        </div>
    @endif
</div>
