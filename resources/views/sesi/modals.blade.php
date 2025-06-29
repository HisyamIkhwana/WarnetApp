{{-- resources/views/sesi/modals.blade.php --}}

{{-- MODAL TAMBAH SESI --}}
<div id="addSesiModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/75">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative w-full max-w-lg p-8 mx-auto bg-slate-800 rounded-lg shadow-xl text-center">
            <button type="button" onclick="closeModal('addSesiModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-200"><span class="sr-only">Tutup</span><i class="fas fa-times"></i></button>
            <h2 class="text-xl font-bold text-white mb-6">Mulai Sesi Baru</h2>
            <form action="{{ route('sesi.store') }}" method="POST">
                @csrf
                @include('sesi.partials.form-sesi', ['komputers' => $komputers ?? []])
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT SESI --}}
<div id="editSesiModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/75">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative w-full max-w-lg p-8 mx-auto bg-slate-800 rounded-lg shadow-xl text-center">
             <button type="button" onclick="closeModal('editSesiModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-200"><span class="sr-only">Tutup</span><i class="fas fa-times"></i></button>
             <h2 class="text-xl font-bold text-white mb-6">Edit Sesi</h2>
            <form id="editSesiForm" action="" method="POST">
                @csrf
                @method('PUT')
                @include('sesi.partials.form-sesi', ['komputers' => $komputers ?? []])
            </form>
        </div>
    </div>
</div>