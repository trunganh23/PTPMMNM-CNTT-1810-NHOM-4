<?php
declare(strict_types=1);

$role = $_GET['role'] ?? 'guest';
$page = $_GET['page'] ?? 'confirm';

$status = 'BỊ CHẶN (403 Forbidden)';
$isAllowed = false;
$detail = '';

if ($page === 'confirm') {
    $hasDraft = ($role === 'user_with_draft');
    $isAllowed = $hasDraft;
    $detail = $isAllowed ? 'Cho phép truy cập vì đã khởi tạo bản nháp tại register.php' : 'BỊ CHẶN: Khách vãng lai chưa điền form không thể nhảy cóc vào xem bản nháp';
} elseif ($page === 'admin') {
    $isAllowed = ($role === 'admin');
    $detail = $isAllowed ? 'Cấp quyền Quản trị viên thành công' : 'BỊ CHẶN: Ngăn chặn leo thang đặc quyền (Privilege Escalation)';
}$statusText = $isAllowed ? '<span style="color: #34d399; font-weight: bold;">[CHO PHÉP TRUY CẬP]</span>' : '<span style="color: #ef4444; font-weight: bold;">[BỊ TỪ CHỐI / CHẶN ĐỨNG]</span>';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Mô phỏng Kiểm thử Phân quyền - Nhóm 4</title>
  <link rel="stylesheet" href="/assets/css/tokens.css">
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
  <header>
    <h1>Quản lý Sự kiện – Nhóm 4</h1>
    <p>Đề tài 4: Kiểm thử tự động quyền truy cập - CNTT-1810 Nhóm 4</p>
  </header>
  <main>
    <nav>
      <a href="/">Danh sách sự kiện</a>
      <a href="/ui_demo.php">Sự kiện mẫu</a>
      <a href="/register.php">Đăng ký tham dự</a>
      <a href="/stats.php">Thống kê CSDL</a>
      <a href="/check_access.php" class="active">Kiểm tra Phân quyền</a>
    </nav>

    <h2>Mô phỏng Cơ chế Kiểm thử Quyền truy cập (Đề tài 4)</h2>
    <p style="color: #94a3b8; margin-top: 0;">Giao diện trực quan mô phỏng lại logic của file kiểm thử tự động <code>tests/access_control_test.php</code>:</p>

    <form method="GET" action="/check_access.php" style="margin-bottom: 2rem;">
      <div class="field">
        <label>CHỌN VAI TRÒ NGƯỜI DÙNG:</label>
        <select name="role">
          <option value="guest" <?= $role === 'guest' ? 'selected' : '' ?>>Khách vãng lai (Guest - Chưa điền form)</option>
          <option value="user_with_draft" <?= $role === 'user_with_draft' ? 'selected' : '' ?>>Người dùng hợp lệ (Đã điền form & có Session Draft)</option>
          <option value="attendee" <?= $role === 'attendee' ? 'selected' : '' ?>>Người dùng thông thường (Role: Attendee)</option>
          <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Quản trị viên hệ thống (Role: Admin)</option>
        </select>
      </div>

      <div class="field">
        <label>CHỌN TRANG MUỐN TRUY CẬP:</label>
        <select name="page">
          <option value="confirm" <?= $page === 'confirm' ? 'selected' : '' ?>>Trang xác nhận bản nháp (/confirm.php)</option>
          <option value="admin" <?= $page === 'admin' ? 'selected' : '' ?>>Trang quản trị bảo mật (/admin/events)</option>
        </select>
      </div>

      <button type="submit">Kiểm tra phản hồi của Hệ thống</button>
    </form>

    <div style="background: #111827; border: 1px solid #1f2937; border-radius: 12px; padding: 1.5rem;">
      <h3 style="margin-top: 0; color: #38bdf8; font-size: 1.05rem;">KẾT QUẢ KIỂM THỬ TỪ HỆ THỐNG:</h3>
      <p style="margin: 0.5rem 0;">Trạng thái: <?= $statusText ?></p>
      <p style="margin: 0; color: #94a3b8; font-size: 0.95rem;">Chi tiết xử lý: <b style="color: #fff;"><?= htmlspecialchars($detail) ?></b></p>
    </div>
  </main>
</body>
</html>
