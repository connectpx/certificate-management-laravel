<?php

namespace App\Services;

use App\Models\Certificate;
use Barryvdh\DomPDF\Facade\Pdf;
use chillerlan\QRCode\Output\QRGdImagePNG;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Http\Response;
use Intervention\Image\Format;
use Intervention\Image\Geometry\Factories\RectangleFactory;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Typography\FontFactory;
use Milon\Barcode\DNS1D;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CertificateExportService
{
    public function barcodeBase64(Certificate $certificate): string
    {
        return app(DNS1D::class)->getBarcodePNG($certificate->certificate_number, 'C128', 2, 70);
    }

    public function qrBase64(Certificate $certificate): string
    {
        $options = new QROptions([
            'outputInterface' => QRGdImagePNG::class,
            'scale' => 6,
            'outputBase64' => false,
            'quietzoneSize' => 1,
        ]);

        return base64_encode((new QRCode($options))->render($certificate->verify_url));
    }

    public function pdf(Certificate $certificate): Response
    {
        $pdf = Pdf::loadView('certificates.pdf', [
            'certificate' => $certificate,
            'barcode' => $this->barcodeBase64($certificate),
            'qr' => $this->qrBase64($certificate),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('certificate-'.$certificate->slug.'.pdf');
    }

    public function image(Certificate $certificate): StreamedResponse
    {
        $png = $this->renderPng($certificate);

        return response()->streamDownload(function () use ($png) {
            echo $png;
        }, 'certificate-'.$certificate->slug.'.png', [
            'Content-Type' => 'image/png',
        ]);
    }

    public function renderPng(Certificate $certificate): string
    {
        $width = 1754;
        $height = 1240;
        $navy = '#0b2a56';
        $ink = '#111111';
        $resultColor = $certificate->isPassed() ? $navy : '#8b1e1e';

        $serif = $this->fontPath('times.ttf');
        $serifBold = is_file(resource_path('fonts/timesbd.ttf'))
            ? $this->fontPath('timesbd.ttf')
            : $serif;
        $sans = is_file(resource_path('fonts/arial.ttf'))
            ? $this->fontPath('arial.ttf')
            : $this->fontPath('georgia.ttf');
        $sansBold = is_file(resource_path('fonts/arialbd.ttf'))
            ? $this->fontPath('arialbd.ttf')
            : $sans;
        $script = is_file(resource_path('fonts/script.ttf'))
            ? $this->fontPath('script.ttf')
            : $this->fontPath('georgia-italic.ttf');

        $image = Image::createImage($width, $height)->fill('#ffffff');

        // Double navy border
        $image->drawRectangle(function (RectangleFactory $rectangle) use ($width, $height, $navy): void {
            $rectangle->at(28, 28)->size($width - 56, $height - 56)->border($navy, 2);
        });
        $image->drawRectangle(function (RectangleFactory $rectangle) use ($width, $height, $navy): void {
            $rectangle->at(40, 40)->size($width - 80, $height - 80)->border($navy, 5);
        });

        // Dog logo top-left
        $dogPath = public_path('images/basdu-dog.jpg');
        if (is_file($dogPath)) {
            $dog = Image::decodePath($dogPath)->scale(height: 150);
            $image->insert($dog, 90, 70);
        }

        $this->writeText($image, 'BASDU', (int) ($width / 2), 120, $serifBold, 72, $navy, 'center');
        $this->writeText(
            $image,
            'BRITISH ASSOCIATION OF SECURITY DOG UNITS',
            (int) ($width / 2),
            175,
            $sansBold,
            16,
            $navy,
            'center'
        );

        // Rules + title
        $image->drawRectangle(function (RectangleFactory $rectangle) use ($width, $navy): void {
            $rectangle->at(90, 215)->size($width - 180, 2)->background($navy);
        });
        $this->writeText($image, 'CERTIFICATE OF OPERATIONAL ASSESSMENT', (int) ($width / 2), 260, $serifBold, 32, $navy, 'center');
        $image->drawRectangle(function (RectangleFactory $rectangle) use ($width, $navy): void {
            $rectangle->at(90, 295)->size($width - 180, 2)->background($navy);
        });

        $this->writeText($image, 'This is to certify that', (int) ($width / 2), 350, $serif, 20, $ink, 'center');
        $this->writeText($image, $certificate->handler_name, (int) ($width / 2), 430, $script, 64, $ink, 'center');

        $statement = 'has been assessed as a competent General Purpose Security Dog Handler in accordance with the';
        $statement2 = 'requirements of BS 8517-1:2016 – Code of practice for the use of security dogs in general-purpose applications.';
        $this->writeText($image, $statement, (int) ($width / 2), 510, $serif, 18, $ink, 'center');
        $this->writeText($image, $statement2, (int) ($width / 2), 540, $serif, 18, $ink, 'center');

        // Meta left
        $metaX = 120;
        $metaY = 620;
        $meta = [
            ['Date of Assessment:', $certificate->date_of_assessment->format('d F Y')],
            ['Certificate No:', $certificate->certificate_number],
            ['Training Organisation:', $certificate->training_organization],
            ['Assessor:', $certificate->assessor_name],
        ];
        foreach ($meta as [$label, $value]) {
            $this->writeText($image, $label, $metaX, $metaY, $serifBold, 18, $navy, 'left');
            $labelWidth = (int) (strlen($label) * 10.2);
            $this->writeText($image, $value, $metaX + $labelWidth + 12, $metaY, $serif, 18, $ink, 'left');
            $metaY += 38;
        }

        // Result box right
        $boxX = 1180;
        $boxY = 600;
        $boxW = 430;
        $boxH = 150;
        $image->drawRectangle(function (RectangleFactory $rectangle) use ($boxX, $boxY, $boxW, $boxH, $resultColor): void {
            $rectangle->at($boxX, $boxY)->size($boxW, $boxH)->border($resultColor, 3);
        });
        $image->drawRectangle(function (RectangleFactory $rectangle) use ($boxX, $boxY, $boxW, $resultColor): void {
            $rectangle->at($boxX, $boxY)->size($boxW, 42)->background($resultColor);
        });
        $this->writeText($image, 'OPERATIONAL ASSESSMENT RESULT', $boxX + (int) ($boxW / 2), $boxY + 22, $sansBold, 12, '#ffffff', 'center');
        $this->writeText($image, $certificate->result, $boxX + (int) ($boxW / 2), $boxY + 95, $sansBold, 56, $resultColor, 'center');

        // Signatures
        $signY = 880;
        $signLabels = [
            [220, 'TRAINER / BASDU'],
            [620, 'INTERNAL QUALITY ASSURER (IQA) / BASDU'],
            [1050, 'CHIEF EXECUTIVE / BASDU'],
        ];
        foreach ($signLabels as [$x, $label]) {
            $image->drawRectangle(function (RectangleFactory $rectangle) use ($x, $signY, $navy): void {
                $rectangle->at($x - 120, $signY)->size(240, 2)->background($navy);
            });
            $this->writeText($image, $label, $x, $signY + 28, $sansBold, 11, $navy, 'center');
        }

        // Seal
        $sealPath = public_path('images/basdu-seal.jpg');
        if (is_file($sealPath)) {
            $seal = Image::decodePath($sealPath)->scale(height: 160);
            $image->insert($seal, $width - 250, 820);
        }

        // Barcode + QR
        $barcodeBinary = base64_decode($this->barcodeBase64($certificate));
        $barcode = Image::decodeBinary($barcodeBinary)->scale(width: 420);
        $image->insert($barcode, (int) (($width - $barcode->width()) / 2) - 40, 1040);
        $this->writeText($image, $certificate->certificate_number, (int) ($width / 2) - 40, 1110, $sans, 13, $ink, 'center');

        $qrBinary = base64_decode($this->qrBase64($certificate));
        $qr = Image::decodeBinary($qrBinary)->scale(width: 100);
        $image->insert($qr, $width - 210, 1030);

        return (string) $image->encodeUsingFormat(Format::PNG);
    }

    private function writeText(
        mixed $image,
        string $text,
        int $x,
        int $y,
        string $fontFile,
        float $size,
        string $color,
        string $align = 'left'
    ): void {
        $image->text($text, $x, $y, function (FontFactory $font) use ($fontFile, $size, $color, $align): void {
            $font->filename($fontFile);
            $font->size($size);
            $font->color($color);
            $font->align($align, 'center');
        });
    }

    private function fontPath(string $filename): string
    {
        $path = resource_path('fonts/'.$filename);

        if (is_file($path)) {
            return $path;
        }

        $fallback = resource_path('fonts/georgia.ttf');

        if (! is_file($fallback)) {
            throw new \RuntimeException('Required certificate font is missing.');
        }

        return $fallback;
    }
}
