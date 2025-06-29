<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Menu - Warnet</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-900 text-white font-sans">

{{-- === KODE BARU DIMULAI DI SINI === --}}
<div class="absolute top-0 right-0 p-4 sm:p-6 text-right">
    @auth
        {{-- Jika pengguna sudah login, tampilkan link ke Dashboard --}}
        <a href="{{ route('dashboard') }}" class="font-semibold text-white hover:text-gray-300">Dashboard</a>
    @else
        {{-- Jika pengguna belum login, tampilkan link untuk Login --}}
        <a href="{{ route('login') }}" class="font-semibold text-white hover:text-gray-300">
            <i class="fas fa-sign-in-alt mr-1"></i>
            Login
        </a>
    @endauth
</div>
{{-- === KODE BARU BERAKHIR DI SINI === --}}


<div class="container mx-auto p-4 sm:p-8">

    {{-- Header --}}
    <header class="text-center mb-10 pt-12 sm:pt-0"> {{-- Menambahkan padding atas agar tidak tertutup link login --}}
        <h1 class="text-4xl font-bold text-purple-400">Pesan Menu Makanan & Minuman</h1>
        <p class="text-slate-400 mt-2">Pilih menu favoritmu dan kami akan antarkan ke mejamu!</p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kolom Kiri: Daftar Menu --}}
        <div class="lg:col-span-2">
            <div id="menu-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                {{-- Produk akan dirender oleh JavaScript di sini --}}
            </div>
        </div>

        {{-- Kolom Kanan: Keranjang Pesanan --}}
        <div class="lg:col-span-1">
            <div class="bg-slate-800 rounded-xl p-6 sticky top-8">
                <h2 class="text-2xl font-bold border-b border-slate-700 pb-4 mb-4">
                    <i class="fas fa-shopping-cart mr-2 text-purple-400"></i> Pesanan Anda
                </h2>

                <div id="cart-items" class="space-y-4 max-h-64 overflow-y-auto pr-2">
                    <p class="text-slate-500 text-center py-8">Keranjang masih kosong.</p>
                </div>

                {{-- Detail Total Harga --}}
                <div id="summary-section" class="border-t border-slate-700 pt-4 mt-4 space-y-2 hidden">
                    <div class="flex justify-between text-slate-300">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-slate-300">
                        <span>Pajak (10%)</span>
                        <span id="tax">Rp 0</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg text-white">
                        <span>Total</span>
                        <span id="total">Rp 0</span>
                    </div>
                </div>

                {{-- Input Nomor Meja & Tombol Pesan --}}
                <div class="mt-6">
                    <label for="no_meja" class="block text-sm font-medium text-slate-300 mb-2">Nomor PC / Meja</label>
                    <input type="text" id="no_meja" class="w-full bg-slate-700 border border-slate-600 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Contoh: 07 atau 15">

                    <button id="order-button" class="mt-4 w-full bg-green-600 hover:bg-green-700 rounded-lg py-3 font-bold text-lg transition-all duration-300 disabled:bg-slate-600 disabled:cursor-not-allowed" disabled>
                        Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const allProduk = @json($produks);
    let cart = [];

    const menuGrid = document.getElementById('menu-grid');
    const cartItemsEl = document.getElementById('cart-items');
    const subtotalEl = document.getElementById('subtotal');
    const taxEl = document.getElementById('tax');
    const totalEl = document.getElementById('total');
    const summarySection = document.getElementById('summary-section');
    const orderButton = document.getElementById('order-button');
    const noMejaInput = document.getElementById('no_meja');

    // Fungsi untuk merender daftar produk
    function renderMenu() {
        if (allProduk.length === 0) {
            menuGrid.innerHTML = '<p class="text-slate-500 text-center col-span-full">Menu tidak tersedia saat ini.</p>';
            return;
        }

        // Kelompokkan produk berdasarkan kategori
        const groupedProduk = allProduk.reduce((acc, produk) => {
            (acc[produk.kategori] = acc[produk.kategori] || []).push(produk);
            return acc;
        }, {});

        let menuHtml = '';
        const kategoriOrder = ['makanan', 'minuman', 'snack']; // Urutan kategori

        kategoriOrder.forEach(kategori => {
            if (groupedProduk[kategori]) {
                menuHtml += `<h2 class="text-2xl font-bold text-purple-300 col-span-full mt-6 mb-2 capitalize">${kategori}</h2>`;
                groupedProduk[kategori].forEach(p => {
                    menuHtml += `
                        <div class="bg-slate-800 rounded-lg p-4 flex flex-col">
                            <div class="text-4xl mb-3">${p.icon || '🍽️'}</div>
                            <h3 class="font-bold text-lg flex-grow">${p.nama}</h3>
                            <p class="text-sm text-slate-400 mb-3 h-10">${p.deskripsi || ''}</p>
                            <div class="flex justify-between items-center mt-auto">
                                <span class="font-semibold text-purple-400">Rp ${p.harga.toLocaleString('id-ID')}</span>
                                <button onclick="addToCart(${p.id})" class="bg-purple-600 hover:bg-purple-700 text-sm font-bold px-3 py-1 rounded-lg transition-colors">
                                    + Tambah
                                </button>
                            </div>
                        </div>
                    `;
                });
            }
        });
        menuGrid.innerHTML = menuHtml;
    }

    // Fungsi untuk merender keranjang
    function renderCart() {
        if (cart.length === 0) {
            cartItemsEl.innerHTML = '<p class="text-slate-500 text-center py-8">Keranjang masih kosong.</p>';
            summarySection.classList.add('hidden');
            orderButton.disabled = true;
            return;
        }

        cartItemsEl.innerHTML = cart.map(item => `
            <div class="flex items-center justify-between text-sm">
                <div>
                    <p class="font-semibold text-white">${item.nama}</p>
                    <p class="text-slate-400">Rp ${item.harga.toLocaleString('id-ID')}</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="w-7 h-7 bg-slate-600 rounded-full" onclick="updateQuantity(${item.id}, -1)">-</button>
                    <span>x <span class="font-bold">${item.jumlah}</span></span>
                    <button class="w-7 h-7 bg-slate-600 rounded-full" onclick="updateQuantity(${item.id}, 1)">+</button>
                </div>
            </div>
        `).join('');

        summarySection.classList.remove('hidden');
        orderButton.disabled = noMejaInput.value.trim() === '';
        updateSummary();
    }

    // Fungsi untuk menghitung total
    function updateSummary() {
        const subtotal = cart.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
        const tax = subtotal * 0.10;
        const total = subtotal + tax;
        subtotalEl.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
        taxEl.textContent = `Rp ${tax.toLocaleString('id-ID')}`;
        totalEl.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    // Fungsi untuk menambah item ke keranjang
    window.addToCart = (produkId) => {
        const produk = allProduk.find(p => p.id === produkId);
        const itemInCart = cart.find(item => item.id === produkId);

        if (itemInCart) {
            itemInCart.jumlah++;
        } else {
            cart.push({ ...produk, jumlah: 1 });
        }
        renderCart();
    };

    // Fungsi untuk mengubah jumlah item
    window.updateQuantity = (produkId, change) => {
        const itemInCart = cart.find(item => item.id === produkId);
        if (!itemInCart) return;

        itemInCart.jumlah += change;

        if (itemInCart.jumlah <= 0) {
            cart = cart.filter(item => item.id !== produkId);
        }
        renderCart();
    };
    
    // Event listener untuk input nomor meja
    noMejaInput.addEventListener('input', () => {
         orderButton.disabled = cart.length === 0 || noMejaInput.value.trim() === '';
    });

    // Event listener untuk tombol pesan
    orderButton.addEventListener('click', async () => {
        const noMeja = noMejaInput.value.trim();
        if (!noMeja) {
            alert('Harap isi nomor PC atau Meja Anda!');
            return;
        }

        const originalButtonText = orderButton.innerHTML;
        orderButton.disabled = true;
        orderButton.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Mengirim...`;

        try {
            const response = await fetch("{{ route('pesan.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    no_meja: noMeja,
                    items: cart.map(item => ({ id: item.id, jumlah: item.jumlah }))
                })
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Terjadi kesalahan.');
            }

            alert(result.message);
            // Kosongkan keranjang dan reset form
            cart = [];
            noMejaInput.value = '';
            renderCart();

        } catch (error) {
            alert('Gagal membuat pesanan: ' + error.message);
        } finally {
            orderButton.disabled = false;
            orderButton.innerHTML = originalButtonText;
            renderCart();
        }
    });

    // Render awal saat halaman dimuat
    renderMenu();
});
</script>

</body>
</html>