<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'image' => 'required|string',
            'banner' => 'nullable|string',
            'parent_id' => 'nullable|integer|exists:categories,id',
            'status' => 'nullable|boolean',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
        ]);

        $data['parent_id'] = $data['parent_id'] ?? 0;
        $data['status'] = $request->has('status') ? 1 : 0;

        $this->categoryService->create($data);

        return $request->input('action') === 'save_new'
        ? redirect()->route('admin.categories.create')->with('success', 'Đã thêm danh mục, bạn có thể tiếp tục thêm mới.')
        : redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)
                              ->where('parent_id', 0)
                              ->get();
        return view('admin.categories.edit',compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'image' => 'required|string',
            'banner' => 'nullable|string',
            'parent_id' => 'nullable|integer|exists:categories,id',
            'status' => 'nullable|boolean',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
        ]);

        $this->categoryService->update($category, $data);
        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (!$this->categoryService->delete($category)) {
            return redirect()->back()->with('error', 'Không thể xoá danh mục cha có danh mục con.');
        }

        return redirect()->route('admin.categories.index')->with('success', 'Xoá danh mục thành công.');
    }
}
