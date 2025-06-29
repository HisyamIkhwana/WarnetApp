<div class="space-y-4 text-left">
    {{-- Karena warnet hanya ada satu, kita bisa sembunyikan input ini --}}
    {{-- Jika Anda berencana memiliki banyak warnet, Anda bisa menampilkannya lagi --}}
    <input type="hidden" name="warnet_id" value="1">

    <div>
        <label for="merk" class="block text-sm font-medium leading-6 text-gray-300">Merk Komputer</label>
        <div class="mt-2">
            <input type="text" name="merk" required class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="Contoh: Dell, HP, Asus">
        </div>
    </div>
    <div>
        <label for="spesifikasi" class="block text-sm font-medium leading-6 text-gray-300">Spesifikasi</label>
        <div class="mt-2">
            <input type="text" name="spesifikasi" required class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="Contoh: Core i5, 8GB RAM">
        </div>
    </div>
    <div>
        <label for="status" class="block text-sm font-medium leading-6 text-gray-300">Status Awal</label>
        <div class="mt-2">
            <select name="status" required class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                <option value="tersedia">Tersedia</option>
                <option value="maintenance">Maintenance</option>
            </select>
        </div>
    </div>
</div>
<div class="mt-8 flex items-center justify-end gap-x-4">
    <button type="button" onclick="closeModal(this.closest('.fixed').id)" class="text-sm font-semibold leading-6 text-gray-300">Batal</button>
    <button type="submit" class="rounded-md bg-indigo-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Simpan</button>
</div>