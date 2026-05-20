<?php
session_start();
$sessions_json = file_get_contents('data/iot_sessions.json');
$iot_sessions = json_decode($sessions_json, true) ?? [];
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ePocketbook: AI-IoT Prototyping 2026 | Technical Documentary</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #f97316;
            --accent: #fbbf24;
            --dark: #0f172a;
            --slate: #334155;
            --text: #334155;
            --paper: #ffffff;
            --gold: #d97706;
            --orange-soft: rgba(249, 115, 22, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: var(--text);
            line-height: 1.6;
            scroll-behavior: smooth;
            text-align: justify;
            text-justify: inter-character;
        }

        p {
            text-indent: 2em;
            margin-bottom: 1rem;
        }

        p.dropcap {
            text-indent: 0;
        }

        /* Magazine Layout Container */
        .pocketbook {
            max-width: 1000px;
            margin: 2rem auto;
            background: var(--paper);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Cover Page */
        .cover {
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.9)), url('assets/images/activities/iot_smart_sensor.png');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 8rem 4rem;
            color: white;
            position: relative;
        }

        .cover-vol {
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 5px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            color: var(--accent);
        }

        .cover-title {
            font-family: 'Playfair Display', serif;
            font-size: 6rem;
            line-height: 0.9;
            font-weight: 900;
            margin-bottom: 2rem;
            text-transform: uppercase;
        }

        .cover-subtitle {
            font-size: 1.5rem;
            max-width: 600px;
            font-weight: 300;
            opacity: 0.9;
            border-left: 4px solid var(--primary);
            padding-left: 1.5rem;
            margin-bottom: 3rem;
        }

        .cover-authors {
            font-size: 1.1rem;
            font-weight: 500;
            letter-spacing: 2px;
            color: var(--accent);
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .cover-authors span::before {
            content: '|';
            margin-right: 2rem;
            color: var(--primary);
            font-weight: 900;
        }

        .cover-authors span:first-child::before {
            display: none;
        }

        .cover-footer {
            margin-top: 4rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 2rem;
            max-width: 600px;
        }

        .footer-main {
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.2rem;
            letter-spacing: 1px;
        }

        .footer-sub {
            font-size: 0.9rem;
            font-weight: 400;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
        }

        .footer-slogan {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 1.1rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        /* Interior Spacing */
        .page {
            padding: 5rem 4rem;
            position: relative;
            min-height: 100vh;
            border-bottom: 1px solid #f1f5f9;
            background: #fdfdfd;
        }

        /* Thai Headers & Footers */
        .page::before {
            content: "ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม";
            position: absolute;
            top: 2rem;
            right: 4rem;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .page::after {
            content: "คู่มือปฏิบัติการเทคโนโลยีเกษตรดิจิทัล 2026";
            position: absolute;
            bottom: 2rem;
            left: 5.5rem;
            font-size: 0.7rem;
            font-weight: 400;
            color: #cbd5e1;
        }

        .section-header {
            margin-bottom: 4rem;
            border-bottom: 2px solid #eee;
            padding-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .page-num {
            font-weight: 800;
            color: #ddd;
            font-size: 2rem;
        }

        h2.mag-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.1rem;
            line-height: 1.1;
            margin-top: 3rem;
            margin-bottom: 2rem;
            color: var(--dark);
        }

        .thai-dropcap {
            float: left;
            font-size: 5rem;
            line-height: 0.8;
            padding-right: 12px;
            padding-top: 4px;
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            color: var(--primary);
        }

        .magazine-columns {
            column-count: 2;
            column-gap: 3rem;
            text-align: justify;
        }

        .pull-quote {
            padding: 2.5rem;
            margin: 3em 0;
            background: var(--orange-soft);
            border-left: 8px solid var(--primary);
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-weight: 600;
            font-size: 1.5rem;
            color: var(--dark);
            text-align: center;
            width: 100%;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            break-inside: avoid;
        }

        /* Tech Panels */
        .tech-insight {
            background: var(--dark);
            color: white;
            padding: 2.5rem;
            border-radius: 20px;
            margin: 3rem 0;
            position: relative;
            overflow: hidden;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            break-inside: avoid;
        }

        .tech-insight h4 {
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .teacher-corner {
            background: rgba(245, 158, 11, 0.05);
            border: 2px dashed var(--gold);
            padding: 2rem;
            border-radius: 15px;
            margin: 2rem 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            break-inside: avoid;
        }

        .teacher-corner h5 {
            color: var(--gold);
            text-transform: uppercase;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        code {
            font-family: 'Fira Code', monospace;
            background: var(--orange-soft);
            padding: 2px 6px;
            border-radius: 4px;
            color: var(--gold);
            font-weight: 600;
        }

        .code-block {
            background: #1e293b;
            padding: 2rem;
            border-radius: 12px;
            font-size: 0.85rem;
            overflow-x: auto;
            margin: 1.5rem 0;
            border-left: 5px solid var(--accent);
            color: #e2e8f0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .topic-header-box {
            background: var(--orange-soft);
            border: 2px solid var(--primary);
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .topic-header-box h2 {
            margin-top: 0;
            color: var(--gold);
        }

        .lab-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
            font-size: 0.9rem;
            break-inside: avoid;
        }

        .lab-table th {
            background: var(--primary);
            color: white;
            padding: 12px;
            text-align: left;
            -webkit-print-color-adjust: exact;
        }

        .lab-table td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        .exercise-box {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-left: 10px solid var(--gold);
            padding: 2rem;
            border-radius: 12px;
            margin: 3rem 0;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.02);
            break-inside: avoid;
        }

        .solution-toggle {
            display: block;
            margin-top: 1.5rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 8px;
            font-size: 0.8rem;
            color: #64748b;
            cursor: pointer;
            border: 1px dashed #cbd5e1;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 3rem 0;
        }

        .stat-card {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            break-inside: avoid;
        }

        .stat-card .val {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--dark);
        }

        .mag-img {
            width: 100%;
            border-radius: 15px;
            margin: 2rem 0;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .caption {
            font-size: 0.8rem;
            color: #64748b;
            text-align: center;
            font-style: italic;
            margin-top: -1.5rem;
            margin-bottom: 2rem;
        }

        .cloud-lab-hero {
            height: 400px;
            background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('assets/images/cloud_lab.png');
            background-size: cover;
            background-position: center;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 3rem;
            margin-bottom: 3rem;
        }

        @media print {
            @page {
                size: A4;
                margin: 0;
            }

            body {
                background: white !important;
                color: black !important;
                font-size: 11pt !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .pocketbook {
                margin: 0;
                box-shadow: none;
                max-width: none;
                width: 100%;
            }

            .page {
                page-break-after: always;
                padding: 1.5cm 2cm 1.5cm 2.5cm !important;
                min-height: auto;
                background: white !important;
                border: none !important;
            }

            h2.mag-title {
                font-size: 1.6rem !important;
                margin-top: 1rem !important;
                margin-bottom: 1rem !important;
                color: black !important;
            }

            .topic-header-box {
                padding: 1.5rem !important;
                margin-bottom: 2rem !important;
            }

            .topic-header-box h2 {
                font-size: 1.8rem !important;
            }

            .code-block {
                font-size: 10pt !important;
                padding: 1rem !important;
                border-left: 3px solid var(--accent) !important;
            }

            .magazine-columns {
                column-gap: 2rem !important;
            }

            p {
                margin-bottom: 0.8rem !important;
                line-height: 1.5 !important;
            }

            .thai-dropcap {
                font-size: 3.5rem !important;
                padding-right: 8px !important;
            }

            /* Hide non-print elements */
            .btn-print {
                display: none !important;
            }

            /* Avoid page breaks inside important info blocks */
            .tech-insight,
            .code-block,
            .topic-header-box {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }

        .btn-print {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--dark);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>

<body>

    <a href="javascript:window.print()" class="btn-print no-print">
        <span>🖨️</span> Export to PDF Manual
    </a>

    <div class="pocketbook">

        <!-- PAGE 00: COVER PAGE -->
        <section class="cover">
            <div class="cover-vol">Vol. 03 | No. 2026 | AIDA xAI Center</div>
            <h1 class="cover-title" style="font-size: 5rem;">AI-IoT Edge<br>Protocols</h1>
            <div class="cover-subtitle">
                A Journey into the Future of Tech-Driven Ecological Innovation & Digital Agriculture in Chanthaburi.
            </div>
            <div class="cover-authors">
                <span>ผศ.ดร.ชีวะ ทัศนา</span>
                <span>ผศ.ดร.จิรภัทร จันทมาลี</span>
            </div>
            <div class="cover-footer">
                <div class="footer-main">Center for AI Innovation & Development in Agriculture and Environment</div>
                <div class="footer-sub">AIDA xAI Center 2026 : SciRBRU AgriEnvi DeepTech Teams</div>
                <div class="footer-slogan">"Where Intelligence Meets the Soil"</div>
                <div class="footer-faculty">Faculty of Science and Technology, Rajabhat Buriram University</div>
            </div>
        </section>

        <!-- PAGE 01: PROLOGUE -->
        <section class="page">
            <div class="section-header">
                <span>The Prologue</span>
                <span class="page-num">01</span>
            </div>

            <h2 class="mag-title">เปิดโลกทัศน์สู่ระบบประสาทสัมผัสแห่งฟาร์มอัจฉริยะ</h2>

            <div class="magazine-columns">
                <p>
                    <span
                        class="thai-dropcap">ใ</span>นยุคที่การเกษตรดั้งเดิมกำลังโผบินสู่คอนเซ็ปต์การเพาะปลูกแบบแม่นยำสูง
                    (Precision Farming) เทคโนโลยี Internet of Things (IoT) คือ "ระบบประสาทส่วนกลาง"
                    ที่ทำหน้าที่เชื่อมประสานโครงสร้างพื้นฐานทั้งหมด
                    ปลุกเสกเครื่องสูบน้ำและเซ็นเซอร์โง่เขลาตามแปลงดินให้ตื่นมาพูดคุยและรายงานผลแบบไร้สายตลอด 24 ชั่วโมง
                </p>
                <p>
                    คู่มือฉบับนี้จะพานักเรียนก้าวข้ามขีดจำกัดจากหน้าจอคอมพิวเตอร์
                    ลงไปสัมผัสโลกกายภาพโดยตรงผ่านการเขียนโค้ดภาษา MicroPython สั่งการลงไมโครคอนโทรลเลอร์ ESP32
                    คุณจะได้เรียนรู้จังหวะการเปิด/ปิดรีเลย์ปั๊มน้ำ, วิธีแอบฟังเซ็นเซอร์ความชื้นในดิน และโยนข้อมูลสดๆ
                    ระดับเสี้ยววินาทีขึ้นโปรโตคอล MQTT อย่างเชี่ยวชาญ!
                </p>
            </div>

            <div class="pull-quote">
                "The Internet of Things is not just about connected devices; it is about extending human awareness into
                the physical world through code."
            </div>

            <div class="stat-grid">
                <div class="stat-card">
                    <div class="val">12</div>
                    <div class="label">Total Study Hours</div>
                </div>
                <div class="stat-card">
                    <div class="val">4</div>
                    <div class="label">Core Sessions</div>
                </div>
                <div class="stat-card">
                    <div class="val">1</div>
                    <div class="label">Capstone Project</div>
                </div>
            </div>
        </section>

        <!-- PAGE 02: CLOUD LAB INFOGRAPHIC -->
        <section class="page">
            <div class="section-header">
                <span>Computing Environment</span>
                <span class="page-num">02</span>
            </div>

            <h2 class="mag-title">Edge Lab: ห้องปฏิบัติการไร้สายบนฝ่ามือ</h2>

            <div class="cloud-lab-hero"
                style="background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('assets/images/activities/iot_orchestration.png');">
                <div>
                    <h3 style="font-size: 2.2rem; font-weight: 900; margin-bottom: 1rem; color: #60a5fa;">MicroPython &
                        ESP32</h3>
                    <p style="max-width: 550px; font-weight: 300;">เปลี่ยนชิปขนาดจิ๋วราคาประหยัด
                        ให้กลายเป็นสมองกลส่วนหน้าขนาดย่อมที่ตัดสินใจรดน้ำต้นไม้ได้เองอย่างชาญฉลาด</p>
                </div>
            </div>

            <div class="magazine-columns">
                <p>
                    ในขณะที่วิชาปัญญาประดิษฐ์อื่นๆ โฟกัสไปที่เซิร์ฟเวอร์ยักษ์ใหญ่กลาง Cloud แต่ในศาสตร์ของ IoT
                    เราโฟกัสไปที่ฮาร์ดแวร์ขนาดจิ๋ว (Edge Computing) เราจะใช้ซอฟต์แวร์ <strong>Thonny IDE</strong>
                    สานต่อความรู้ MicroPython เพื่อฝังซอร์สโค้ดเหล่านั้นลงใส่บอร์ดพัดคนา
                </p>
                <p>
                    <strong>วิธีการเริ่มต้นปลุกชีวิตชิป:</strong><br>
                    1. เชื่อมต่อบอร์ด ESP32 เข้ากับคอมพิวเตอร์ผ่านพอร์ต USB-C<br>
                    2. ติดตั้งคอมไพเลอร์ Thonny และคอนฟิกค่าเป็น MicroPython (ESP32)<br>
                    3. ลากเส้นสายฮาร์ดแวร์เพื่อรับคำสั่งผ่านการเขียนโค้ดแบบ Real-time!<br><br>
                    <em>ข้อควรระวัง: แรงดันไฟของ ESP32 รับได้ที่สููงสุด 3.3V ห้ามต่อไฟฟ้า 5V โดยตรงเพื่อความปลอดภัย</em>
                </p>
            </div>

            <div class="tech-insight">
                <h4>🛠️ Prerequisites Checklist</h4>
                <ul style="padding-left: 1.5rem; font-size: 0.9rem;">
                    <li>Thonny IDE (ติดตั้งในเครื่องคอมพิวเตอร์ระดับท้องถิ่น)</li>
                    <li>ESP32 WROOM-32 Board & USB-Data Cable</li>
                    <li>Sensors: โมดูลวัดความชื้นในดิน / DHT22 / จอ OLED / รีเลย์</li>
                    <li>MQTT Networking & Wi-Fi Password</li>
                </ul>
            </div>
        </section>

        <!-- DYNAMIC SESSIONS LOOP (Expanded 12-Sessions) -->
        <?php foreach ($iot_sessions as $index => $s): ?>
            <section class="page" style="page-break-after: always; display: block; margin-bottom: 2rem;">
                <div class="topic-header-box">
                    <span>Session <?= $index + 1 ?>: RBRU Module</span>
                    <span class="page-num"><?= str_pad($index + 3, 2, '0', STR_PAD_LEFT) ?></span>
                    <h2 class="mag-title" style="margin-top: 1rem; font-size: 2.2rem; line-height: 1.2;">
                        <?= htmlspecialchars($s['title']) ?>
                    </h2>
                    <p style="text-indent: 0; color: var(--gold); font-weight: 500; font-size: 1.1rem; margin-top: 1rem;">
                        <?= htmlspecialchars($s['desc']) ?>
                    </p>
                </div>

                <?php if (isset($s['examples']) && count($s['examples']) > 0): ?>
                    <div class="magazine-columns" style="margin-top: 2rem;">
                        <p style="font-size: 1rem;">
                            <span class="thai-dropcap">เ</span>จาะลึกทักษะหลักด้วย <?= count($s['examples']) ?>
                            ตัวอย่างการเขียนกระบวนการทางคณิตศาสตร์และตรรกะแบบขั้นบันได ให้นักเรียนได้ต่อยอดไปสู่ระบบอัจฉริยะแบบ
                            Step-by-step
                        </p>
                    </div>

                    <?php foreach ($s['examples'] as $ex_idx => $ex): ?>
                        <h4 style="color: var(--gold); margin-top: 1.5rem;">🔹 <?= htmlspecialchars($ex['title']) ?></h4>
                        <div class="tech-insight" style="padding: 1.5rem; margin-top: 1rem; break-inside: avoid;">
                            <div class="code-block" style="background: rgba(0,0,0,0.5); padding: 1.25rem;">
                                <?= nl2br(str_replace('  ', '&nbsp;&nbsp;', htmlspecialchars($ex['code']))) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div
                    style="margin-top: 2rem; border-top: 2px dashed var(--gold); padding-top: 1.5rem; text-align: center; break-inside: avoid;">
                    <h4 style="color: var(--primary); margin-bottom: 0;">▼ The Simulator Perspective ▼</h4>
                    <p style="font-size: 0.85rem; color: #666; text-indent: 0; margin-bottom: 0.5rem;">
                        <?= htmlspecialchars($s['xr_caption']) ?>
                    </p>
                    <img src="<?= $s['xr_image'] ?>" class="mag-img" style="margin-top: 0.5rem; max-width: 500px;"
                        alt="XR Simulation">
                </div>
            </section>
        <?php endforeach; ?>

        <div style="margin-top: 5rem; text-align: center; padding: 4rem; border-top: 1px solid var(--orange-soft);">
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 0.5rem;">
                ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม</h3>
            <p
                style="font-size: 1.1rem; color: var(--gold); font-weight: 700; letter-spacing: 2px; margin-bottom: 0.5rem;">
                Center for AI Innovation & Development in Agriculture and Environment</p>
            <p
                style="font-size: 2rem; font-weight: 900; color: var(--primary); letter-spacing: 10px; margin-bottom: 2rem;">
                AIDA xAI Center</p>
            <p style="margin-top: 2rem; font-size: 0.8rem; color: #cbd5e1;">© โครงการยุทธศาสตร์เพื่อการพัฒนาท้องถิ่น
                มหาวิทยาลัยราชภัฏรำไพพรรณี</p>
        </div>
        </section>

    </div>

    <script>
        const originalTitle = document.title;
        window.onbeforeprint = () => document.title = "";
        window.onafterprint = () => document.title = originalTitle;
    </script>
</body>

</html>