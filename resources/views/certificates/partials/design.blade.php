@php
    /** @var \App\Models\Certificate $certificate */
    $barcode = $barcode ?? app(\App\Services\CertificateExportService::class)->barcodeBase64($certificate);
    $qr = $qr ?? app(\App\Services\CertificateExportService::class)->qrBase64($certificate);
    $navy = '#0b2a56';
    $resultColor = $certificate->isPassed() ? '#0b2a56' : '#8b1e1e';

    $dogPath = public_path('images/basdu-dog.jpg');
    $sealPath = public_path('images/basdu-seal.jpg');
    $dogSrc = is_file($dogPath) ? 'data:image/jpeg;base64,'.base64_encode((string) file_get_contents($dogPath)) : '';
    $sealSrc = is_file($sealPath) ? 'data:image/jpeg;base64,'.base64_encode((string) file_get_contents($sealPath)) : '';
@endphp

<style>
    .basdu-cert {
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        background: #ffffff;
        border: 2px solid {{ $navy }};
        padding: 8px;
        box-sizing: border-box;
        color: #111;
    }
    .basdu-cert-inner {
        border: 5px solid {{ $navy }};
        padding: 28px 34px 22px;
        position: relative;
        box-sizing: border-box;
        min-height: 700px;
    }
    .basdu-header {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px;
    }
    .basdu-header td { vertical-align: middle; }
    .basdu-dog { width: 92px; height: auto; display: block; }
    .basdu-brand { text-align: center; padding-left: 10px; }
    .basdu-brand-title {
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 54px;
        font-weight: 700;
        color: {{ $navy }};
        letter-spacing: 2px;
        line-height: 1;
        margin: 0;
    }
    .basdu-brand-sub {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: {{ $navy }};
        letter-spacing: 1.5px;
        margin-top: 6px;
        text-transform: uppercase;
    }
    .basdu-rule {
        border: 0;
        border-top: 1.5px solid {{ $navy }};
        margin: 12px 0;
    }
    .basdu-title {
        text-align: center;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 28px;
        font-weight: 700;
        color: {{ $navy }};
        letter-spacing: 1px;
        margin: 0;
        text-transform: uppercase;
    }
    .basdu-intro {
        text-align: center;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 15px;
        margin: 16px 0 8px;
        color: #222;
    }
    .basdu-handler {
        text-align: center;
        font-family: 'Segoe Script', 'Brush Script MT', Georgia, cursive;
        font-size: 46px;
        color: #111;
        line-height: 1.15;
        margin: 4px 0 12px;
    }
    .basdu-statement {
        text-align: center;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 14px;
        line-height: 1.45;
        max-width: 880px;
        margin: 0 auto 22px;
        color: #222;
    }
    .basdu-mid {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
    }
    .basdu-mid td { vertical-align: top; }
    .basdu-meta {
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 14px;
        line-height: 1.9;
        padding-right: 24px;
    }
    .basdu-meta strong {
        color: {{ $navy }};
        font-weight: 700;
    }
    .basdu-result {
        width: 280px;
        border: 2px solid {{ $resultColor }};
        margin-left: auto;
    }
    .basdu-result-head {
        background: {{ $resultColor }};
        color: #fff;
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 8px 10px;
        text-transform: uppercase;
    }
    .basdu-result-body {
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 48px;
        font-weight: 700;
        color: {{ $resultColor }};
        padding: 18px 10px 16px;
        letter-spacing: 2px;
        background: #fff;
    }
    .basdu-signs {
        width: 100%;
        border-collapse: collapse;
        margin-top: 42px;
    }
    .basdu-signs td {
        width: 25%;
        text-align: center;
        vertical-align: bottom;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10px;
        font-weight: 700;
        color: {{ $navy }};
        letter-spacing: 0.4px;
        text-transform: uppercase;
        padding: 0 8px;
    }
    .basdu-sign-line {
        border-top: 1.5px solid {{ $navy }};
        margin: 0 auto 8px;
        width: 88%;
    }
    .basdu-seal {
        width: 110px;
        height: auto;
        display: block;
        margin: 0 auto;
    }
    .basdu-codes {
        width: 100%;
        border-collapse: collapse;
        margin-top: 22px;
    }
    .basdu-codes td { vertical-align: bottom; }
    .basdu-barcode {
        text-align: center;
    }
    .basdu-barcode img {
        height: 48px;
        display: inline-block;
    }
    .basdu-barcode-text {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        letter-spacing: 1px;
        margin-top: 4px;
        color: #333;
    }
    .basdu-qr {
        text-align: right;
        width: 110px;
    }
    .basdu-qr img {
        width: 78px;
        height: 78px;
        display: inline-block;
    }
    .basdu-qr-label {
        font-size: 9px;
        color: #666;
        margin-top: 2px;
        text-align: center;
    }
</style>

<div class="basdu-cert">
    <div class="basdu-cert-inner">
        <table class="basdu-header">
            <tr>
                <td style="width:110px;">
                    <img class="basdu-dog" src="{{ $dogSrc }}" alt="BASDU">
                </td>
                <td class="basdu-brand">
                    <div class="basdu-brand-title">BASDU</div>
                    <div class="basdu-brand-sub">British Association of Security Dog Units</div>
                </td>
                <td style="width:110px;"></td>
            </tr>
        </table>

        <hr class="basdu-rule">
        <h1 class="basdu-title">Certificate of Operational Assessment</h1>
        <hr class="basdu-rule">

        <div class="basdu-intro">This is to certify that</div>
        <div class="basdu-handler">{{ $certificate->handler_name }}</div>
        <div class="basdu-statement">
            has been assessed as a competent General Purpose Security Dog Handler in accordance with the
            requirements of BS 8517-1:2016 – Code of practice for the use of security dogs in general-purpose applications.
        </div>

        <table class="basdu-mid">
            <tr>
                <td class="basdu-meta">
                    <div><strong>Date of Assessment:</strong> {{ $certificate->date_of_assessment->format('d F Y') }}</div>
                    <div><strong>Certificate No:</strong> {{ $certificate->certificate_number }}</div>
                    <div><strong>Training Organisation:</strong> {{ $certificate->training_organization }}</div>
                    <div><strong>Assessor:</strong> {{ $certificate->assessor_name }}</div>
                </td>
                <td style="width:300px;">
                    <div class="basdu-result">
                        <div class="basdu-result-head">Operational Assessment Result</div>
                        <div class="basdu-result-body">{{ $certificate->result }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="basdu-signs">
            <tr>
                <td>
                    <div class="basdu-sign-line"></div>
                    Trainer / BASDU
                </td>
                <td>
                    <div class="basdu-sign-line"></div>
                    Internal Quality Assurer (IQA) / BASDU
                </td>
                <td>
                    <div class="basdu-sign-line"></div>
                    Chief Executive / BASDU
                </td>
                <td>
                    <img class="basdu-seal" src="{{ $sealSrc }}" alt="Official Seal">
                </td>
            </tr>
        </table>

        <table class="basdu-codes">
            <tr>
                <td class="basdu-barcode">
                    <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode">
                    <div class="basdu-barcode-text">{{ $certificate->certificate_number }}</div>
                </td>
                <td class="basdu-qr">
                    <img src="data:image/png;base64,{{ $qr }}" alt="QR Code">
                    <div class="basdu-qr-label">Scan to verify</div>
                </td>
            </tr>
        </table>
    </div>
</div>
