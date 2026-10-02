<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Certificate {{ $certificate->certificate_number }}</title>
    <style>
        @page { margin: 12px; size: A4 landscape; }
        body { margin: 0; padding: 0; }
        * { box-sizing: border-box; }
    </style>
</head>
<body>
    @include('certificates.partials.design', [
        'certificate' => $certificate,
        'barcode' => $barcode,
        'qr' => $qr,
    ])
</body>
</html>
