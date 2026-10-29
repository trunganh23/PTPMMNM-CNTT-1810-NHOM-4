<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Database.php';

$connection = get_db_connection();
$result = pg_query($connection, "SELECT r.id, e.title as event_title, r.name, r.email, r.created_at FROM registrations r JOIN events e ON r.event_id = e.id ORDER BY r.id DESC");
$registrations = [];
if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $registrations[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Khu vực Quản trị - Nhóm 4</title>
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
      <a href="/admin.php" class="active">Khu vực Quản trị</a>
      <a href="/audit.php">Giám sát An ninh</a>
    </nav>
  </header>
  <main style="max-width: 900px;">
    <h2>DANH SÁCH THAM DỰ VIÊN (ADMIN ONLY)</h2>
    <p>Dữ liệu truy xuất trực tiếp từ bảng <code>registrations</code> trong PostgreSQL (Yêu cầu vai trò: <b>Admin</b>).</p>
    
    <div style="background: var(--bg-surface, #0f172a); border: 1px solid var(--border-subtle, #1e293b); border-radius: 12px; padding: 1.5rem; overflow-x: auto;">
      <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
        <thead>
          <tr style="border-bottom: 2px solid #334155; color: #38bdf8;">
            <th style="padding: 10px;">ID</th>
            <th style="padding: 10px;">Họ tên</th>
            <th style="padding: 10px;">Email</th>
            <th style="padding: 10px;">Sự kiện</th>
            <th style="padding: 10px;">Thời gian tạo</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($registrations)): ?>
            <tr><td colspan="5" style="padding: 15px; text-align: center; color: #94a3b8;">Chưa có bản ghi nào.</td></tr>
          <?php else: ?>
            <?php foreach ($registrations as $r): ?>
              <tr style="border-bottom: 1px solid #1e293b;">
                <td style="padding: 10px; font-weight: bold;"><?= htmlspecialchars((string)$r['id']) ?></td>
                <td style="padding: 10px;"><?= htmlspecialchars((string)$r['name']) ?></td>
                <td style="padding: 10px; color: #cbd5e1;"><?= htmlspecialchars((string)$r['email']) ?></td>
                <td style="padding: 10px; color: #34d399;"><?= htmlspecialchars((string)$r['event_title']) ?></td>
                <td style="padding: 10px; color: #94a3b8; font-size: 0.8rem;"><?= htmlspecialchars((string)$r['created_at']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
