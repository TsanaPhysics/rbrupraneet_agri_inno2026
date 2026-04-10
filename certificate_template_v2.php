<?php
// certificate_template_v2.php (Portrait - Nature/Tech Theme)
// Expects: $fontCss, $name, $school, $activity, $date

return "
<!DOCTYPE html>
<html lang='th'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <style>
        $fontCss
        
        @page {
            size: A4 portrait;
            margin: 0;
        }
        body {
            font-family: 'NotoSansThai', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fcf8;
            width: 210mm;
            height: 297mm;
            overflow: hidden;
            position: relative;
            color: #2c3e50;
        }
        
        /* Decorative Shapes */
        .shape-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background: linear-gradient(135deg, #00b09b, #96c93d);
            clip-path: polygon(0 0, 100% 0, 100% 70%, 0 100%);
            z-index: 0;
        }
        .shape-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background: linear-gradient(135deg, #00b09b, #96c93d);
            clip-path: polygon(0 30%, 100% 0, 100% 100%, 0 100%);
            z-index: 0;
        }
        .shape-accent {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 5px solid rgba(255,255,255,0.3);
            z-index: 1;
        }
        
        /* Content Container */
        .content-wrapper {
            position: relative;
            z-index: 10;
            text-align: center;
            padding-top: 100px;
            width: 100%;
        }
        
        .logo-text {
            font-size: 18px;
            color: #ffffff;
            font-weight: 500;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
            margin-bottom: 5px;
            position: absolute;
            top: 30px;
            left: 0;
            width: 100%;
            text-align: center;
        }
        
        .title-badge {
            display: inline-block;
            background-color: #fff;
            padding: 10px 40px;
            border-radius: 50px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
        }
        .header-text {
            font-size: 42px; /* Slightly smaller for portrait */
            font-weight: 800;
            color: #00875c;
            margin: 0;
            line-height: 1.2;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .sub-header {
            font-size: 18px;
            color: #666;
            margin-top: 5px;
        }
        
        .present-text {
            font-size: 18px;
            margin-top: 40px;
            margin-bottom: 15px;
            font-weight: 300;
        }
        
        .recipient-name {
            font-size: 32px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
            border-bottom: 3px solid #96c93d;
            display: inline-block;
            padding-bottom: 5px;
            min-width: 300px;
        }
        
        .school-name {
            font-size: 20px;
            color: #666;
            margin-top: 10px;
            margin-bottom: 40px;
            font-weight: 500;
        }
        
        .activity-section {
            background-color: #f0fdf4;
            display: inline-block;
            padding: 20px 40px;
            border-radius: 15px;
            border: 1px dashed #96c93d;
            margin-bottom: 40px;
            width: 70%;
        }
        
        .activity-text {
            font-size: 18px;
            color: #555;
            margin-bottom: 5px;
        }
        
        .activity-name {
            font-size: 26px;
            font-weight: 700;
            color: #00b09b;
        }
        
        .date-text {
            font-size: 16px;
            color: #777;
            margin-top: 10px;
        }
        
        .footer-section {
            margin-top: 60px;
            display: table;
            width: 100%;
            padding: 0 40px;
        }
        
        .signature-block {
            display: table-cell;
            width: 50%;
            vertical-align: bottom;
            text-align: center;
        }
        
        .signature-line {
            width: 150px;
            height: 1px;
            background-color: #333;
            margin: 0 auto 10px auto;
        }
        
        .signatory-name {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        
        .signatory-title {
            font-size: 14px;
            color: #666;
            font-weight: 300;
        }
        
        .certificate-id {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 14px;
            color: #fff;
            z-index: 2;
        }

    </style>
</head>
<body>
    <!-- Background Shapes -->
    <div class='shape-top'></div>
    <div class='shape-bottom'></div>
    <div class='shape-accent'></div>

    <div class='logo-text'>
        ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล รำไพพรรณี-ประณีตวิทยาคม<br>
        RBRU-Praneet Digital Agri-Innovation Center
    </div>

    <div class='content-wrapper'>
        <div class='title-badge'>
            <div class='header-text'>เกียรติบัตรฉบับนี้ให้ไว้เพื่อแสดงว่า</div>
            <div class='sub-header'>Certificate of Participation</div>
        </div>

        <div class='recipient-name'>" . htmlspecialchars($name) . "</div>
        <div class='school-name'>โรงเรียน" . htmlspecialchars($school) . "</div>

        <div class='activity-section'>
            <div class='activity-text'>ได้เข้าร่วมกิจกรรมอบรมเชิงปฏิบัติการ</div>
            <div class='activity-name'>" . htmlspecialchars($activity) . "</div>
            <div class='date-text'>ให้ไว้ ณ วันที่ " . $date . "</div>
        </div>

        <div class='footer-section'>
            <div class='signature-block'>
                 <br><br>
                <div class='signature-line'></div>
                <div class='signatory-name'>นายไชยวัฒน์ ปาเชนทร์</div>
                <div class='signatory-title'>ผู้อำนวยการศูนย์นวัตกรรมฯ</div>
            </div>
            <div class='signature-block'>
                 <!-- <img src='assets/images/signature_temp.png' style='height: 40px;'> -->
                 <br><br>
                <div class='signature-line'></div>
                <div class='signatory-name'>ผู้ช่วยศาสตราจารย์ ดร.ชีวะ  ทัศนา</div>
                <div class='signatory-title'>หัวหน้าโครงการ</div>
            </div>
        </div>
    </div>
    
    <div class='certificate-id'>ID: " . uniqid() . "</div>
</body>
</html>
";
