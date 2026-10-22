<style>body{background-color:#1e293b!important;color:#ffffff!important;} *{color:#ffffff!important;} .card,form{background-color:#334155!important;border:1px solid #475569!important;} input,select{background-color:#0f172a!important;color:#ffffff!important;} button,input[type="submit"]{background:#2563eb!important;color:#ffffff!important;}</style>
<?php
require __DIR__ . '/../src/Database.php';
try {
    db();
} catch (Throwable $e) {
    fwrite(STDERR, "Chưa kết nối được CSDL.\n");
    exit(2);
}
$proc = proc_open(['psql', '-v', 'ON_ERROR_STOP=1'], [0 => STDIN, 1 => STDOUT, 2 => STDERR], $pipes);
if (!is_resource($proc)) {
    exit(2);
}
exit(proc_close($proc));
