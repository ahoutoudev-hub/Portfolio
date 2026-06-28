<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Upload d'image depuis TinyMCE.
     * TinyMCE attend : { "location": "url_de_l_image" }
     */
    public function image(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
        ]);

        $path = $request->file('file')->store('tinymce', 'public');

        return response()->json([
            'location' => Storage::disk('public')->url($path),
        ]);
    }
}
