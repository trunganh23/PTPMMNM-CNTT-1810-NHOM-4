<style>body{background-color:#1e293b!important;color:#ffffff!important;} *{color:#ffffff!important;} .card,form{background-color:#334155!important;border:1px solid #475569!important;} input,select{background-color:#0f172a!important;color:#ffffff!important;} button,input[type="submit"]{background:#2563eb!important;color:#ffffff!important;}</style>
<?php
require __DIR__ . '/src/RegistrationRepository.php';
try {
    $repo = new RegistrationRepository(db());
    echo $repo->save(1, "O'Neil Demo", 'demo@example.test') . "\n";
    echo json_encode($repo->listForEvent(1), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
} catch (Throwable $e) {
    fwrite(STDERR, 'Database demo failed. Check lab configuration.\n');
    exit(1);
}
