---
description: Sync or fresh-import production data from cnetposappproduction into cnetposapp
---

# Production Sync Workflow

**Full flow:**
```
Real Production Server
    → [1] Export dump.sql
    → [2] Import vào cnetposappproduction (local buffer)
    → [3] php _import_from_production.php --mode=sync
    → cnetposapp (local dev có data mới)
```

---

## BƯỚC 1 — Export dump từ server thật

```bash
mysqldump -u root -p ten_db_tren_server > dump_production.sql
```

---

## BƯỚC 2 — Import vào cnetposappproduction local

```bash
mysql -u root cnetposappproduction < dump_production.sql
```

---

## BƯỚC 3 — Chạy script sync

### Mode SYNC (khuyên dùng) – chỉ thêm record mới, không xóa gì
// turbo
```powershell
php _import_from_production.php --mode=sync
```

### Mode FRESH – reset hoàn toàn (xóa hết, import lại từ đầu)
```powershell
php _import_from_production.php --mode=fresh
```

**Fresh tự động làm:** `migrate:fresh` → `shield:generate` → `RolesAndPermissionsSeeder` → import → gán roles

---

## Lưu ý

- **Sync cơ chế:** `insertOrIgnore` theo primary key — record đã có bỏ qua, chỉ insert mới
- **Media:** track `custom_properties.legacy_id` → không duplicate khi sync nhiều lần
- **CustomerType:** `'individual'` = Cá nhân
- **admin_id → user_id:** tự động remap trong performers/watchers/assignees/comments

## Email → Role Map

| Email | Role |
|---|---|
| admin@cnetpos.com | super_admin |
| Dai@cnetpos.com | manager |
| Singa24h, Minhlt, Dongnd, tech @cnetpos.com | worker |
