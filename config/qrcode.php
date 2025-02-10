<?php

return [
    'size' => 100,
    'format' => 'svg', // Bisa 'png', 'svg', atau 'eps'
    'writer' => \BaconQrCode\Writer::class, // Gunakan BaconQrCode tanpa Imagick
];
