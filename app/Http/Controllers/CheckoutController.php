<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
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
        if (empty($cart)) {
            return redirect()->route('home')->with('errors', 'votre panier est vide');
        }

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
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'customer_email' => Auth::user()->email,
        ]);

        return redirect($session->url);


    }

    public function success(Request $request) {


        Stripe::setApiKey(config('services.stripe.secret'));
        $sessionId = $request->input('session_id');

        try {
            $session = StripeSession::retrieve($sessionId);

            if (!$session) {
                throw new \Exception('Invalide Session');
            }

            if (Order::where('stripe_session_id', $sessionId)->exists()) {

                return redirect()->route('home')->with('success', 'Payment successful! Order already registered.');
            }

            $id = Auth::user()->id;
            $user = User::query()->findOrFail($id);

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $session->amount_total / 100,
                'status' => 'paid',
                'stripe_session_id' => $sessionId,
                'billing_address' => json_encode([
                    'address' => $user->addresses()->where('type', 'billing')->first()->address ?? null,
                    'city' => $user->addresses()->where('type', 'billing')->first()->city ?? null,
                    'zip' => $user->addresses()->where('type', 'billing')->first()->zip ?? null,
                    'country' => $user->addresses()->where('type', 'billing')->first()->country ?? null,
                ]),
                'shipping_address' => json_encode([
                    'address' => $user->addresses()->where('type', 'shipping')->first()->address ?? null,
                    'city' => $user->addresses()->where('type', 'shipping')->first()->city ?? null,
                    'zip' => $user->addresses()->where('type', 'shipping')->first()->zip ?? null,
                    'country' => $user->addresses()->where('type', 'shipping')->first()->country ?? null,
                ]),
            ]);

            $cart = Session::get('cart', []);

            $products = Product::query()->find(array_keys($cart));

            foreach ($products as $product) {
                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cart[$product->id],
                    'price' => $product->price,

                ]);
            }

            Session::forget('cart');

            return redirect()->route('home')->with('success', 'Payment successful! Order created.');
        } catch (\Exception $e) {

            return redirect()->route('home')->with('errors', $e->getMessage());
        }

    }

    public function cancel() {
        return redirect()->route("home")->with("error", "paiement annullé");
    }
}
