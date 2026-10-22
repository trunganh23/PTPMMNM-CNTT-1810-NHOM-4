<style>body{background-color:#1e293b!important;color:#ffffff!important;} *{color:#ffffff!important;} .card,form{background-color:#334155!important;border:1px solid #475569!important;} input,select{background-color:#0f172a!important;color:#ffffff!important;} button,input[type="submit"]{background:#2563eb!important;color:#ffffff!important;}</style>
<?php
require __DIR__ . '/../src/Database.php';
try {
    $c = db();
    $r = queryParams($c, 'SELECT current_database() AS db, current_user AS u', []);
    $v = pg_fetch_assoc($r);
    echo 'CSDL=' . $v['db'] . ' | USER=' . $v['u'] . "\n";
} catch (Throwable $e) {
    fwrite(STDERR, 'CHUA_SAN_SANG_CSDL: ' . $e->getMessage() . "\nChạy bash lab.sh db-config sau khi tạo CSDL lab.\n");
    exit(2);
}
