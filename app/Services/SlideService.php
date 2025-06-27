<?php

namespace App\Services;

use App\Models\Slide;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class SlideService
{
    use UploadImageTrait;

    public function create(Request $request): Slide
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'position' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage(
                $request->file('image'),
                folder: 'uploads/slides',
                resizeWidth: 1920,
                resizeHeight: 800,
                convertToWebp: true,
                watermarkPath: ''
            );
        }

        return Slide::create($data);
    }

    public function update(Request $request, Slide $slide): Slide
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'position' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($slide->image) {
                $this->deleteImage($slide->image);
            }

            $data['image'] = $this->uploadImage(
                $request->file('image'),
                folder: 'uploads/slides',
                resizeWidth: 1920,
                resizeHeight: 800,
                convertToWebp: true,
                watermarkPath: ''
            );
        }

        $slide->update($data);
        return $slide;
    }

    public function delete(Slide $slide): void
    {
        if ($slide->image) {
            $this->deleteImage($slide->image);
        }

        $slide->delete();
    }
}
