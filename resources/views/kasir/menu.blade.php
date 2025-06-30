@extends(Auth::user()->role == 'admin' ? 'layouts.admin' : 'layouts.kasir')
@section('title', 'Manajemen Menu')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold leading-6 text-white">Manajemen Menu</h1>
            <p class="mt-2 text-sm text-gray-400">Kelola daftar makanan, minuman, dan snack yang tersedia untuk dijual.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            @if(Auth::user()->role == 'admin')
                <button type="button" onclick="openModal('addModal')" class="block rounded-md bg-indigo-500 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                    <i class="fas fa-plus-circle mr-2"></i>Tambah Produk
                </button>
            @endif
        </div>
    </div>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="mt-4 rounded-md bg-green-500/20 p-4">
            <p class="text-sm font-medium text-green-400">{{ session('success') }}</p>
        </div>
    @endif
     {{-- Notifikasi Error Validasi --}}
    @if ($errors->any())
        <div class="mt-4 rounded-md bg-red-500/20 p-4">
            <ul class="list-disc list-inside text-sm text-red-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-white/10 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-slate-700">
                        <thead class="bg-slate-800">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">Nama Produk</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Kategori</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Harga</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Stok</th>
                                @if(Auth::user()->role == 'admin')
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Aksi</span>
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 bg-slate-800/50">
                            @forelse ($produks as $produk)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-6">{{ $produk->icon }} {{ $produk->nama }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ ucfirst($produk->kategori) }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ $produk->stok }}</td>
                                @if(Auth::user()->role == 'admin')
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <button onclick="openEditModal({{ $produk->toJson() }})" class="text-indigo-400 hover:text-indigo-300">Edit</button>
                                        <form action="{{ route('kasir.menu.destroy', $produk) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-400">Belum ada produk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $produks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/75">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative w-full max-w-lg p-8 mx-auto bg-slate-800 rounded-lg shadow-xl">
            <button type="button" onclick="closeModal('addModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-200">
                <span class="sr-only">Tutup</span><i class="fas fa-times"></i>
            </button>
            <h2 class="text-xl font-bold text-white mb-6">Tambah Produk Baru</h2>
            <form action="{{ route('kasir.menu.store') }}" method="POST">
                @csrf
                @include('kasir.partials.form-produk')
            </form>
        </div>
    </div>
</div>

<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/75">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative w-full max-w-lg p-8 mx-auto bg-slate-800 rounded-lg shadow-xl">
            <button type="button" onclick="closeModal('editModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-200">
                <span class="sr-only">Tutup</span><i class="fas fa-times"></i>
            </button>
            <h2 class="text-xl font-bold text-white mb-6">Edit Produk</h2>
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                @include('kasir.partials.form-produk')
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function openEditModal(produk) {
        document.getElementById('editForm').action = `/kasir/menu/${produk.id}`;
        
        const form = document.getElementById('editForm');
        form.querySelector('[name="nama"]').value = produk.nama;
        form.querySelector('[name="harga"]').value = produk.harga;
        form.querySelector('[name="stok"]').value = produk.stok;
        form.querySelector('[name="kategori"]').value = produk.kategori;
        form.querySelector('[name="icon"]').value = produk.icon;
        form.querySelector('[name="deskripsi"]').value = produk.deskripsi;

        openModal('editModal');
    }
</script>
@endpush
@endsection
