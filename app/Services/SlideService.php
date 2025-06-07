<?php
namespace App\Services;

use App\Models\Slide;
use Illuminate\Http\Request;
use App\Traits\UploadImageTrait;

class SlideService
{
    use UploadImageTrait;

    public function getAll(): \Illuminate\Support\Collection
    {
        return Slide::orderBy('position')->get();
    }

    public function create(Request $request): Slide
    {
        $data = $request->only(['title', 'link', 'position', 'status','image']);
        return Slide::create($data);
    }

    public function update(Request $request, Slide $slide): Slide
    {
        $data = $request->only(['title', 'link', 'position', 'status','image']);

        if ($request->hasFile('image')) {
            $this->deleteImage($slide->image);
            $data['image'] = $this->uploadImage(
                $request->file('image'),
                'uploads/slides',
                1200,
                true,
                'watermarks/logo.png'
            );
        }

        $slide->update($data);
        return $slide;
    }

    public function delete(Slide $slide): bool
    {
        $this->deleteImage($slide->image);
        return $slide->delete();
    }

    public function updateStatus(Slide $slide, bool $status): Slide
    {
        $slide->status = $status;
        $slide->save();
        return $slide;
    }

    public function updateSortOrder(Slide $slide, int $position): Slide
    {
        $slide->position = $position;
        $slide->save();
        return $slide;
    }
}
