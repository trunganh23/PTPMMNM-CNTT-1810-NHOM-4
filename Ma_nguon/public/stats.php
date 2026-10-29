<?php
declare(strict_types=1);

$connStr = "host=127.0.0.1 port=5432 dbname=communitypass_lab_v5 user=communitypass_lab_v5 password=Trunganh2307";
$conn = @pg_connect($connStr);

$stats = [];
if ($conn) {
    $sql = "SELECT e.id, e.title, COUNT(r.id)::int AS total 
            FROM events e 
            LEFT JOIN registrations r ON e.id = r.event_id 
            GROUP BY e.id, e.title 
            ORDER BY e.id ASC";
    $res = pg_query($conn, $sql);
    if ($res) {
        while ($row = pg_fetch_assoc($res)) {
            $stats[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Thống kê Sự kiện - Nhóm 4</title>
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
      <a href="/stats.php" class="active">Thống kê CSDL</a>
      <a href="/check_access.php">Kiểm tra Phân quyền</a>
    </nav>

    <h2>Báo cáo Thống kê Lượt đăng ký (Lab 05)</h2>
    <p style="color: #94a3b8; margin-top: 0;">Truy vấn tổng hợp số lượng đăng ký theo từng sự kiện từ CSDL PostgreSQL:</p>

    <div style="background: #111827; border: 1px solid #1f2937; border-radius: 12px; padding: 1.5rem; overflow-x: auto;">
      <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
        <thead>
          <tr style="border-bottom: 2px solid #374151; color: #38bdf8;">
            <th style="padding: 10px;">ID</th>
            <th style="padding: 10px;">Tên sự kiện</th>
            <th style="padding: 10px;">Tổng số người đã đăng ký</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($stats as $item): ?>
            <tr style="border-bottom: 1px solid #1f2937;">
              <td style="padding: 12px 10px; font-weight: bold;">#<?= htmlspecialchars((string)$item['id']) ?></td>
              <td style="padding: 12px 10px;"><?= htmlspecialchars((string)$item['title']) ?></td>
              <td style="padding: 12px 10px;"><span style="background: rgba(37,99,235,0.25); color: #60a5fa; padding: 4px 10px; border-radius: 20px; font-weight: bold; border: 1px solid rgba(37,99,235,0.4);"><?= htmlspecialchars((string)$item['total']) ?> người</span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
