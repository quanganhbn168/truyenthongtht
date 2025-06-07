<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use App\Services\SlideService;

class SlideController extends Controller
{
    protected SlideService $service;

    public function __construct(SlideService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $slides = $this->service->getAll();
        return view('admin.slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.slides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|url',
            'sort_order' => 'nullable|integer',
            'status' => 'boolean',
            'image' => 'required|string|max:255',
        ]);

        $this->service->create($request);

        return match ($request->input('action')) {
            'save_new' => redirect()->route('admin.slides.create')->with('success', 'Slide đã tạo, tiếp tục thêm mới.'),
            default    => redirect()->route('admin.slides.index')->with('success', 'Tạo slide thành công.'),
        };
    }

    public function show(Slide $slide)
    {
        return view('admin.slides.show', compact('slide'));
    }

    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|url',
            'sort_order' => 'nullable|integer',
            'status' => 'boolean',
            'image' => 'nullable|string|max:255', // FilePond path hoặc giữ nguyên ảnh cũ
        ]);

        $this->service->update($request, $slide);

        return match ($request->input('action')) {
            'save_new' => redirect()->route('admin.slides.create')->with('success', 'Slide đã cập nhật, tiếp tục thêm mới.'),
            default    => redirect()->route('admin.slides.index')->with('success', 'Cập nhật slide thành công.'),
        };
    }

    public function destroy(Slide $slide)
    {
        $this->service->delete($slide);
        return redirect()->route('admin.slides.index')->with('success', 'Đã xoá slide.');
    }

    public function toggleStatus(Slide $slide)
    {
        $slide = $this->service->updateStatus($slide, !$slide->status);
        return response()->json(['success' => true, 'status' => $slide->status]);
    }

    public function updatePosition(Request $request, Slide $slide)
    {
        $this->service->updateSortOrder($slide, $request->input('sort_order', 0));
        return response()->json(['success' => true]);
    }
}
