<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Certificate;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, string $slug): RedirectResponse
    {
        $certificate = Certificate::findBySlug($slug);

        abort_if(! $certificate || ! $certificate->isActive(), 404);

        $certificate->comments()->create([
            ...$request->validated(),
            'status' => Comment::STATUS_PENDING,
        ]);

        return back()->with('success', 'Comment submitted and awaiting approval.');
    }
}
