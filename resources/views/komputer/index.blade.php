@extends(Auth::user()->role == 'admin' ? 'layouts.admin' : 'layouts.warnet')
@section('title', 'Manajemen Komputer')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold leading-tight tracking-tight text-white">Manajemen Komputer</h1>
            <p class="mt-2 text-sm text-gray-400">Kelola semua komputer yang terdaftar di warnet.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            @if(Auth::user()->role == 'admin')
                <button type="button" onclick="openModal('addModal')" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors duration-200">
                    <i class="fas fa-plus-circle mr-2 -ml-1"></i>Tambah Komputer
                </button>
            @endif
        </div>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="rounded-md bg-green-500/20 p-4 mb-6"><p class="text-sm font-medium text-green-400">{{ session('success') }}</p></div>
    @endif
    @if ($errors->any())
        <div class="rounded-md bg-red-500/20 p-4 mb-6">
            <ul class="list-disc list-inside text-sm text-red-400">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-white/10 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-800">
                            <tr>
                                {{-- Judul kolom kita ubah sedikit agar lebih sesuai --}}
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">Nama Produk</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Status</th>
                                @if(Auth::user()->role == 'admin')
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-center text-white">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 bg-gray-900/50">
                            @forelse ($komputers as $komputer)
                            <tr class="hover:bg-gray-800/50 transition-colors duration-200">
                                {{-- === PERUBAHAN UTAMA DI SINI === --}}
                                <td class="whitespace-nowrap py-3 pl-4 pr-3 text-sm sm:pl-6"> {{-- Padding py-4 diubah menjadi py-3 --}}
                                    <span class="font-medium text-white">{{ $komputer->merk }}</span>
                                    <span class="text-gray-400">- {{ $komputer->spesifikasi }}</span>
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-sm text-gray-300"> {{-- Padding py-4 diubah menjadi py-3 --}}
                                    @if ($komputer->status === 'tersedia')
                                        <span class="inline-flex items-center rounded-md bg-green-500/10 px-2 py-1 text-xs font-medium text-green-400 ring-1 ring-inset ring-green-500/20">Tersedia</span>
                                    @elseif ($komputer->status === 'maintenance')
                                        <span class="inline-flex items-center rounded-md bg-orange-400/10 px-2 py-1 text-xs font-medium text-orange-400 ring-1 ring-inset ring-orange-400/20">Maintenance</span>
                                    @else
                                        <span class="inline-flex items-center rounded-md bg-red-400/10 px-2 py-1 text-xs font-medium text-red-400 ring-1 ring-inset ring-red-400/20">Terpakai</span>
                                    @endif
                                </td>
                                @if(Auth::user()->role == 'admin')
                                    <td class="relative whitespace-nowrap py-3 pl-3 pr-4 text-center text-sm font-medium sm:pr-6"> {{-- Padding py-4 diubah menjadi py-3 --}}
                                        <button onclick="openEditModal({{ $komputer->toJson() }})" class="text-indigo-400 hover:text-indigo-300">Edit</button>
                                        <form action="{{ route('komputer.destroy', $komputer->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role == 'admin' ? '3' : '2' }}" class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-400">Belum ada data komputer.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Bagian Pagination --}}
                <div class="mt-6 flex items-center justify-between">
                    <div class="text-sm text-gray-400">
                        Showing <span class="font-medium text-white">{{ $komputers->firstItem() }}</span> to <span class="font-medium text-white">{{ $komputers->lastItem() }}</span> of <span class="font-medium text-white">{{ $komputers->total() }}</span> results
                    </div>
                    <div>{{ $komputers->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    @include('komputer.modals')
</div>
@endsection

@push('scripts')
    <script>
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
        function openEditModal(komputer) {
            const form = document.getElementById('editForm');
            form.action = `/komputer/${komputer.id}`;
            form.querySelector('[name="merk"]').value = komputer.merk;
            form.querySelector('[name="spesifikasi"]').value = komputer.spesifikasi;
            form.querySelector('[name="status"]').value = komputer.status;
            openModal('editModal');
        }
        @if($errors->any())
            @if(old('_method') === 'PUT') openModal('editModal');
            @else openModal('addModal'); @endif
        @endif
    </script>
@endpush
