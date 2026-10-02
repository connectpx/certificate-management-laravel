<?php

use App\Models\Certificate;
use App\Services\CertificateExportService;
use Barryvdh\DomPDF\Facade\Pdf;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$c = Certificate::query()->first();
$svc = app(CertificateExportService::class);

$b = $svc->barcodeBase64($c);
$q = $svc->qrBase64($c);
echo 'barcode_len='.strlen($b).PHP_EOL;
echo 'qr_len='.strlen($q).PHP_EOL;

$png = $svc->renderPng($c);
file_put_contents(storage_path('app/test-cert.png'), $png);
echo 'png_bytes='.strlen($png).PHP_EOL;

$pdf = Pdf::loadView('certificates.pdf', [
    'certificate' => $c,
    'barcode' => $b,
    'qr' => $q,
])->setPaper('a4', 'landscape');
file_put_contents(storage_path('app/test-cert.pdf'), $pdf->output());
echo 'pdf_bytes='.filesize(storage_path('app/test-cert.pdf')).PHP_EOL;
echo 'verify='.$c->verify_url.PHP_EOL;
echo "OK\n";
