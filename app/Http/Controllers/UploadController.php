<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use App\Traits\UploadImageTrait;
use App\Traits\UploadVideoTrait;
use App\Traits\UploadDocumentTrait;

class UploadController extends Controller
{
    use UploadImageTrait, UploadVideoTrait, UploadDocumentTrait;

    public function upload(Request $request)
    {
        $field = $request->input('field', 'file');
        $folder = $request->input('folder', 'uploads/images');

        if (!$request->hasFile($field)) {
            return response()->json(['error' => "Không có file trong field [$field]."], 422);
        }

        $files = $request->file($field);
        $files = is_array($files) ? $files : [$files];

        $uploadedPaths = [];

        foreach ($files as $file) {
            $mime = $file->getMimeType();
            $ext = strtolower($file->getClientOriginalExtension());

            try {
                if (Str::startsWith($mime, 'image/')) {
                    $watermarkPath = 'images/watermarks/logo.png';
                    $path = $this->uploadImage($file, $folder,1920,true,$watermarkPath);
                } elseif (Str::startsWith($mime, 'video/') && in_array($ext, ['mp4'])) {
                    $path = $this->uploadVideo($file, 'uploads/videos');
                } elseif (
                    Str::startsWith($mime, 'application/') ||
                    in_array($ext, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])
                ) {
                    $path = $this->uploadDocument($file, 'uploads/docs');
                } else {
                    return response()->json(['error' => 'Định dạng không hỗ trợ.'], 422);
                }

                $uploadedPaths[] = $path;
            } catch (\Throwable $e) {
                return response()->json(['error' => 'Lỗi xử lý file: ' . $e->getMessage()], 500);
            }
        }

        return response()->json([
            'field' => $field,
            'paths' => count($uploadedPaths) === 1 ? $uploadedPaths[0] : $uploadedPaths,
            'urls' => collect($uploadedPaths)->map(fn($p) => asset($p)),
        ]);
    }
}
