<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8">
<title>Liên hệ mới</title>
<style>
  body { font-family: Arial, sans-serif; color: #333; background: #f5f5f5; margin: 0; padding: 20px; }
  .card { background: #fff; border-radius: 8px; max-width: 600px; margin: 0 auto; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
  h1 { color: #d32f2f; font-size: 1.4rem; margin-top: 0; }
  table { width: 100%; border-collapse: collapse; margin-top: 16px; }
  td { padding: 10px 12px; border-bottom: 1px solid #eee; font-size: 0.95rem; }
  td:first-child { font-weight: 600; color: #555; width: 130px; }
  .message-box { background: #f9f9f9; border-left: 4px solid #d32f2f; padding: 12px 16px; margin-top: 16px; border-radius: 4px; font-size: 0.9rem; line-height: 1.7; white-space: pre-wrap; }
  .footer { text-align: center; margin-top: 24px; font-size: 0.8rem; color: #999; }
</style>
</head>
<body>
<div class="card">
  <h1>📬 Liên hệ mới từ website {{ config('app.name') }}</h1>
  <table>
    <tr><td>Họ tên</td><td>{{ $contact->name }}</td></tr>
    <tr><td>Điện thoại</td><td><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></td></tr>
    @if($contact->email)
    <tr><td>Email</td><td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td></tr>
    @endif
    @if($contact->subject)
    <tr><td>Chủ đề</td><td>{{ $contact->subject }}</td></tr>
    @endif
    <tr><td>Thời gian</td><td>{{ $contact->created_at->format('H:i - d/m/Y') }}</td></tr>
  </table>
  @if($contact->message)
  <div class="message-box">{{ $contact->message }}</div>
  @endif
  <div class="footer">Email tự động từ {{ config('app.name') }} — Không trả lời email này</div>
</div>
</body>
</html>
