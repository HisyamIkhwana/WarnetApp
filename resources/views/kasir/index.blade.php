@extends(Auth::user()->role == 'admin' ? 'layouts.admin' : 'layouts.kasir')
@section('title', 'Kasir')

@section('content')
{{-- Kontainer utama diubah menjadi 2 kolom (rasio 2:1) --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 h-full">

    <div class="lg:col-span-2">
        <div class="bg-slate-800 rounded-lg p-6 h-full flex flex-col">
            <h2 class="text-xl font-bold text-white mb-4">Pilih Produk</h2>
            <div class="relative mb-4">
                <input type="text" id="searchInput" placeholder="Cari produk..." class="w-full bg-slate-700 border border-slate-600 rounded-full py-2 px-4 pl-10 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
            </div>
            <div id="menuGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 overflow-y-auto flex-grow">
                {{-- Produk dirender oleh JavaScript --}}
            </div>
        </div>
    </div>

    <div class="lg:col-span-1 flex flex-col gap-8">
        
        <div class="bg-slate-800 rounded-lg p-6 flex flex-col">
            <h2 class="text-xl font-bold text-white mb-4">Pesanan Aktif</h2>
            <div id="pesananAktifGrid" class="space-y-3 overflow-y-auto max-h-48 pr-2">
                @forelse($pesananAktif as $pesanan)
                    <button
                        onclick="loadOrder(this)"
                        data-pesanan-id="{{ $pesanan->id }}"
                        data-items="{{ json_encode($pesanan->items) }}"
                        class="w-full text-left bg-slate-700 hover:bg-slate-600 p-3 rounded-lg transition-colors">
                        <div class="flex justify-between font-bold">
                            <span class="text-purple-400">PC/Meja: {{ $pesanan->no_meja }}</span>
                            <span class="text-white">#{{ $pesanan->id }}</span>
                        </div>
                        <div class="text-sm text-slate-300">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</div>
                    </button>
                @empty
                    <p class="text-center text-slate-500 pt-8">Tidak ada pesanan aktif.</p>
                @endforelse
            </div>
        </div>

        <div id="order-panel" class="bg-slate-800 rounded-lg p-6 flex-grow flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h2 id="panel-title" class="text-xl font-bold text-white">Pesanan Baru</h2>
                <button id="clearOrderBtn" onclick="clearOrder()" class="text-sm text-red-400 hover:text-red-300 transition-colors">Kosongkan</button>
            </div>
            
            <div id="orderItems" class="space-y-3 overflow-y-auto flex-grow pr-2">
                <p class="text-center text-slate-500 italic pt-16">Pilih produk dari daftar di kiri.</p>
            </div>

            <div class="border-t border-slate-700 pt-4 mt-4">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-slate-400">Subtotal</span><span id="subtotal">Rp 0</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Pajak (10%)</span><span id="tax">Rp 0</span></div>
                    <div class="flex justify-between font-bold text-lg"><span class="text-white">Total</span><span id="total">Rp 0</span></div>
                </div>

                <div class="mt-4">
                    <label class="text-sm font-medium text-slate-300">Metode Pembayaran</label>
                    <div class="flex gap-2 mt-2">
                         <input type="radio" id="pay_tunai" name="payment_method" value="tunai" class="hidden peer" checked>
                         <label for="pay_tunai" class="w-full text-center p-2 rounded-lg border border-slate-600 cursor-pointer peer-checked:bg-purple-600 peer-checked:border-purple-600">Tunai</label>
                         <input type="radio" id="pay_kartu" name="payment_method" value="kartu" class="hidden peer">
                         <label for="pay_kartu" class="w-full text-center p-2 rounded-lg border border-slate-600 cursor-pointer peer-checked:bg-purple-600 peer-checked:border-purple-600">Kartu</label>
                    </div>
                </div>
                
                <button id="paymentBtn" class="mt-4 w-full bg-green-600 hover:bg-green-700 rounded-lg py-3 font-bold text-lg transition-all duration-300 disabled:bg-slate-600 disabled:cursor-not-allowed">
                    Bayar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Tidak ada perubahan pada JavaScript, kode di bawah ini sama seperti sebelumnya --}}
<script>
    const allMenuItems = @json($produks);
    let currentOrder = {
        id: null,
        items: []
    };

    const menuGrid = document.getElementById('menuGrid');
    const orderItemsEl = document.getElementById('orderItems');
    const paymentBtn = document.getElementById('paymentBtn');
    const panelTitle = document.getElementById('panel-title');

    function renderMenu(filter = '') {
        const searchTerm = filter.toLowerCase();
        const filteredItems = allMenuItems.filter(p => p.nama.toLowerCase().includes(searchTerm));
        if(filteredItems.length === 0) {
            menuGrid.innerHTML = `<p class="text-slate-500 text-center col-span-full py-8">Produk tidak ditemukan.</p>`;
            return;
        }
        menuGrid.innerHTML = filteredItems.map(p => `
            <div class="bg-slate-700 p-3 rounded-lg text-center cursor-pointer hover:bg-slate-600" onclick="addToCart(${p.id})">
                <div class="text-3xl">${p.icon || '🍽️'}</div>
                <div class="text-sm font-semibold mt-2">${p.nama}</div>
                <div class="text-xs text-slate-400">Rp ${p.harga.toLocaleString('id-ID')}</div>
            </div>
        `).join('');
    }

    function renderOrder() {
        if (currentOrder.items.length === 0) {
            orderItemsEl.innerHTML = `<p class="text-center text-slate-500 italic pt-16">Pilih produk dari daftar di kiri.</p>`;
        } else {
            orderItemsEl.innerHTML = currentOrder.items.map(item => `
                <div class="flex items-center justify-between text-sm">
                    <div>
                        <p class="font-semibold text-white">${item.produk?.nama || item.nama}</p>
                        <p class="text-slate-400">Rp ${item.harga_saat_pesan?.toLocaleString('id-ID') || item.harga.toLocaleString('id-ID')}</p>
                    </div>
                     <div class="flex items-center gap-3">
                        <button class="w-7 h-7 bg-slate-600 rounded-full ${currentOrder.id ? 'hidden' : ''}" onclick="updateQuantity(${item.produk_id || item.id}, -1)">-</button>
                        <span>x <span class="font-bold">${item.jumlah}</span></span>
                        <button class="w-7 h-7 bg-slate-600 rounded-full ${currentOrder.id ? 'hidden' : ''}" onclick="updateQuantity(${item.produk_id || item.id}, 1)">+</button>
                    </div>
                </div>
            `).join('');
        }
        updateSummary();
    }
    
    function updateSummary() {
        const subtotal = currentOrder.items.reduce((sum, item) => sum + ((item.harga_saat_pesan || item.harga) * item.jumlah), 0);
        const tax = subtotal * 0.1;
        const total = subtotal + tax;
        document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
        document.getElementById('tax').textContent = `Rp ${tax.toLocaleString('id-ID')}`;
        document.getElementById('total').textContent = `Rp ${total.toLocaleString('id-ID')}`;
        paymentBtn.disabled = currentOrder.items.length === 0;
    }

    function addToCart(produkId) {
        if(currentOrder.id) clearOrder();
        const produk = allMenuItems.find(p => p.id === produkId);
        let itemInCart = currentOrder.items.find(i => i.id === produkId);
        if (itemInCart) {
            if (itemInCart.jumlah < produk.stok) itemInCart.jumlah++;
        } else {
            currentOrder.items.push({ ...produk, jumlah: 1 });
        }
        renderOrder();
    }

    function updateQuantity(produkId, change) {
        let itemInCart = currentOrder.items.find(i => i.id === produkId);
        if (!itemInCart) return;
        const newQuantity = itemInCart.jumlah + change;
        if (newQuantity <= 0) {
            currentOrder.items = currentOrder.items.filter(i => i.id !== produkId);
        } else {
            const produk = allMenuItems.find(p => p.id === produkId);
            if (newQuantity <= produk.stok) itemInCart.jumlah = newQuantity;
        }
        renderOrder();
    }

    function clearOrder() {
        currentOrder.id = null;
        currentOrder.items = [];
        panelTitle.textContent = 'Pesanan Baru';
        paymentBtn.textContent = 'Bayar';
        renderOrder();
    }

    function loadOrder(element) {
        clearOrder();
        const pesananId = element.dataset.pesananId;
        const items = JSON.parse(element.dataset.items);
        currentOrder.id = pesananId;
        currentOrder.items = items;
        panelTitle.textContent = `Pembayaran Pesanan #${pesananId}`;
        paymentBtn.textContent = 'Selesaikan Pembayaran';
        renderOrder();
    }

    paymentBtn.addEventListener('click', async () => {
        paymentBtn.disabled = true;
        const originalText = paymentBtn.textContent;
        paymentBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;
        
        let url, body;
        const metodePembayaran = document.querySelector('input[name="payment_method"]:checked').value;

        if (currentOrder.id) { // Menyelesaikan pesanan aktif
            url = `/kasir/pesanan/${currentOrder.id}/bayar`;
            body = JSON.stringify({
                _token: '{{ csrf_token() }}',
                metode_pembayaran: metodePembayaran
            });
        } else { // Membuat pesanan baru (walk-in)
            url = "{{ route('kasir.checkout') }}";
            body = JSON.stringify({
                _token: '{{ csrf_token() }}',
                items: currentOrder.items.map(i => ({ id: i.id, jumlah: i.jumlah })),
                metode_pembayaran: metodePembayaran
            });
        }

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: body
            });
            const result = await response.json();
            if (!response.ok) throw new Error(result.message);
            alert(result.message);
            location.reload();
        } catch (error) {
            alert('Error: ' + error.message);
            paymentBtn.disabled = false;
            paymentBtn.textContent = originalText;
        }
    });

    document.getElementById('searchInput').addEventListener('input', (e) => renderMenu(e.target.value));
    
    // Initial Render
    renderMenu();
    renderOrder();
</script>
@endpush