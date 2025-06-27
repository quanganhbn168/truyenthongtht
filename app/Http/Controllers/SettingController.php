<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Traits\UploadImageTrait;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    use UploadImageTrait;

    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'nullable|email',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:255',
            'map'            => 'nullable|string',
            'schema_script'  => 'nullable|string',
            'head_script'    => 'nullable|string',
            'body_script'    => 'nullable|string',
            'logo'           => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'favicon'        => 'nullable|image|mimes:ico,png,jpg,jpeg|max:512',
        ]);

        // Logo upload
        if ($request->hasFile('logo')) {
            if ($setting && $setting->logo) {
                $this->deleteImage($setting->logo);
            }

            $data['logo'] = $this->uploadImage(
                $request->file('logo'),
                folder: 'settings',        // folder
                resizeWidth: 512,          // optional: resize nhỏ cho logo
                convertToWebp: true,
                watermarkPath: ''          // watermark = false
            );
        }

        // Favicon upload
        if ($request->hasFile('favicon')) {
                if ($setting && $setting->favicon) {
                    $this->deleteImage($setting->favicon);
                }

                $this->generateFavicon($request->file('favicon'));
                $data['favicon'] = 'favicon/favicon-32x32.png';
            }

        $setting ? $setting->update($data) : Setting::create($data);

        return redirect()->route('admin.settings.index')->with('success', 'Cập nhật cài đặt thành công.');
    }

    protected function generateFavicon(UploadedFile $file): void
    {
        $folder = public_path('favicon');

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $image = Image::make($file->getRealPath())->encode('png');

        $sizes = [
            'favicon-16x16.png'       => 16,
            'favicon-32x32.png'       => 32,
            'apple-touch-icon.png'    => 180,
            'icon-192.png'            => 192,
            'icon-512.png'            => 512,
        ];

        foreach ($sizes as $name => $size) {
            $image->resize($size, $size)->save($folder . '/' . $name);
        }
    }


}
