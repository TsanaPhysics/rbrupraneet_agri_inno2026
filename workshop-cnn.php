<?php
session_start();
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'th';
require_once "languages/{$lang_code}.php";
require_once "db_connect.php";

// GitHub Configuration
$github_user = "TsanaPhysics";
$github_repo = "rbrupraneet_agri_inno2026";
$github_base = "https://github.com/$github_user/$github_repo/blob/main/notebooks/cnn/";
$colab_base = "https://colab.research.google.com/github/$github_user/$github_repo/blob/main/notebooks/cnn/";
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deep Dive Lab: CNN | AIDA xAI Center</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/sections.css">
    <!-- Prism.js for Code Highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />

    <style>
        :root {
            --code-bg: #0f172a;
            --workshop-accent: #10b981;
            --workshop-amber: #34d399;
            --workshop-gold: #059669;
            --workshop-soft: rgba(16, 185, 129, 0.05);
            --radius-md: 12px;
            --radius-lg: 20px;
            --radius-2xl: 32px;
        }

        .workshop-hero {
            background: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.9)), url('assets/images/cnn_hero_green.png');
            background-size: cover;
            background-position: center;
            height: 480px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-top: 80px;
        }

        .session-card {
            background: white;
            border-radius: var(--radius-2xl);
            padding: 2.5rem;
            margin-bottom: 3rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .session-tag {
            background: var(--workshop-accent);
            color: white;
            padding: 4px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .code-container {
            position: relative;
            margin: 1.5rem 0;
            border-radius: var(--radius-lg);
            overflow: hidden;
            background: var(--code-bg);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .code-header {
            background: #1e293b;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #eee;
            font-size: 0.8rem;
            border-bottom: 1px solid #334155;
        }

        .code-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .code-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ccc;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.75rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .code-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-color: var(--workshop-accent);
        }

        pre[class*="language-"] {
            margin: 0 !important;
            padding: 1.5rem !important;
            font-family: 'Fira Code', monospace !important;
            font-size: 0.9rem !important;
        }

        .interactive-guide {
            display: grid;
            grid-template-columns: 100px 1fr;
            gap: 3rem;
            margin-top: 3rem;
        }

        .guide-nav {
            position: sticky;
            top: 120px;
            height: fit-content;
            max-height: calc(100vh - 160px);
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            padding-right: 15px;
            padding-left: 5px;
            padding-top: 5px;
            padding-bottom: 20px;
        }

        .guide-nav::-webkit-scrollbar {
            width: 5px;
        }

        .guide-nav::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .guide-nav::-webkit-scrollbar-thumb {
            background: var(--workshop-accent);
            border-radius: 10px;
        }


        .nav-item {
            padding: 10px;
            border-radius: var(--radius-lg);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: rgba(255, 255, 255, 0.5);
            border: 2px solid transparent;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 90px;
            width: 90px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .nav-item.active {
            background: var(--workshop-soft);
            border-color: var(--workshop-accent);
            transform: scale(1.1) translateY(-5px);
            box-shadow: 0 15px 25px rgba(16, 185, 129, 0.2);
        }

        .nav-icon {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 5px;
        }

        .nav-item span {
            font-size: 0.65rem;
            font-weight: 800;
            color: var(--slate);
            text-transform: uppercase;
        }

        .nav-item.active span {
            color: var(--workshop-accent);
        }

        /* NEW: Reveal Solution Styles */
        .reveal-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 1.5rem;
            position: relative;
        }

        .solution-content {
            display: none;
            color: var(--workshop-gold);
            font-size: 0.9rem;
            margin-top: 1rem;
            font-weight: 500;
        }

        .solution-content.show {
            display: block;
        }

        .btn-reveal {
            background: var(--workshop-accent);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-reveal:hover {
            background: var(--workshop-gold);
        }

        /* NEW: Lab Tables */
        .lab-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            font-size: 0.85rem;
        }

        .lab-table th {
            background: var(--workshop-soft);
            color: var(--workshop-gold);
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid var(--workshop-accent);
        }

        .lab-table td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        .btn-hologram {
            position: relative;
            padding: 14px 35px;
            font-weight: 800;
            font-size: 0.95rem;
            color: #fff !important;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            border: 2px solid rgba(16, 185, 129, 0.5);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.3), inset 0 0 15px rgba(16, 185, 129, 0.3);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-hologram:hover {
            transform: translateY(-5px) scale(1.05);
            border-color: var(--workshop-amber);
            box-shadow: 0 0 30px rgba(235, 120, 0, 0.6), inset 0 0 20px rgba(235, 120, 0, 0.4);
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.8);
        }

        .theory-panel {
            background: var(--workshop-soft);
            border-left: 4px solid var(--workshop-accent);
            padding: 1.5rem;
            margin: 2rem 0;
            border-radius: var(--radius-md);
        }

        .mag-img {
            width: 100%;
            border-radius: 15px;
            margin: 2rem 0;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        .xr-simulator-box {
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(16, 185, 129, 0.4);
            border-radius: var(--radius-lg);
            padding: 2rem;
            margin-top: 2.5rem;
            position: relative;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), inset 0 0 20px rgba(16, 185, 129, 0.05);
            text-align: center;
        }

        .xr-simulator-box::before {
            content: '3D XR SIMULATOR';
            position: absolute;
            top: -12px;
            left: 20px;
            font-family: 'Fira Code', monospace;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--workshop-gold);
            letter-spacing: 2px;
            background: #1e293b;
            border: 1px solid rgba(16, 185, 129, 0.4);
            padding: 4px 15px;
            border-radius: 20px;
        }

        .xr-simulator-box img {
            width: 100%;
            max-width: 600px;
            border-radius: 12px;
            margin-top: 1rem;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body>
    <?php include 'components/navigation.php'; ?>

    <main>
        <!-- Workshop Hero -->
        <section class="workshop-hero">
            <div class="container">
                <h1
                    style="font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 900; margin-bottom: 1rem;">
                    Deep Dive Lab: CNN</h1>
                <p style="font-size: 1.5rem; font-weight: 300; opacity: 0.9; margin-bottom: 2.5rem;">
                    ปัญญาประดิษฐ์จำแนกโรคพืชด้วย Deep Learning
                </p>
                <div
                    style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; max-width: 900px; margin: 0 auto;">
                    <a href="manual-cnn-pocketbook.php" target="_blank" class="btn-hologram">
                        <span>📖</span> คู่มือพิมพ์ฉบับสมบูรณ์
                    </a>
                    <a href="scripts/cnn_starter.py" class="btn-hologram" style="border-color: var(--workshop-gold);">
                        <span>🔰</span> Starter Script
                    </a>
                    <a href="scripts/rbru_cnn_master.py" target="_blank" class="btn-hologram"
                        style="border-color: #ef4444; background: rgba(239, 68, 68, 0.1);">
                        <span>🔥</span> Master Code (รวมดึง API & DSS)
                    </a>
                    <a href="data/leaf_disease_dataset.zip" class="btn-hologram"
                        style="border-color: var(--workshop-amber);">
                        <span>📊</span> DATASET (.CSV)
                    </a>
                </div>
            </div>
        </section>

        <?php
        $sessions_json = file_get_contents('data/cnn_sessions.json');
        $cnn_sessions = json_decode($sessions_json, true) ?? [];
        ?>
        <section class="container" style="padding: 4rem 1rem;">
            <div class="interactive-guide">
                <!-- Side Nav with 3D Icons -->
                <aside class="guide-nav">
                    <?php foreach ($cnn_sessions as $index => $s): ?>
                        <div class="nav-item <?= $index === 0 ? 'active' : '' ?>"
                            onclick="scrollToSession('<?= $s['id'] ?>')" title="<?= htmlspecialchars($s['title']) ?>">
                            <img src="<?= $s['xr_image'] ?>" class="nav-icon" alt="<?= $s['id'] ?>">
                            <span>S.<?= $index + 1 ?></span>
                        </div>
                    <?php endforeach; ?>
                </aside>

                <!-- Content Area -->
                <div class="guide-content">
                    <?php foreach ($cnn_sessions as $index => $s): ?>
                        <div id="<?= $s['id'] ?>" class="session-card">
                            <span class="session-tag">Session <?= $index + 1 ?> (1 Hour)</span>
                            <h2 style="color: var(--workshop-gold);"><?= htmlspecialchars($s['title']) ?></h2>
                            <p><?= htmlspecialchars($s['desc']) ?></p>

                            <div class="theory-panel"
                                style="background: var(--workshop-soft); border-left: 4px solid var(--workshop-accent); padding: 1.5rem; margin: 2rem 0 1rem; border-radius: var(--radius-md);">
                                <h4 style="color: var(--workshop-gold); margin-bottom: 0.5rem;">🧠 ตัวอย่างการสร้างโค้ด
                                    (Learning Examples)</h4>
                                <p style="font-size: 0.9rem; margin-bottom: 0;">ในบทนี้มี <?= count($s['examples']) ?>
                                    ตัวอย่างที่ไล่ระดับความซับซ้อน ให้นักเรียนลองฝึกพิมพ์ผ่าน Editor หรือ Colab</p>
                            </div>

                            <?php foreach ($s['examples'] as $ex_idx => $ex): ?>
                                <h4 style="color: var(--workshop-amber); margin-top: 1.5rem;">🔹
                                    <?= htmlspecialchars($ex['title']) ?>
                                </h4>
                                <div class="code-container" style="margin-bottom: 1.5rem;">
                                    <div class="code-header">
                                        <span>📁 <?= $s['id'] ?>_ex<?= $ex_idx + 1 ?>.py</span>
                                        <div class="code-actions">
                                            <a href="<?= $github_base ?><?= $s['id'] ?>_ex<?= $ex_idx + 1 ?>.ipynb"
                                                target="_blank" class="code-btn">GitHub</a>
                                            <a href="<?= $colab_base ?><?= $s['id'] ?>_ex<?= $ex_idx + 1 ?>.ipynb"
                                                target="_blank" class="code-btn">Colab</a>
                                            <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                        </div>
                                    </div>
                                    <pre><code class="language-python"><?= htmlspecialchars($ex['code']) ?></code></pre>
                                </div>
                            <?php endforeach; ?>

                            <div class="xr-simulator-box">
                                <h4 style="color: white; margin-bottom: 0.5rem; text-transform: uppercase;">XR Output:
                                    ผลลัพธ์ที่จับต้องได้</h4>
                                <p style="color: rgba(255,255,255,0.7); font-size: 0.85rem; margin-bottom: 0.5rem;">
                                    <?= htmlspecialchars($s['xr_caption']) ?>
                                </p>
                                <img src="<?= $s['xr_image'] ?>" alt="XR Simulator Preview">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <?php include 'components/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>

    <script>
        function copyCode(btn) {

            const pre = btn.parentElement.nextElementSibling;
            const code = pre.textContent;
            navigator.clipboard.writeText(code).then(() => {
                const originalText = btn.textContent;
                btn.textContent = 'Copied!';
                btn.style.color = '#fbbf24';
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.color = '#ccc';
                }, 2000);
            });
        }

        function scrollToSession(id) {
            const el = document.getElementById(id);
            const offset = 100;
            const bodyRect = document.body.getBoundingClientRect().top;
            const elementRect = el.getBoundingClientRect().top;
            const elementPosition = elementRect - bodyRect;
            const offsetPosition = elementPosition - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }

        // Scroll spy logic
        window.addEventListener('scroll', () => {
            const sessions = ['session-1', 'session-2', 'session-3', 'session-4'];
            let current = '';

            sessions.forEach(id => {
                const element = document.getElementById(id);
                const rect = element.getBoundingClientRect();
                if (rect.top <= 150) {
                    current = id;
                }
            });

            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('onclick').includes(current)) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>