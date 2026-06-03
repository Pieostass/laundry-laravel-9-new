<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Xử lý upload ảnh từ TinyMCE editor
 * Route: POST /admin/upload/image  name: admin.upload.image
 */
class ImageUploadController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
        ]);

        $path = $request->file('file')->store('posts/content', 'public');

        return response()->json([
            'location' => Storage::disk('public')->url($path),
        ]);
    }
}