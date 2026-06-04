<?php
// Render index.php to static HTML
ob_start();
include __DIR__ . '/index.php';
$html = ob_get_clean();
file_put_contents(__DIR__ . '/index.html', $html);
echo "Generated index.html: " . strlen($html) . " bytes\n";
