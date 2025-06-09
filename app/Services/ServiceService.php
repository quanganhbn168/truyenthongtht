<?php
namespace App\Services;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Traits\UploadImageTrait;

class ServiceService
{
    use UploadImageTrait;

    public function getAll(): \Illuminate\Support\Collection
    {
        return Service::get();
    }

    public function create(Request $request): Slide
    {
        $data = $request->only(['title', 'link', 'position', 'status','image']);
        return Service::create($data);
    }

    public function update(Request $request, Slide $slide): Slide
    {
        $data = $request->only(['title', 'link', 'position', 'status','image']);
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
