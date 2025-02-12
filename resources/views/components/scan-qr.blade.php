<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector("#preview"), 
                constraints: { facingMode: "environment" } // Menggunakan kamera belakang
            },
            decoder: { readers: ["code_128_reader", "ean_reader", "qr_reader"] }
        }, function (err) {
            if (err) {
                console.error("Quagga init failed:", err);
                return;
            }
            Quagga.start();
        });

        Quagga.onDetected(function (result) {
            let code = result.codeResult.code;
            document.getElementById("qr-result").innerText = "QR Code: " + code;
            window.livewire.emit('qrScanned', code); // Kirim ke Livewire
            Quagga.stop();
        });
    });
</script>

<div class="flex flex-col items-center">
    <video id="preview" class="rounded-lg shadow-lg w-full"></video>
    <p id="qr-result" class="mt-3 font-semibold text-lg text-center"></p>
</div>