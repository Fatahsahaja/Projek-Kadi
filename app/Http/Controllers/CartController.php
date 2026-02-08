<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('keranjang', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);

        // Tambah data ke array session
        $cart[] = [
            "name" => $request->menu,
            "price" => $request->harga,
            "shop_id" => $request->shop_id,
            "image" => $request->image
        ];

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu ditambah ke keranjang!');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }
}
