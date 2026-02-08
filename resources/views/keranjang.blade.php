@extends('layouts.app') {{-- Atau sesuaikan template lu --}}
@section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4"><i class="bi bi-cart-fill text-warning"></i> Keranjang Saya</h3>

    @if(session('cart'))
        <div class="row">
            <div class="col-md-8">
                @foreach(session('cart') as $id => $details)
                    <div class="card mb-3 border-0 shadow-sm rounded-4">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $details['image'] }}" width="60" class="rounded shadow-sm">
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $details['name'] }}</h6>
                                    <small class="text-warning">Rp {{ number_format($details['price']) }}</small>
                                </div>
                            </div>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button class="btn btn-link text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-light">
                    <h5>Ringkasan</h5>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Item:</span>
                        <span class="fw-bold">{{ count(session('cart')) }}</span>
                    </div>
                    <a href="{{ route('order.show', [
                        'menu' => implode(', ', array_column(session('cart'), 'name')),
                        'harga' => array_sum(array_column(session('cart'), 'price')),
                        'shop_id' => session('cart')[0]['shop_id']
                    ]) }}" class="btn btn-warning w-100 text-white fw-bold rounded-pill p-2">
                        Lanjut Konfirmasi
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x fs-1 text-secondary"></i>
            <p class="mt-3">Keranjang lu masih kosong, bro!</p>
            <a href="{{ route('customer.menu') }}" class="btn btn-warning text-white rounded-pill px-4">Cari Makan</a>
        </div>
    @endif
</div>
@endsection
