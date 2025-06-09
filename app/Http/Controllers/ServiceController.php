<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ServiceService;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        $services = $this->serviceService->getAll();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:services,slug',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'price' => 'nullable|numeric',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->serviceService->create($request->all());

        return redirect()->route('admin.services.index')->with('success', 'Thêm dịch vụ thành công.');
    }

    public function edit($id)
    {
        $service = $this->serviceService->findById($id);
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:services,slug,' . $id,
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'price' => 'nullable|numeric',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->serviceService->update($id, $request->all());

        return redirect()->route('admin.services.index')->with('success', 'Cập nhật dịch vụ thành công.');
    }

    public function destroy($id)
    {
        $this->serviceService->delete($id);
        return redirect()->route('admin.services.index')->with('success', 'Xóa dịch vụ thành công.');
    }

    public function show($slug)
    {
        $service = $this->serviceService->findBySlug($slug);
        return view('frontend.services.show', compact('service'));
    }
}
