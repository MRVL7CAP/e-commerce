<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cart = Session::get('cart', []);
        if (empty('cart')) {
            return redirect()->route('home')->with('errors', 'votre panier est vide');
        };

        Stripe::setApiKey(config('services.stripe.secret'));

        $products = Product::find(array_keys($cart));
        $lineItems = [];

        foreach ($products as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $product->title,
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $cart[$product->id]
            ];
        }

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHEKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'customer_email' => Auth::user()->email,
        ]);

        return redirect($session->url);


    }

    public function success() {
        dd('success');
    }

    public function cancel() {
        dd('cancel');
    }
}
