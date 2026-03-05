<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Termwind\Components\Raw;

class CartController extends Controller
{
    public function store(Request $request)
    {
        //valider les donner
        //acceder au panier depuis la session
        //cree si il existe pas
        //ajouter le produit dans le panier
        //si il existe deja incrementer la quantiter
        //rediriger vers une autre page

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product_id = $request->product_id;
        $quantity = (int)$request->quantity;

        $cart = session()->get("cart", []);

        if (isset($cart[$product_id])) {
            dump("dfgldfgdlf");
            $cart[$product_id] += $quantity;
        } else {
            $cart[$product_id] = $quantity;
        }

        session()->put("cart", $cart);
        dd(session()->get("cart", []));
       // return redirect()->back()->with("success", "produit ajoute au panier");


    }
}
