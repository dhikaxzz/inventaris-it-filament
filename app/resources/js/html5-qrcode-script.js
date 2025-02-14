console.log("Scan QR Script Loaded");

document.addEventListener('alpine:init', () => {
    Alpine.data('qrScanner', () => ({
        scannedResult: '',
        qrCodeReader: null,

        initScanner() {
            this.qrCodeReader = new Html5Qrcode("qr-reader");
            this.qrCodeReader.start(
                { facingMode: "environment" }, // Kamera belakang
                { fps: 10, qrbox: 250 },
                async (decodedText) => {
                    this.scannedResult = decodedText;
                    console.log('Kode Barang Terbaca:', decodedText);

                    // Matikan scanner setelah scan berhasil
                    this.destroyScanner();

                    // Panggil fungsi pencarian barang di Laravel
                    await this.searchBarang(decodedText);
                },
                (error) => {
                    console.error(error);
                }
            );
        },

        destroyScanner() {
            if (this.qrCodeReader) {
                this.qrCodeReader.stop().then(() => {
                    console.log("QR Scanner Stopped");
                }).catch(err => console.error("Error stopping QR scanner:", err));
                this.qrCodeReader = null;
            }
        },

        async searchBarang(kodeBarang) {
            try {
                let response = await fetch(`/barang/search?q=${kodeBarang}`);
                let data = await response.json();

                if (data.success) {
                    
                    // Refresh halaman atau filter tabel barang berdasarkan hasil scan
                    window.location.href = "/admin/barangs?q=" + kodeBarang;
                } else {
                    alert("Barang tidak ditemukan!");
                }
            } catch (error) {
                console.error("Error mencari barang:", error);
            }
        }
    }));
});

// Pastikan scanner mati saat modal ditutup
document.addEventListener('close-modal', () => {
    const qrScanner = Alpine.$data(document.querySelector('[x-data="qrScanner"]'), 'qrScanner');
    if (qrScanner) {
        qrScanner.destroyScanner();
    }
});
