<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\View\View;

class VerifyController extends Controller
{
    public function show(string $slug): View
    {
        $certificate = Certificate::findBySlug($slug);

        if (! $certificate) {
            return view('public.verify', [
                'certificate' => null,
                'status' => 'not_found',
                'slug' => $slug,
            ]);
        }

        return view('public.verify', [
            'certificate' => $certificate,
            'status' => $certificate->isActive() ? 'valid' : 'invalid',
            'slug' => $slug,
        ]);
    }
}
