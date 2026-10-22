<style>body{background-color:#1e293b!important;color:#ffffff!important;} *{color:#ffffff!important;} .card,form{background-color:#334155!important;border:1px solid #475569!important;} input,select{background-color:#0f172a!important;color:#ffffff!important;} button,input[type="submit"]{background:#2563eb!important;color:#ffffff!important;}</style>
<?php
declare(strict_types=1);
$tests = 0; $failed = 0;
function same(mixed $actual, mixed $expected, string $name): void {
    global $tests, $failed;
    $tests++;
    if ($actual === $expected) { echo "PASS $name\n"; }
    else { $failed++; echo "FAIL $name expected=" . var_export($expected, true)
        . " actual=" . var_export($actual, true) . "\n"; }
}
function finish(): never {
    global $tests, $failed;
    echo "TESTS=$tests FAILED=$failed\n";
    exit($failed === 0 ? 0 : 1);
}
