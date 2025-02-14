console.log("halo semua");

document.addEventListener('alpine:init', () => {
    Alpine.data('qrScanner', () => ({
        scannedResult: '',
        qrCodeReader: null,

        initScanner() {
            this.qrCodeReader = new Html5Qrcode("qr-reader");
            this.qrCodeReader.start(
                { facingMode: "environment" }, // Kamera belakang
                { fps: 10, qrbox: 250 },
                (decodedText) => {
                    this.scannedResult = decodedText;
                    alert('Kode Barang: ' + decodedText);
                    this.destroyScanner(); // Matikan scanner setelah scan berhasil
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
        }
    }));
});