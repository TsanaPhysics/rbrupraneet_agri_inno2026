<?php
// certificate_template.php
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
            overflow: hidden; /* Prevent spillover */
        }
        .border-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 20px solid #4A90E2;
            box-sizing: border-box;
            z-index: -1;
        }
        .inner-border {
            position: fixed;
            top: 25px;
            left: 25px;
            right: 25px;
            bottom: 25px;
            border: 2px solid #D4AF37; /* Gold border */
            z-index: -1;
        }
        .container {
            text-align: center;
            padding-top: 40px; /* Reduced from 60px */
            color: #333;
        }
        .logo-area {
            margin-bottom: 10px; /* Reduced from 20px */
        }
        .logo-text {
            font-size: 24px;
            color: #4A90E2;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .header-text {
            font-size: 48px;
            font-family: 'NotoSansThai', sans-serif;
            font-weight: bold;
            color: #D4AF37;
            margin-bottom: 5px; /* Reduced from 10px */
            line-height: 1;
        }
        .sub-header {
            font-size: 18px;
            margin-bottom: 20px; /* Reduced from 30px */
            color: #666;
        }
        .present-text {
            font-size: 18px;
            margin-bottom: 10px; /* Reduced from 20px */
            font-weight: 300;
        }
        .recipient-name {
            font-size: 36px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px; /* Reduced from 10px */
            border-bottom: 2px solid #eee;
            display: inline-block;
            padding-bottom: 5px; /* Reduced from 10px */
            min-width: 400px;
        }
        .school-name {
            font-size: 20px;
            color: #555;
            margin-bottom: 20px; /* Reduced from 30px */
            font-weight: 500;
        }
        .activity-text {
            font-size: 20px;
            margin-bottom: 5px; /* Reduced from 10px */
        }
        .activity-name {
            font-size: 28px;
            font-weight: 600;
            color: #4A90E2;
            margin-bottom: 30px; /* Reduced from 40px */
        }
        .footer-section {
            margin-top: 40px; /* Reduced from 60px */
            display: table;
            width: 100%;
            padding: 0 50px; /* Reduced side padding slightly */
        }
        .signature-block {
            display: table-cell;
            text-align: center;
            vertical-align: bottom;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin: 0 auto 10px auto;
        }
        .signatory-name {
            font-weight: 600;
            font-size: 16px;
        }
        .signatory-title {
            font-size: 14px;
            color: #777;
        }
        .date-block {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
        .bg-watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.05;
            font-size: 200px;
            z-index: -2;
            color: #4A90E2;
            font-weight: bold;
            white-space: nowrap;
        }
        
        /* Interactive button for web view (print) */
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class='border-pattern'></div>
    <div class='inner-border'></div>
    <div class='bg-watermark'>RBRU-PRANEET</div>

    <div class='container'>
        <div class='logo-area'>
            <div class='logo-text'>ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล รำไพพรรณี-ประณีตวิทยาคม</div>
            <div class='logo-text'>RBRU-Praneet Digital Agri-Innovation Center</div>
        </div>
    
        <div class='header-text'>Certificate of Participation</div>
        <div class='sub-header'> </div>
        <div class='present-text'>มอบเกียรติบัตรฉบับนี้เพื่อแสดงว่า</div>
        <div class='recipient-name'>" . htmlspecialchars($name) . "</div>
        <div class='school-name'>โรงเรียน" . htmlspecialchars($school) . "</div>
        <div class='activity-text'>ได้ผ่านการอบรมเชิงปฏิบัติการ</div>
        <div class='activity-name'>" . htmlspecialchars($activity) . "</div>
        <div class='footer-section'>
            <div class='signature-block'>
                 <br><br>
                <div class='signature-line'></div>
                <div class='signatory-name'>นายไชยวัฒน์ ปาเชนทร์</div>
                <div class='signatory-title'>ผู้อำนวยการศูนย์นวัตกรรมฯ</div>
            </div>
            <div class='signature-block'>
                 <br><br>
                <div class='signature-line'></div>
                <div class='signatory-name'>ผู้ช่วยศาสตราจารย์ ดร.ชีวะ  ทัศนา</div>
                <div class='signatory-title'>หัวหน้าโครงการ</div>
            </div>
        </div>
        
        <div class='date-block'>
            ให้ไว้ ณ วันที่ " . htmlspecialchars($date) . "
        </div>
    </div>
</body>
</html>";
