<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ImageUpload;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $path = ImageUpload::upload($request->file('image'));
        
        return response()->json([
            'url' => Storage::url('public/' . $path)
        ]);
    }
}
