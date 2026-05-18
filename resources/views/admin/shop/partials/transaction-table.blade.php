<table class="table-custom" id="tx-table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Name</th>
            <th style="width:30%;">Food or Drink</th>
            <th class="d-none d-md-table-cell">No Telepon</th>
            <th class="d-none d-md-table-cell">Total</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transactions as $tx)
        <tr>
            <td onclick="window.location='{{ $tx->confirmation_token ? route('transactions.confirmByQR', $tx->confirmation_token) : route('transactions.show', $tx->id) }}'" style="cursor:pointer;">
                {{ $tx->created_at->format('d M Y') }}<br>
                <small class="text-muted">{{ $tx->created_at->format('H:i') }}</small>
            </td>
            <td onclick="window.location='{{ $tx->confirmation_token ? route('transactions.confirmByQR', $tx->confirmation_token) : route('transactions.show', $tx->id) }}'" style="cursor:pointer;">
                {{ $tx->cashier_name }}
            </td>
            <td onclick="window.location='{{ $tx->confirmation_token ? route('transactions.confirmByQR', $tx->confirmation_token) : route('transactions.show', $tx->id) }}'" style="cursor:pointer;">
                @php
                    $items = is_array($tx->items) ? $tx->items : json_decode($tx->items, true);
                @endphp
                @if(is_array($items))
                    @foreach($items as $item)
                        <span>{{ $item['name'] }} x{{ $item['quantity'] ?? 1 }}</span><br>
                    @endforeach
                @endif
            </td>
            <td class="d-none d-md-table-cell">{{ $tx->phone }}</td>
            <td class="d-none d-md-table-cell">Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
            <td>
                @if($tx->status === 'PENDING')
                    <span class="status-siap">PENDING</span>
                @elseif($tx->status === 'SUKSES')
                    <span class="status-selesai">SUKSES ✅</span>
                @elseif($tx->status === 'DIBATALKAN')
                    <span style="color:#ef4444; font-size:0.85rem;">❌ BATAL</span>
                @else
                    <span style="color:#888; font-size:0.85rem;">{{ $tx->status }}</span>
                @endif
            </td>
            <td>
                @if(in_array($tx->status, ['PENDING', 'SUKSES']))
                <form action="{{ route('transactions.cancel', $tx->id) }}" method="POST"
                      onsubmit="return confirm('Batalkan pesanan #{{ $tx->id }} dari {{ $tx->cashier_name }}?{{ $tx->payment_method === 'saldo' && $tx->status === 'SUKSES' ? ' Saldo customer akan dikembalikan.' : '' }}')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="btn btn-sm btn-outline-danger rounded-pill px-3"
                            style="font-size:0.78rem; white-space:nowrap;">
                        ❌ Batalkan
                    </button>
                </form>
                @else
                    <span class="text-muted" style="font-size:0.78rem;">—</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center py-5 text-muted">Belum ada transaksi di periode ini.</td>
        </tr>
        @endforelse
    </tbody>
</table>
<div class="d-flex justify-content-center mt-4">
    {{ $transactions->links('pagination::bootstrap-5') }}
</div>
