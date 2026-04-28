<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminKantinController extends Controller
{
    public function kasirStore(Request $request)
    {
        $request->validate([
            'cashier_name' => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'items'        => 'required|array|min:1',
            'items.*'      => 'exists:products,id',
            'quantities'   => 'required|array|min:1',
        ]);

        $user   = auth()->user();
        $shop   = Shop::findOrFail($user->shop_id);
        $items  = [];
        $total  = 0;

        DB::transaction(function () use ($request, $shop, &$items, &$total) {
            foreach ($request->items as $productId) {
                $product  = Product::findOrFail($productId);
                $quantity = (int) ($request->quantities[$productId] ?? 1);

                // Cek stok
                if ($product->stock < $quantity) {
                    throw new \Exception("Stok {$product->name} tidak cukup!");
                }

                $subtotal = $product->price * $quantity;
                $total   += $subtotal;

                $items[] = [
                    'product_id' => $product->id,
                    'name'       => $product->name,
                    'price'      => $product->price,
                    'quantity'   => $quantity,
                    'subtotal'   => $subtotal,
                ];

                // Kurangi stok
                $product->decrement('stock', $quantity);
            }

            // Tambah balance warung
            $shop->increment('balance', $total);

            // Buat transaksi langsung SUKSES
            Transaction::create([
                'shop_id'      => $shop->id,
                'user_id'      => auth()->id(),
                'cashier_name' => $request->cashier_name,
                'phone'        => $request->phone,
                'items'        => $items,
                'total'        => $total,
                'status'       => 'SUKSES',
                'confirmed_at' => now(),
                'notes'        => $request->notes,
            ]);
        });

        return redirect()->route('dashboard')->with('swal', [
            'type'  => 'success',
            'title' => 'Transaksi Berhasil!',
            'text'  => 'Total: Rp ' . number_format($total, 0, ',', '.'),
        ]);
    }
}
