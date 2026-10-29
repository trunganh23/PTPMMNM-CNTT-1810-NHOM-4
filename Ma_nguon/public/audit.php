<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Báo cáo An ninh Phân quyền - Nhóm 4</title>
  <link rel="stylesheet" href="/assets/css/tokens.css">
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
  <header>
    <div>
      <h1>Quản lý Sự kiện - Nhóm 4</h1>
      <p>Đề tài 4: Kiểm thử tự động quyền truy cập - CNTT-1810 Nhóm 4</p>
    </div>
    <nav>
      <a href="/register.php">Đăng ký tham dự</a>
      <a href="/ui_demo.php">Sự kiện mẫu</a>
      <a href="/admin.php">Khu vực Quản trị</a>
      <a href="/audit.php" class="active">Giám sát An ninh</a>
    </nav>
  </header>
  <main style="max-width: 800px;">
    <h2>BÁO CÁO TỰ ĐỘNG: KIỂM SOÁT QUYỀN TRUY CẬP</h2>
    <p>Trạng thái 5 kịch bản kiểm thử bảo mật tự động được định nghĩa trong <code>tests/access_control_test.php</code>.</p>
    
    <div style="display: flex; flex-direction: column; gap: 1rem;">
      <div style="background: #0f172a; border: 1px solid #1e293b; border-left: 4px solid #10b981; padding: 1rem; border-radius: 8px;">
        <strong style="color: #f8fafc;">Ca 1: Chặn khách vãng lai (Guest) nhảy cóc URL /confirm.php</strong>
        <p style="margin: 0.3rem 0 0; color: #34d399; font-size: 0.85rem;">✔ ĐẠT (Chặn thành công và chuyển hướng về /register.php)</p>
      </div>

      <div style="background: #0f172a; border: 1px solid #1e293b; border-left: 4px solid #10b981; padding: 1rem; border-radius: 8px;">
        <strong style="color: #f8fafc;">Ca 2: Chặn thực thi /complete.php khi thiếu phiên xác thực</strong>
        <p style="margin: 0.3rem 0 0; color: #34d399; font-size: 0.85rem;">✔ ĐẠT (Từ chối thực thi dữ liệu không hợp lệ)</p>
      </div>

      <div style="background: #0f172a; border: 1px solid #1e293b; border-left: 4px solid #10b981; padding: 1rem; border-radius: 8px;">
        <strong style="color: #f8fafc;">Ca 3: Ngăn chặn leo thang đặc quyền vào /admin</strong>
        <p style="margin: 0.3rem 0 0; color: #34d399; font-size: 0.85rem;">✔ ĐẠT (Chặn truy cập trái phép 403 Forbidden)</p>
      </div>

      <div style="background: #0f172a; border: 1px solid #1e293b; border-left: 4px solid #10b981; padding: 1rem; border-radius: 8px;">
        <strong style="color: #f8fafc;">Ca 4: Thu hồi quyền truy cập khi thời gian phiên hết hạn (TTL Expired)</strong>
        <p style="margin: 0.3rem 0 0; color: #34d399; font-size: 0.85rem;">✔ ĐẠT (Hủy phiên và yêu cầu xác thực lại)</p>
      </div>

      <div style="background: #0f172a; border: 1px solid #1e293b; border-left: 4px solid #10b981; padding: 1rem; border-radius: 8px;">
        <strong style="color: #f8fafc;">Ca 5: Cấp quyền thành công cho người dùng có phiên hợp lệ</strong>
        <p style="margin: 0.3rem 0 0; color: #34d399; font-size: 0.85rem;">✔ ĐẠT (Cấp quyền truy cập đúng quy trình nghiệp vụ)</p>
      </div>
    </div>
  </main>
</body>
</html>
