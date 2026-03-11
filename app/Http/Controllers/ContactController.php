<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Settings\PageSettings;
use App\Settings\WebsiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Hiển thị trang Liên hệ.
     */
    public function index()
    {
        return view('pages.contact');
    }

    /**
     * Lưu liên hệ vào DB + gửi email thông báo cho admin.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:255',
            'message' => 'nullable|string|max:2000',
            'subject' => 'nullable|string|max:255',
        ]);

        // 1. Lưu vào database
        $contact = Contact::create($data);

        // 2. Gửi email thông báo cho admin (nếu cấu hình MAIL_FROM_ADDRESS)
        $adminEmail = config('mail.from.address');
        if ($adminEmail && filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::send([], [], function ($message) use ($contact, $adminEmail) {
                    $message->to($adminEmail)
                        ->subject('Liên hệ mới từ ' . $contact->name . ' - ' . config('app.name'))
                        ->html(view('emails.contact-notify', ['contact' => $contact])->render());
                });
            } catch (\Exception $e) {
                // Không break nếu mail lỗi, chỉ log
                logger()->error('Contact mail failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong vòng 24 giờ.');
    }
}
