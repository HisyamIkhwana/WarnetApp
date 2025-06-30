<div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/75">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative w-full max-w-lg p-8 mx-auto bg-slate-800 rounded-lg shadow-xl text-center">
            <button type="button" onclick="closeModal('addModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-200"><span class="sr-only">Tutup</span><i class="fas fa-times"></i></button>
            <h2 class="text-xl font-bold text-white mb-6">Tambah Komputer Baru</h2>
            <form action="{{ route('komputer.store') }}" method="POST">
                @csrf
                @include('komputer.partials.form-komputer')
            </form>
        </div>
    </div>
</div>

<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/75">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative w-full max-w-lg p-8 mx-auto bg-slate-800 rounded-lg shadow-xl text-center">
            <button type="button" onclick="closeModal('editModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-200"><span class="sr-only">Tutup</span><i class="fas fa-times"></i></button>
            <h2 class="text-xl font-bold text-white mb-6">Edit Komputer</h2>
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                @include('komputer.partials.form-komputer')
            </form>
        </div>
    </div>
</div>
