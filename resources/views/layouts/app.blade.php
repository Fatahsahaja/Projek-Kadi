<x-app-layout>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-8 text-center">

        {{-- Icon sukses --}}
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-1">Pesanan Berhasil! 🎉</h1>
        <p class="text-gray-500 mb-6">Tunjukkan QR Code ini ke Admin Kantin</p>

        {{-- QR Code --}}
        <div class="bg-gray-50 rounded-xl p-4 mb-6 inline-block">
            <img
                src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($qrUrl) }}"
                alt="QR Code Pesanan"
                class="mx-auto rounded-lg"
            />
        </div>

        {{-- Detail Pesanan --}}
        <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left">
            <h3 class="font-semibold text-gray-700 mb-3">Detail Pesanan</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">No. Pesanan</span>
                    <span class="font-medium">#{{ $transaction->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Warung</span>
                    <span class="font-medium">{{ $transaction->shop->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Total</span>
                    <span class="font-semibold text-green-600">
                        Rp {{ number_format($transaction->total, 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                        {{ $transaction->status }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Items --}}
        <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left">
            <h3 class="font-semibold text-gray-700 mb-3">Item Pesanan</h3>
            <div class="space-y-2 text-sm">
                @php
                    $items = is_array($transaction->items)
                        ? $transaction->items
                        : json_decode($transaction->items, true);
                @endphp

                @foreach($items as $item)
                <div class="flex justify-between">
                    <span class="text-gray-600">
                        {{ $item['name'] }}
                        <span class="text-gray-400">x{{ $item['quantity'] ?? 1 }}</span>
                    </span>
                    <span class="font-medium">
                        Rp {{ number_format($item['subtotal'] ?? $item['price'], 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Catatan --}}
        @if($transaction->notes)
        <div class="bg-yellow-50 rounded-xl p-3 mb-6 text-left text-sm">
            <span class="text-yellow-700">📝 Catatan: {{ $transaction->notes }}</span>
        </div>
        @endif

        {{-- Tombol --}}
        <div class="space-y-3">
            <a href="{{ route('dashboard') }}"
               class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl transition">
                Kembali ke Dashboard
            </a>
            <a href="{{ route('customer.menu') }}"
               class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 rounded-xl transition">
                Pesan Lagi
            </a>
        </div>

    </div>
</div>

</x-app-layout>
