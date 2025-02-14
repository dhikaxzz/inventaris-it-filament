console.log("halo semua");
document.addEventListener('alpine:init', () => {
    Alpine.data('qrScanner', () => ({
        scannedResult: '',

        initScanner() {
            const qrCodeReader = new Html5Qrcode("qr-reader");
            qrCodeReader.start(
                { facingMode: "environment" }, // Kamera belakang
                { fps: 10, qrbox: 250 },
                (decodedText) => {
                    this.scannedResult = decodedText;
                    alert('Hasil Scan: ' + decodedText);
                    qrCodeReader.stop();
                },
                (error) => {
                    console.error(error);
                }
            );
        }
    }));
});