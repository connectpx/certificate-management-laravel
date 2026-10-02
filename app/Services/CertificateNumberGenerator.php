<?php

namespace App\Services;

use App\Models\Certificate;

class CertificateNumberGenerator
{
    public function generate(?int $year = null): string
    {
        $year ??= (int) now()->year;
        $prefix = sprintf('BASDU/OA/%d/', $year);

        $latest = Certificate::withTrashed()
            ->where('certificate_number', 'like', $prefix.'%')
            ->orderByDesc('certificate_number')
            ->value('certificate_number');

        $sequence = 1;

        if ($latest && preg_match('/\/(\d+)$/', $latest, $matches)) {
            $sequence = ((int) $matches[1]) + 1;
        }

        return $prefix.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
