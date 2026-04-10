<?php
// certificate_template_v3.php (Landscape - Modern Digital Theme)
// Expects: $fontCss, $name, $school, $activity, $date

return "
<!DOCTYPE html>
<html lang='th'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <style>
        $fontCss
        
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            font-family: 'NotoSansThai', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            width: 297mm;
            height: 210mm;
            overflow: hidden;
            color: #333;
            /* Modern Grid Background */
            background-image: 
                linear-gradient(rgba(74, 144, 226, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(74, 144, 226, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
            border: 15px solid #fff; /* White frame */
            outline: 2px solid #4A90E2; /* Thin blue outline */
            box-sizing: border-box;
        }
        
        /* Modern Side Bar */
        .side-bar {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 80px;
            background: linear-gradient(180deg, #4A90E2 0%, #9013fe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .side-text {
            transform: rotate(-90deg);
            color: white;
            font-size: 24px;
            letter-spacing: 5px;
            white-space: nowrap;
            font-weight: 300;
            opacity: 0.9;
        }

        .main-content {
            margin-left: 100px; /* Offset for sidebar */
            padding: 40px 60px 40px 20px;
            text-align: left; /* Distinctive left alignment */
        }

        .header-en {
            font-size: 60px;
            font-family: 'NotoSansThai', sans-serif;
            font-weight: 900;
            color: #eef2f7;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            top: 20px;
            right: 40px;
            z-index: 0;
            pointer-events: none;
        }
        
        .header-th {
            font-size: 56px;
            font-weight: 800;
            background: linear-gradient(45deg, #4A90E2, #9013fe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        
        .cert-verify {
            font-size: 16px;
            color: #999;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .recipient-block {
            margin-bottom: 30px;
            border-left: 5px solid #4A90E2;
            padding-left: 30px;
        }
        
        .recipient-name {
            font-size: 40px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .school-name {
            font-size: 24px;
            color: #666;
        }
        
        .activity-block {
            background: #f8f9fa;
            padding: 20px 30px;
            border-radius: 10px;
            margin-bottom: 40px;
            border-left: 5px solid #9013fe;
        }
        
        .activity-text {
            font-size: 20px;
            margin-bottom: 5px;
            color: #555;
        }
        .activity-name {
            font-size: 32px;
            font-weight: 600;
            color: #9013fe;
        }
        
        .date-text {
            font-size: 18px;
            color: #777;
            margin-top: 5px;
        }

        .footer-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 20px;
        }
        
        .signature-item {
            text-align: center;
        }
        .sig-line {
            width: 200px;
            height: 1px;
            background: #ddd;
            margin-bottom: 15px;
        }
        .sig-name {
            font-size: 18px;
            font-weight: 600;
        }
        .sig-role {
            font-size: 14px;
            color: #888;
        }
        
    </style>
</head>
<body>
    <div class='side-bar'>
        <div class='side-text'>RBRU AGRI-INNOVATION</div>
    </div>
    
    <div class='header-en'>CERTIFICATE</div>

    <div class='main-content'>
        <div class='cert-verify'>ใบรับรองการเข้าร่วมกิจกรรม | CERTIFICATE OF COMPLETION</div>
        <div class='header-th'>เกียรติบัตรฉบับนี้ให้ไว้เพื่อแสดงว่า</div>
        <div class='recipient-block'>
            <div class='recipient-name'>" . htmlspecialchars($name) . "</div>
            <div class='school-name'>โรงเรียน" . htmlspecialchars($school) . "</div>
        </div>
    
        <div class='activity-block'>
            <div class='activity-text'>ผ่านการอบรมเชิงปฏิบัติการหลักสูตร</div>
            <div class='activity-name'>" . htmlspecialchars($activity) . "</div>
            <div class='date-text'>ให้ไว้ ณ วันที่ " . $date . "</div>
        </div>
        
        <div class='footer-row'>
            <div class='signature-item'>
                <div class='sig-line'></div>
                <div class='sig-name'>นายไชยวัฒน์ ปาเชนทร์</div>
                <div class='sig-role'>ผู้อำนวยการศูนย์นวัตกรรมฯ</div>
            </div>
            
            <div class='signature-item'>
                <div class='sig-line'></div>
                <div class='sig-name'>ผู้ช่วยศาสตราจารย์ ดร.ชีวะ ทัศนา</div>
                <div class='sig-role'>หัวหน้าโครงการ</div>
            </div>
        </div>
    </div>
</body>
</html>
";
