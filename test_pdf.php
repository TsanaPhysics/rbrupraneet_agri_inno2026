<?php
require_once __DIR__ . '/vendor/autoload.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

use Dompdf\Dompdf;

try {
    $dompdf = new Dompdf();
    $dompdf->loadHtml('<h1>Hello World</h1>');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    echo "PDF GENERATED SUCCESSFULLY LENGTH: " . strlen($dompdf->output());
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage();
}
?>
