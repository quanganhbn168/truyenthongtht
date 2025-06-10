<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'image' => 'required|string',
            'banner' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'price_discount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        $this->productService->create($data);

        return $request->input('action') === 'save_new'
            ? redirect()->route('admin.products.create')->with('success', 'Đã thêm sản phẩm, bạn có thể tiếp tục thêm mới.')
            : redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'image' => 'required|string',
            'banner' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'price_discount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        $this->productService->update($product, $data);
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);
        return redirect()->route('admin.products.index')->with('success', 'Xoá sản phẩm thành công.');
    }
}
