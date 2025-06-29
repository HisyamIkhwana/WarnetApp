@extends('layouts.kasir')
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold leading-6 text-white">Riwayat Transaksi</h1>
            <p class="mt-2 text-sm text-gray-400">Daftar semua transaksi penjualan yang telah selesai.</p>
        </div>
        {{-- Di sini bisa ditambahkan tombol filter atau export jika diperlukan --}}
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-white/10 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-slate-700">
                        <thead class="bg-slate-800">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">ID Pesanan</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Tanggal</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Pelanggan</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Detail Item</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse ($transaksis as $transaksi)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-6">#{{ $transaksi->pesanan_id }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ $transaksi->created_at->format('d M Y, H:i') }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                    {{ $transaksi->pesanan->nama_pelanggan ?? '-' }}
                                    @if($transaksi->pesanan->no_meja)
                                        <span class="block text-xs text-gray-500">Meja: {{ $transaksi->pesanan->no_meja }}</span>
                                    @endif
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-300">
                                    <ul class="list-disc list-inside">
                                        @foreach($transaksi->pesanan->items as $item)
                                            <li>{{ $item->jumlah }}x {{ $item->produk->nama ?? 'Produk Dihapus' }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm font-semibold text-green-400">
                                    Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-400">Belum ada riwayat transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Link Paginasi --}}
                <div class="mt-4">
                    {{ $transaksis->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection