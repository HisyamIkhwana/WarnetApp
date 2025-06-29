<div class="space-y-4 text-left">
    <div>
        <label for="komputer_id" class="block text-sm font-medium leading-6 text-gray-300">Pilih Komputer</label>
        <div class="mt-2">
            {{-- Dropdown ini akan diisi dengan data komputer yang tersedia --}}
            <select name="komputer_id" required class="block w-full rounded-md border-0 bg-black/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-black/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                <option value="" required class="bg-black/5">-- Komputer Tersedia --</option>
                {{-- Opsi akan diisi dari controller --}}
                @foreach($komputers as $komputer)
                    {{-- Hanya tampilkan komputer yang statusnya tersedia --}}
                    @if($komputer->status == 'tersedia')
                        <option value="{{ $komputer->id }}">{{ $komputer->merk }} - ({{ $komputer->spesifikasi }})</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div>
        <label for="durasi" class="block text-sm font-medium leading-6 text-gray-300">Durasi (dalam jam)</label>
        <div class="mt-2">
            <input type="number" name="durasi" min="1" required class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="Contoh: 1 atau 2">
        </div>
    </div>
</div>
<div class="mt-8 flex items-center justify-end gap-x-4">
    <button type="button" onclick="closeModal('addSesiModal')" class="text-sm font-semibold leading-6 text-gray-300">Batal</button>
    <button type="submit" class="rounded-md bg-indigo-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Mulai Sesi</button>
</div>