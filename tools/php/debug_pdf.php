<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isFontSubsettingEnabled', false); // Try disabling subsetting
$options->set('isHtml5ParserEnabled', true);
$options->set('tempDir', realpath('../../tmp'));
$dompdf = new Dompdf($options);

$fontData = base64_encode(file_get_contents('../../assets/fonts/NotoSansThai-Regular.ttf'));

$html = '
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: "NotoThai";
            src: url(data:font/truetype;base64,' . $fontData . ') format("truetype");
        }
        body { font-family: "NotoThai", sans-serif; font-size: 16px; }
    </style>
</head>
<body>
    <h1>ทดสอบภาษาไทย (Thai Test)</h1>
    <p>หากเห็นภาษาไทย แสดงว่าสำเร็จแล้วครับ</p>
    <p>สระ เอ อา โอ ไอ เอา - ก ข ค ง</p>
</body>
</html>
';

$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("debug_final.pdf", array("Attachment" => 0));
?>
