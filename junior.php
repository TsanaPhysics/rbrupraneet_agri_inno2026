<?php
session_start();
$_SESSION['level'] = 'junior';
require_once "languages/th.php";
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Junior High Resources — Agri-Innovation 2026</title>
    <link rel="stylesheet" href="css/main.css?v=2.0">
    <style>
        :root {
            --junior-blue: #0284c7;
            --junior-bg: #f0f9ff;
        }
        body { background: var(--junior-bg); }
        .hero-junior {
            background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
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
            box-shadow: 0 10px 25px rgba(2, 132, 199, 0.1);
            transition: transform 0.3s;
            border: 1px solid #e0f2fe;
        }
        .resource-card:hover { transform: translateY(-5px); }
        .btn-junior {
            display: inline-block;
            background: var(--junior-blue);
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
    <header class="hero-junior">
        <h1>แหล่งเรียนรู้ระดับมัธยมศึกษาตอนต้น (ม.ต้น)</h1>
        <p>Agri-Innovation 2026: Junior High Resource Center</p>
    </header>

    <div class="resource-grid">
        <div class="resource-card">
            <h2>📘 คู่มือการเรียนการสอน (PDF)</h2>
            <p>คู่มือฉบับย่อสำหรับ ม.ต้น เน้นพื้นฐาน Python, AI และ IoT</p>
            <a href="generate_junior_manual.php" target="_blank" class="btn-junior">Download PDF</a>
        </div>
        <div class="resource-card">
            <h2>📦 ชุดรวมไฟล์ทั้งหมด (ZIP)</h2>
            <p>รวมไฟล์ JSON ข้อมูลบทเรียน และคู่มือ Markdown ทั้งหมดสำหรับ ม.ต้น</p>
            <a href="junior_high_resources.zip" class="btn-junior">Download Bundle (.zip)</a>
        </div>
        <div class="resource-card">
            <h2>💻 เข้าสู่บทเรียน</h2>
            <p>เริ่มเรียนรู้ผ่านหน้าเว็บที่ปรับปรุงเนื้อหาสำหรับ ม.ต้น แล้ว</p>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                <a href="workshop-climate.php?level=junior" class="btn-junior" style="font-size: 0.8rem;">Climate</a>
                <a href="workshop-cnn.php?level=junior" class="btn-junior" style="font-size: 0.8rem;">AI-CNN</a>
                <a href="workshop-iot.php?level=junior" class="btn-junior" style="font-size: 0.8rem;">IoT</a>
            </div>
        </div>
    </div>

    <div style="text-align: center; padding-bottom: 50px;">
        <a href="index.php" style="color: #64748b; text-decoration: none;">← กลับสู่หน้าหลัก</a>
    </div>
</body>
</html>
