<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Service;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        // Lấy service_id từ query parameter (nếu khách click từ trang chi tiết dịch vụ)
        $selectedServiceId = $request->query('service_id');
        
        return view('pages.quote', compact('services', 'selectedServiceId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'company_name' => 'nullable|string|max:255',
            'service_id' => 'nullable|exists:services,id',
            'budget_range' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'email.email' => 'Email không đúng định dạng.',
        ]);

        $validated['status'] = 'new'; // Mặc định là mới
        
        Quote::create($validated);

        return redirect()->back()->with('success', 'Gửi yêu cầu nhận báo giá thành công! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.');
    }
}
