<?php
session_start();
$_SESSION['level'] = 'senior';
require_once "languages/th.php";
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior High Resources — Agri-Innovation 2026</title>
    <link rel="stylesheet" href="css/main.css?v=2.0">
    <style>
        :root {
            --senior-orange: #f97316;
            --senior-bg: #fff7ed;
        }
        body { background: var(--senior-bg); }
        .hero-senior {
            background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
            color: white;
            padding: 100px 20px;
            text-align: center;
            border-radius: 0 0 50px 50px;
        }
        .resource-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 50px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .resource-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.1);
            transition: transform 0.3s;
            border: 1px solid #ffedd5;
        }
        .resource-card:hover { transform: translateY(-5px); }
        .btn-senior {
            display: inline-block;
            background: var(--senior-orange);
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <header class="hero-senior">
        <h1>แหล่งเรียนรู้ระดับมัธยมศึกษาตอนปลาย (ม.ปลาย)</h1>
        <p>Agri-Innovation 2026: Senior High Resource Center</p>
    </header>

    <div class="resource-grid">
        <div class="resource-card">
            <h2>📘 คู่มือการเรียนการสอน (PDF)</h2>
            <p>คู่มือฉบับสมบูรณ์สำหรับ ม.ปลาย เน้นวิศวกรรมข้อมูล, CNN และระบบ IoT ขั้นสูง</p>
            <a href="generate_senior_manual.php" target="_blank" class="btn-senior">Download PDF</a>
        </div>
        <div class="resource-card">
            <h2>📦 ชุดรวมไฟล์ทั้งหมด (ZIP)</h2>
            <p>รวมไฟล์ JSON ข้อมูลบทเรียน และคู่มือ Markdown ทั้งหมดสำหรับ ม.ปลาย</p>
            <a href="senior_high_resources.zip" class="btn-senior">Download Bundle (.zip)</a>
        </div>
        <div class="resource-card">
            <h2>💻 เข้าสู่บทเรียน</h2>
            <p>เริ่มเรียนรู้ผ่านหน้าเว็บที่ปรับปรุงเนื้อหาสำหรับ ม.ปลาย แล้ว</p>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                <a href="workshop-climate.php?level=senior" class="btn-senior" style="font-size: 0.8rem;">Climate</a>
                <a href="workshop-cnn.php?level=senior" class="btn-senior" style="font-size: 0.8rem;">AI-CNN</a>
                <a href="workshop-iot.php?level=senior" class="btn-senior" style="font-size: 0.8rem;">IoT</a>
            </div>
        </div>
    </div>

    <div style="text-align: center; padding-bottom: 50px;">
        <a href="index.php" style="color: #64748b; text-decoration: none;">← กลับสู่หน้าหลัก</a>
    </div>
</body>
</html>
