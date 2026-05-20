<?php
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Load Data
$climate_junior = json_decode(file_get_contents('data/climate_sessions_junior.json'), true);
$climate_senior = json_decode(file_get_contents('data/climate_sessions_senior.json'), true);
$cnn_junior = json_decode(file_get_contents('data/cnn_sessions_junior.json'), true);
$cnn_senior = json_decode(file_get_contents('data/cnn_sessions_senior.json'), true);
$iot_junior = json_decode(file_get_contents('data/iot_sessions_junior.json'), true);
$iot_senior = json_decode(file_get_contents('data/iot_sessions_senior.json'), true);

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'THSarabunNew');
$options->set('isFontSubsettingEnabled', true);
$options->set('fontDir', realpath('dompdf_font_cache'));
$options->set('fontCache', realpath('dompdf_font_cache'));

$dompdf = new Dompdf($options);

// Get absolute path for fonts
$fontPath = realpath('assets/fonts/THSarabunNew.ttf');

// Define HTML with CSS for professional PDF look
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: "THSarabunNew";
            src: url("' . $fontPath . '") format("truetype");
            font-weight: normal;
            font-style: normal;
        }
        body { font-family: "THSarabunNew", sans-serif; line-height: 1.6; color: #333; font-size: 16px; }
        .cover { text-align: center; padding-top: 150px; page-break-after: always; }
        .title { font-size: 32px; font-weight: bold; color: #f97316; margin-bottom: 10px; }
        .subtitle { font-size: 18px; color: #666; }
        .section-title { font-size: 22px; font-weight: bold; border-bottom: 2px solid #f97316; padding-bottom: 5px; margin-top: 30px; color: #d97706; page-break-before: always; }
        .session-card { margin-bottom: 15px; padding: 10px; border: 1px solid #eee; border-radius: 8px; }
        .session-title { font-weight: bold; color: #f97316; font-size: 16px; }
        .code-block { background: #f1f5f9; padding: 8px; font-family: monospace; font-size: 11px; border-radius: 5px; white-space: pre-wrap; color: #1e293b; }
        .footer { position: fixed; bottom: -20px; left: 0; right: 0; height: 50px; text-align: center; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="footer">จัดทำโดย: ชีวะ ทัศนา  อาจารย์สาขาวิชาเทคโนโลยีดิจิทัลปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม     โครงการจัดตั้งศูนย์พัฒนานววัตกรรมดกษตรดิจิทัลรำไพพรรณี ประณีตวิทยาคม    Center for RBRU-Praneet Digital Agri-Innovation 2026</div>

    <div class="cover">
        <h1 class="title">หลักสูตรนวัตกรรมเกษตรดิจิทัล 2026</h1>
        <p class="subtitle">Agri-Innovation Curriculum Manual (Comprehensive Edition)</p>
        <p style="margin-top: 50px;">ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัลรำไพพรรณี-ประณีตวิทยาคม</p>
        <p>มหาวิทยาลัยราชภัฏรำไพพรรณี x โรงเรียนประณีตวิทยาคม</p>
    </div>

    <h2 class="section-title">Track 1: Climate Data Hacking</h2>
    <h3>[ Junior High / ม.ต้น ]</h3>
';

foreach ($climate_junior as $s) {
    $html .= '<div class="session-card"><div class="session-title">' . $s['title'] . '</div><p>' . $s['desc'] . '</p>';
    foreach ($s['examples'] as $ex) { $html .= '<strong>' . $ex['title'] . '</strong><div class="code-block">' . htmlspecialchars($ex['code']) . '</div>'; }
    $html .= '</div>';
}

$html .= '<h3>[ Senior High / ม.ปลาย ]</h3>';
foreach ($climate_senior as $s) {
    $html .= '<div class="session-card"><div class="session-title">' . $s['title'] . '</div><p>' . $s['desc'] . '</p>';
    foreach ($s['examples'] as $ex) { $html .= '<strong>' . $ex['title'] . '</strong><div class="code-block">' . htmlspecialchars($ex['code']) . '</div>'; }
    $html .= '</div>';
}

$html .= '<h2 class="section-title">Track 2: Deep Dive Lab (AI-CNN)</h2>';
$html .= '<h3>[ Junior High / ม.ต้น ]</h3>';
foreach ($cnn_junior as $s) {
    $html .= '<div class="session-card"><div class="session-title">' . $s['title'] . '</div><p>' . $s['desc'] . '</p>';
    foreach ($s['examples'] as $ex) { $html .= '<strong>' . $ex['title'] . '</strong><div class="code-block">' . htmlspecialchars($ex['code']) . '</div>'; }
    $html .= '</div>';
}

$html .= '<h3>[ Senior High / ม.ปลาย ]</h3>';
foreach ($cnn_senior as $s) {
    $html .= '<div class="session-card"><div class="session-title">' . $s['title'] . '</div><p>' . $s['desc'] . '</p>';
    foreach ($s['examples'] as $ex) { $html .= '<strong>' . $ex['title'] . '</strong><div class="code-block">' . htmlspecialchars($ex['code']) . '</div>'; }
    $html .= '</div>';
}

$html .= '<h2 class="section-title">Track 3: AI-IoT Prototyping</h2>';
$html .= '<h3>[ Junior High / ม.ต้น ]</h3>';
foreach ($iot_junior as $s) {
    $html .= '<div class="session-card"><div class="session-title">' . $s['title'] . '</div><p>' . $s['desc'] . '</p>';
    foreach ($s['examples'] as $ex) { $html .= '<strong>' . $ex['title'] . '</strong><div class="code-block">' . htmlspecialchars($ex['code']) . '</div>'; }
    $html .= '</div>';
}

$html .= '<h3>[ Senior High / ม.ปลาย ]</h3>';
foreach ($iot_senior as $s) {
    $html .= '<div class="session-card"><div class="session-title">' . $s['title'] . '</div><p>' . $s['desc'] . '</p>';
    foreach ($s['examples'] as $ex) { $html .= '<strong>' . $ex['title'] . '</strong><div class="code-block">' . htmlspecialchars($ex['code']) . '</div>'; }
    $html .= '</div>';
}

$html .= '
</body>
</html>
';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output the generated PDF
$dompdf->stream("Agri_Innovation_Manual_2026.pdf", array("Attachment" => 0));
?>
