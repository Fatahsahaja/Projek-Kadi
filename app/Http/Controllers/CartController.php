<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        $product = Product::with('shop')->findOrFail($request->product_id);

        if (!$product->is_available || $product->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, menu ini sudah habis!');
        }

        $cart = session()->get('cart', []);

        // Cek kalau keranjang sudah ada item dari warung LAIN
        if (!empty($cart) && $cart[0]['shop_id'] !== $product->shop_id) {
            $namaWarungLama = $cart[0]['shop_name'] ?? 'warung sebelumnya';
            return redirect()->back()->with('error',
                'Keranjangmu masih ada pesanan dari ' . $namaWarungLama . '. ' .
                'Selesaikan atau kosongkan dulu sebelum pesan dari warung lain.'
            );
        }

        // Cek kalau item sudah ada di cart, tambah quantity aja
        $found = false;
        foreach ($cart as &$item) {
            if ($item['product_id'] === $product->id) {
                // Cek stok tidak melebihi yang tersedia
                if ($item['quantity'] >= $product->stock) {
                    return redirect()->back()->with('error', 'Stok tidak mencukupi!');
                }
                $item['quantity']++;
                $item['subtotal'] = $item['price'] * $item['quantity'];
                $found = true;
                break;
            }
        }

        // Kalau belum ada, tambah item baru
        if (!$found) {
            $cart[] = [
                'product_id' => $product->id,
                'shop_id'    => $product->shop_id,
                'shop_name'  => $product->shop->name ?? '',
                'name'       => $product->name,
                'price'      => $product->price,
                'quantity'   => 1,
                'subtotal'   => $product->price,
                'image'      => $product->image,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu ditambah ke keranjang!');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            // Re-index array biar tidak bolong
            $cart = array_values($cart);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item dihapus dari keranjang!');
    }
}
