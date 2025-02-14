<div x-data="qrScanner" x-init="initScanner()" class="p-4">
    <div id="qr-reader" class="border rounded-lg"></div>
    
    <!-- Teks "Kode Barang :" + Hasil Scan -->
    <p class="mt-2 text-lg font-bold text-center">
        Kode Barang: <span x-text="scannedResult"></span>
    </p>
</div>