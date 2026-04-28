<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Ambil produk milik warung sendiri
    public function index()
    {
        $user     = auth()->user();
        $shop     = Shop::findOrFail($user->shop_id);
        $products = Product::where('shop_id', $shop->id)->latest()->get();

        return view('admin.shop.products', compact('shop', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'shop_id'      => auth()->user()->shop_id,
            'name'         => $request->name,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'image'        => $imagePath,
            'is_available' => $request->boolean('is_available', true),
        ]);

        return redirect()->route('dashboard',['tab' => 'stok'])
            ->with('swal', [
                'type'  => 'success',
                'title' => 'Produk Ditambahkan!',
                'text'  => $request->name . ' berhasil ditambahkan.',
            ]);
    }

    public function update(Request $request, Product $product)
    {
        // Pastikan hanya bisa edit produk milik warung sendiri
        if ($product->shop_id !== auth()->user()->shop_id) {
            abort(403);
        }

        $request->validate([
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($imagePath) Storage::disk('public')->delete($imagePath);
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'         => $request->name,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'image'        => $imagePath,
            'is_available' => $request->boolean('is_available', true),
        ]);

        return redirect()->route('dashboard',['tab' => 'stok'])
            ->with('swal', [
                'type'  => 'success',
                'title' => 'Produk Diupdate!',
                'text'  => $product->name . ' berhasil diperbarui.',
            ]);
    }

    public function destroy(Product $product)
    {
        if ($product->shop_id !== auth()->user()->shop_id) {
            abort(403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('dashboard',['tab' => 'stok'])
            ->with('swal', [
                'type'  => 'success',
                'title' => 'Produk Dihapus!',
                'text'  => 'Produk berhasil dihapus.',
            ]);
    }

    // Toggle available on/off langsung dari tabel
    public function toggleAvailable(Product $product)
    {
        if ($product->shop_id !== auth()->user()->shop_id) {
            abort(403);
        }

        $product->update(['is_available' => !$product->is_available]);

        return back()->with('swal', [
            'type'  => 'success',
            'title' => 'Status Diubah!',
            'text'  => $product->name . ' sekarang ' . ($product->is_available ? 'tersedia' : 'tidak tersedia'),
        ]);
    }
}
