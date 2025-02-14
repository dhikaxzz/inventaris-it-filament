<div x-data="qrScanner" x-init="initScanner()" 
     @keydown.escape.window="destroyScanner()" 
     @close.window="destroyScanner()" 
     class="p-4">
    <div id="qr-reader" class="border rounded-lg"></div>
    
    <!-- Teks "Kode Barang :" + Hasil Scan -->
    <p class="mt-2 text-lg font-bold text-center">
        Kode Barang: <span x-text="scannedResult"></span>
    </p>

    <!-- Tombol Tutup Modal -->
    <button @click="$dispatch('close')" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">
        Tutup Modal
    </button>
</div>