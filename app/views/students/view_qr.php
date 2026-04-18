<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="max-w-md mx-auto">
    <a href="<?php echo URLROOT; ?>/students" class="text-gray-500 hover:text-gray-800 flex items-center mb-6 transition-colors">
        <i class="fas fa-chevron-left mr-2"></i> Back to Student Directory
    </a>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden text-center p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800"><?php echo $data['student']->name; ?></h2>
            <p class="text-gray-500">Student IDcard / QR Attendance</p>
        </div>

        <!-- QR Code Container -->
        <div class="bg-gray-50 rounded-2xl p-6 mb-6 flex items-center justify-center">
            <div id="qrcode" class="border-4 border-white shadow-sm rounded-lg overflow-hidden bg-white"></div>
        </div>

        <div class="text-center space-y-2">
            <p class="text-sm font-medium text-gray-400 uppercase tracking-widest">Unique QR Identifier</p>
            <p class="text-xl font-mono font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-lg inline-block">
                <?php echo $data['student']->qr_code; ?>
            </p>
        </div>

        <div class="mt-10 pt-6 border-t border-gray-50 flex gap-4">
            <button onclick="window.print()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                <i class="fas fa-print"></i> Print Card
            </button>
            <button onclick="downloadQR()" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                <i class="fas fa-download"></i> Save Image
            </button>
        </div>
    </div>
</div>

<!-- Script to generate QR -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    const qrText = "<?php echo $data['student']->qr_code; ?>";
    const qrcode = new QRCode(document.getElementById("qrcode"), {
        text: qrText,
        width: 200,
        height: 200,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });

    function downloadQR() {
        const img = document.querySelector('#qrcode img');
        if (img) {
            const link = document.createElement('a');
            link.download = 'QR_<?php echo $data['student']->qr_code; ?>.png';
            link.href = img.src;
            link.click();
        }
    }
</script>

<style>
    @media print {
        header, aside, footer, a, button { display: none !important; }
        body { background: white; }
        .max-w-md { max-width: 100%; margin: 0; }
        .bg-white { border: none; box-shadow: none; }
    }
</style>
<?php require APPROOT . '/views/inc/footer.php'; ?>
