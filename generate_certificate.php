<?php
// generate_certificate.php - generate PDF certificate for a completed registration using dompdf (MySQL version)
require_once __DIR__ . '/vendor/autoload.php'; // Composer autoloader
require_once __DIR__ . '/db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
mb_internal_encoding('UTF-8');
ini_set('memory_limit', '256M');
set_time_limit(60);

use Dompdf\Dompdf;
use Dompdf\Options;

// Password check removed to allow public download for completed activities
// $adminPassword = 'admin123';
// if (!isset($_GET['pwd']) || $_GET['pwd'] !== $adminPassword) {
//     die('Unauthorized');
// }

if (!isset($_GET['id']) && !isset($_GET['reg_id'])) {
    die('Missing registration ID');
}
$regId = intval($_GET['id'] ?? $_GET['reg_id']);

try {
    // Fetch registration details
    $sql = "SELECT s.name, s.school, s.email, a.title, r.completed, r.registration_date 
            FROM registrations r 
            JOIN students s ON r.student_id = s.id 
            JOIN activities a ON r.activity_id = a.id 
            WHERE r.id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $regId]);
    $record = $stmt->fetch();

require_once __DIR__ . '/thai_date_helper.php';

    if (!$record) {
        die('Registration not found');
    }
    if (!$record['completed']) {
        die('Activity not marked as completed yet');
    }

    $name = $record['name'];
    $school = $record['school'];
    $activity = $record['title'];
    $date = getThaiDate($record['registration_date']);

    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('defaultFont', 'NotoSansThai');
    $options->set('isHtml5ParserEnabled', true);
    $options->set('chroot', __DIR__);
    $options->set('fontDir', __DIR__ . '/dompdf_font_cache');
    $options->set('fontCache', __DIR__ . '/dompdf_font_cache');
    
    $dompdf = new Dompdf($options);
    
    // Use absolute file path for PDF generation
    $fontRegularPath = __DIR__ . '/assets/fonts/NotoSansThai-Regular.ttf';
    $fontBoldPath = __DIR__ . '/assets/fonts/NotoSansThai-Bold.ttf';
    
    $fontCss = "
        @font-face {
            font-family: 'NotoSansThai';
            font-style: normal;
            font-weight: normal;
            src: url('file://$fontRegularPath') format('truetype');
        }
        @font-face {
            font-family: 'NotoSansThai';
            font-style: bold;
            font-weight: bold;
            src: url('file://$fontBoldPath') format('truetype');
        }
    ";
    
    // Get design parameter
    $design = isset($_GET['design']) ? $_GET['design'] : 'v1';
    
    // Determine template file
    $templateFile = __DIR__ . '/certificate_template.php'; // Default
    if ($design === 'v2') {
        $templateFile = __DIR__ . '/certificate_template_v2.php';
    } elseif ($design === 'v3') {
        $templateFile = __DIR__ . '/certificate_template_v3.php';
    }
    
    if (!file_exists($templateFile)) {
        $templateFile = __DIR__ . '/certificate_template.php'; 
        $design = 'v1';
    }

    $html = require $templateFile;

    $dompdf->loadHtml($html);

    // Setup paper size and orientation based on design
    if ($design === 'v2') {
        $dompdf->setPaper('A4', 'portrait');
    } else {
        $dompdf->setPaper('A4', 'landscape');
    }

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    if (isset($_GET['preview'])) {
        $dompdf->stream("certificate_preview.pdf", ["Attachment" => 0]);
    } else {
        $dompdf->stream("certificate_{$regId}.pdf", ["Attachment" => 1]);
    }

} catch (Throwable $e) {
    die("Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
}
?>
