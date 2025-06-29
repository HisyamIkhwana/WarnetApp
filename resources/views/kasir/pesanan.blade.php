@extends(Auth::user()->role == 'admin' ? 'layouts.admin' : 'layouts.kasir')
@section('title', 'Pesanan Online Masuk')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold leading-6 text-white">Pesanan Online Masuk</h1>
            <p class="mt-2 text-sm text-gray-400">Daftar pesanan dari pengguna yang perlu dikonfirmasi.</p>
        </div>
    </div>
    
    @if (session('success'))
        <div class="mt-4 rounded-md bg-green-500/20 p-4">
            <p class="text-sm font-medium text-green-400">{{ session('success') }}</p>
        </div>
    @endif

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse ($pesananOnline as $pesanan)
            <div class="bg-slate-800 rounded-lg shadow-lg p-6 flex flex-col">
                <div class="flex justify-between items-start border-b border-slate-700 pb-4 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-white">Pesanan #{{ $pesanan->id }}</h3>
                        <p class="text-sm text-purple-400 font-semibold">Meja/PC: {{ $pesanan->no_meja }}</p>
                    </div>
                    <span class="text-xs text-slate-400">{{ $pesanan->created_at->diffForHumans() }}</span>
                </div>
                
                <div class="space-y-2 mb-4 flex-grow">
                    @foreach($pesanan->items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-300">{{ $item->produk->nama ?? 'N/A' }}</span>
                            <span class="text-slate-400 font-mono">x{{ $item->jumlah }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-slate-700 pt-4 mt-auto">
                    <div class="flex justify-between font-bold text-white mb-4">
                        <span>Total:</span>
                        <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                    
                    <form action="{{ route('kasir.pesanan.konfirmasi', $pesanan) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 rounded-lg py-2 font-semibold transition-colors">
                            <i class="fas fa-check-circle mr-2"></i> Konfirmasi Pesanan
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 xl:col-span-3 text-center py-12 bg-slate-800 rounded-lg">
                <i class="fas fa-mug-hot text-4xl text-slate-600 mb-4"></i>
                <p class="text-slate-500">Tidak ada pesanan online saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
<script>
    // Auto-refresh halaman setiap 30 detik untuk cek pesanan baru
    setTimeout(() => {
        location.reload();
    }, 30000);
</script>
@endsection