{{-- File ini berisi elemen form yang sama untuk Tambah dan Edit --}}
<div class="space-y-4">
    <div>
        <label for="nama" class="block text-sm font-medium leading-6 text-gray-300">Nama Produk</label>
        <div class="mt-2">
            <input type="text" name="nama" required class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label for="harga" class="block text-sm font-medium leading-6 text-gray-300">Harga</label>
            <div class="mt-2">
                <input type="number" name="harga" required class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
            </div>
        </div>
        <div>
            <label for="stok" class="block text-sm font-medium leading-6 text-gray-300">Stok</label>
            <div class="mt-2">
                <input type="number" name="stok" required class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
            </div>
        </div>
    </div>
    <div>
        <label for="kategori" class="block text-sm font-medium leading-6 text-gray-300">Kategori</label>
        <div class="mt-2">
            <select name="kategori" required class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
                <option value="snack">Snack</option>
            </select>
        </div>
    </div>
    <div>
        <label for="icon" class="block text-sm font-medium leading-6 text-gray-300">Ikon (Emoji)</label>
        <div class="mt-2">
            <input type="text" name="icon" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="Contoh: 🍚">
        </div>
    </div>
    <div>
        <label for="deskripsi" class="block text-sm font-medium leading-6 text-gray-300">Deskripsi</label>
        <div class="mt-2">
            <textarea name="deskripsi" rows="3" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"></textarea>
        </div>
    </div>
</div>
<div class="mt-8 flex items-center justify-end gap-x-4">
    <button type="button" onclick="closeModal(this.closest('.fixed').id)" class="text-sm font-semibold leading-6 text-gray-300">Batal</button>
    <button type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Simpan</button>
</div>