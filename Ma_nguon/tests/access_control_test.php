<?php
declare(strict_types=1);

/**
 * ĐỀ TÀI 4: XÂY DỰNG CÔNG CỤ KIỂM THỬ TỰ ĐỘNG QUYỀN TRUY CẬP TRONG ỨNG DỤNG WEB
 * Thực hiện: Nhóm 4 (CNTT-1810)
 * Sinh viên: trunganh23
 * Mục tiêu: Tự động phát hiện và kiểm thử các lỗi kiểm soát quyền truy cập (Broken Access Control)
 */

namespace AccessControlTester;

class AccessPolicy {
    public const ROLE_GUEST = 'GUEST';
    public const ROLE_USER  = 'USER';
    public const ROLE_ADMIN = 'ADMIN';

    public static function canAccess(string $role, string $endpoint, bool $hasActiveSession = false): bool {
        // 1. Phân quyền endpoint theo vai trò
        $restricted = [
            '/admin/events' => [self::ROLE_ADMIN],
            '/confirm.php'  => [self::ROLE_USER, self::ROLE_ADMIN],
            '/complete.php' => [self::ROLE_USER, self::ROLE_ADMIN],
            '/register.php' => [self::ROLE_GUEST, self::ROLE_USER, self::ROLE_ADMIN],
        ];

        if (!isset($restricted[$endpoint])) {
            return true;
        }

        // Bắt buộc phải có phiên hợp lệ đối với các trang xác nhận/hoàn tất
        if (in_array($endpoint, ['/confirm.php', '/complete.php'], true) && !$hasActiveSession) {
            return false;
        }

        return in_array($role, $restricted[$endpoint], true);
    }

    public static function validateTokenExpiry(int $createdAt, int $ttl = 3600): bool {
        return (time() - $createdAt) <= $ttl;
    }
}

$testsPassed = 0;
$totalTests = 0;

function assertAccessTest(string $testName, bool $condition): void {
    global $testsPassed, $totalTests;
    $totalTests++;
    echo "[TEST {$totalTests}] " . str_pad($testName, 65, '.') . " ";
    if ($condition) {
        echo "\033[32m[PASS]\033[0m\n";
        $testsPassed++;
    } else {
        echo "\033[31m[FAIL]\033[0m\n";
    }
}

echo "\n=== CÔNG CỤ KIỂM THỬ TỰ ĐỘNG QUYỀN TRUY CẬP (ACCESS CONTROL SUITE) - NHÓM 4 ===\n";

// Test 1: Ngăn chặn Guest truy cập thẳng vào trang xác nhận khi chưa tạo bản nháp (Bypass Draft)
assertAccessTest(
    "Chặn khách vãng lai (Guest) truy cập trái phép /confirm.php",
    AccessPolicy::canAccess(AccessPolicy::ROLE_GUEST, '/confirm.php', false) === false
);

// Test 2: Chặn hoàn tất đăng ký khi không tồn tại phiên hợp lệ
assertAccessTest(
    "Chặn thực thi /complete.php khi thiếu phiên xác thực",
    AccessPolicy::canAccess(AccessPolicy::ROLE_USER, '/complete.php', false) === false
);

// Test 3: Kiểm soát phân quyền ngang/dọc - Ngăn chặn người dùng thường vào trang quản trị
assertAccessTest(
    "Ngăn chặn leo thang đặc quyền (Privilege Escalation) vào /admin/events",
    AccessPolicy::canAccess(AccessPolicy::ROLE_USER, '/admin/events', true) === false
);

// Test 4: Tự động thu hồi quyền thao tác khi Token/Phiên hết hạn (Session Timeout)
assertAccessTest(
    "Thu hồi quyền truy cập khi thời gian hiệu lực của phiên hết hạn (TTL Expired)",
    AccessPolicy::validateTokenExpiry(time() - 7200, 3600) === false
);

// Test 5: Cho phép người dùng có đầy đủ phiên hợp lệ thao tác đúng luồng
assertAccessTest(
    "Xác thực cấp quyền thành công cho người dùng có phiên hợp lệ",
    AccessPolicy::canAccess(AccessPolicy::ROLE_USER, '/confirm.php', true) === true
);

echo "================================================================================\n";
echo "KẾT QUẢ ĐÁNH GIÁ: Đạt {$testsPassed}/{$totalTests} ca kiểm thử tự động.\n";
if ($testsPassed === $totalTests) {
    echo "\033[32m=> KẾT LUẬN: CÔNG CỤ XÁC NHẬN CHÍNH SÁCH KIỂM SOÁT QUYỀN TRUY CẬP HOẠT ĐỘNG CHUẨN XÁC!\033[0m\n\n";
} else {
    echo "\033[31m=> CẢNH BÁO: PHÁT HIỆN LỖ HỔNG KIỂM SOÁT QUYỀN TRUY CẬP (BROKEN ACCESS CONTROL)!\033[0m\n\n";
}
