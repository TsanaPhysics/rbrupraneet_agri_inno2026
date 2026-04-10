<?php
require_once 'db_connect.php';

$regId = $_GET['id'] ?? null;

if (!$regId) {
    die("Invalid Request");
}

// Reuse logic to fetch data
$sql = "SELECT s.name, s.school, a.title, r.completed, r.registration_date 
        FROM registrations r 
        JOIN students s ON r.student_id = s.id 
        JOIN activities a ON r.activity_id = a.id 
        WHERE r.id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $regId]);
$record = $stmt->fetch();

require_once 'thai_date_helper.php';

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

// Use relative web path for Browser View
$fontCss = "
    @font-face {
        font-family: 'NotoSansThai';
        font-style: normal;
        font-weight: normal;
        src: url('assets/fonts/NotoSansThai-Regular.ttf') format('truetype');
    }
    @font-face {
        font-family: 'NotoSansThai';
        font-style: bold;
        font-weight: bold;
        src: url('assets/fonts/NotoSansThai-Bold.ttf') format('truetype');
    }
";

// Include the template
$html = require __DIR__ . '/certificate_template.php';

// Get design choice
$design = isset($_GET['design']) ? $_GET['design'] : 'v1';

// Configure dimensions based on design
$isPortrait = ($design == 'v2');
$containerWidth = $isPortrait ? '794px' : '1123px';
$containerHeight = $isPortrait ? '1123px' : '794px';
$templateFile = __DIR__ . "/certificate_template" . ($design == 'v1' ? '' : "_$design") . ".php";

if (!file_exists($templateFile)) {
    $design = 'v1';
    $templateFile = __DIR__ . '/certificate_template.php'; 
    $containerWidth = '1123px';
    $containerHeight = '794px';
}

// Generate HTML using selected template
$html = require $templateFile;
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตัวอย่างเกียรติบัตร</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Noto Sans Thai -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- html2canvas for PNG download -->
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Noto Sans Thai', sans-serif;
            padding-bottom: 50px;
        }
        .preview-controls {
            background: white;
            padding: 1rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }
    </style>
</head>
<body>
    <!-- UI Controls -->
    <div class="preview-controls">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h4 class="mb-0 text-primary">
                <i class="bi bi-award-fill"></i> ตัวอย่างเกียรติบัตร
            </h4>
            
            <div class="d-flex align-items-center gap-3">
                <!-- Design Selector -->
                <div class="input-group">
                    <label class="input-group-text bg-light" for="designSelect"><i class="bi bi-palette"></i>&nbsp;รูปแบบ</label>
                    <select class="form-select" id="designSelect" onchange="changeDesign(this.value)" style="max-width: 200px;">
                        <option value="v1" <?php echo $design == 'v1' ? 'selected' : ''; ?>>แบบที่ 1 (มาตรฐาน)</option>
                        <option value="v2" <?php echo $design == 'v2' ? 'selected' : ''; ?>>แบบที่ 2 (แนวตั้ง Tech)</option>
                        <option value="v3" <?php echo $design == 'v3' ? 'selected' : ''; ?>>แบบที่ 3 (แนวนอน Modern)</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <a href="participant_list.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> กลับ
                    </a>
                    <button onclick="downloadPNG()" class="btn btn-info text-white">
                        <i class="bi bi-file-image"></i> PNG
                    </button>
                    <a href="generate_certificate.php?id=<?php echo $regId; ?>&design=<?php echo $design; ?>" class="btn btn-primary">
                        <i class="bi bi-file-pdf"></i> PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container text-center mb-3">
        <div class="alert alert-info d-inline-block">
            <i class="bi bi-info-circle"></i> สามารถเลือกรูปแบบเกียรติบัตรได้จากเมนูด้านบน
        </div>
    </div>

    <div class="container d-flex justify-content-center" style="overflow-x: auto; padding-bottom: 50px;">
        <!-- Container sized dynamically -->
        <div class="shadow-lg bg-white rounded overflow-hidden" style="width: <?php echo $containerWidth; ?>; height: <?php echo $containerHeight; ?>; flex-shrink: 0; transition: all 0.3s ease;">
            <iframe id="cert-frame" srcdoc="<?php echo htmlspecialchars($html); ?>" style="border:0; width:100%; height:100%;"></iframe>
        </div>
    </div>

    <script>
    function changeDesign(val) {
        // Reload page via JS to select new design
        const url = new URL(window.location.href);
        url.searchParams.set('design', val);
        window.location.href = url.toString();
    }
    
    function downloadPNG() {
        const frame = document.getElementById('cert-frame');
        const doc = frame.contentDocument || frame.contentWindow.document;
        const body = doc.body;

        if(!body) {
            alert('Certificate content is not ready yet.');
            return;
        }

        // Wait for fonts to be ready
        doc.fonts.ready.then(function() {
            html2canvas(body, {
                scale: 3, // High resolution
                useCORS: true,
                logging: false,
                letterRendering: 1, // Attempt to fix text spacing
                allowTaint: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'certificate_<?php echo $regId; ?>_' + '<?php echo $design; ?>' + '.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            }).catch(err => {
                console.error(err);
                alert('Failed to generate PNG.');
            });
        });
    }
    </script>

</body>
</html>
