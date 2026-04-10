<?php
session_start();
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'th';
require_once "languages/{$lang_code}.php";
require_once "db_connect.php";

// GitHub Configuration
$github_user = "TsanaPhysics";
$github_repo = "rbrupraneet_agri_inno2026";
$github_base = "https://github.com/$github_user/$github_repo/blob/main/notebooks/";
$colab_base = "https://colab.research.google.com/github/$github_user/$github_repo/blob/main/notebooks/";
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deep Dive Lab: CNN for Plant Disease | Interactive Workshop</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Thai:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/sections.css">
    <!-- Prism.js for Code Highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --code-bg: #1e1e1e;
            --workshop-accent: #10b981; /* Green for CNN/Agriculture */
        }

        .workshop-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/images/activities/cnn_plant_lab.png');
            background-size: cover;
            background-position: center;
            height: 400px;
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
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .session-tag {
            background: var(--workshop-accent);
            color: white;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .code-container {
            position: relative;
            margin: 1.5rem 0;
            border-radius: var(--radius-lg);
            overflow: hidden;
            background: var(--code-bg);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .code-header {
            background: #2d2d2d;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #eee;
            font-size: 0.8rem;
            border-bottom: 1px solid #3d3d3d;
        }

        .code-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .code-btn {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #ccc;
            padding: 5px 10px;
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
            background: rgba(255,255,255,0.1);
            color: white;
            border-color: var(--workshop-accent);
        }

        .btn-colab:hover {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border-color: #10b981;
        }

        pre[class*="language-"] {
            margin: 0 !important;
            padding: 1.5rem !important;
            font-family: 'Fira Code', monospace !important;
            font-size: 0.9rem !important;
        }

        .interactive-guide {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 3rem;
            margin-top: 3rem;
        }

        .guide-nav {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .nav-item {
            padding: 1.2rem;
            border-radius: var(--radius-lg);
            margin-bottom: 0.8rem;
            cursor: pointer;
            transition: all 0.3s;
            border-left: 4px solid transparent;
            background: rgba(0,0,0,0.02);
        }

        .nav-item.active {
            background: rgba(16, 185, 129, 0.08);
            color: var(--workshop-accent);
            border-left-color: var(--workshop-accent);
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .interactive-guide { grid-template-columns: 1fr; }
            .guide-nav { display: none; }
        }
    </style>
</head>

<body>
    <?php include 'components/navigation.php'; ?>

    <main>
        <!-- Workshop Hero -->
        <section class="workshop-hero">
            <div class="container">
                <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem;">Deep Dive Lab: CNN</h1>
                <p style="font-size: 1.2rem; opacity: 0.9;">กิจกรรมที่ 2: ปัญญาประดิษฐ์เพื่อการจำแนกโรคพืชด้วยเทคนิค Deep Learning</p>
                <div style="margin-top: 2rem; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="docs/cnn_plant_disease_manual.md" class="btn btn-primary" style="background: var(--workshop-accent); color: white; border: none; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3); text-shadow: 0 1px 2px rgba(0,0,0,0.2);">📖 Full Manual (คู่มือฉบับเต็ม)</a>
                    <a href="scripts/cnn_disease_finder.py" class="btn btn-glass">🐍 Download Starter Code (.py)</a>
                    <a href="https://github.com/TsanaPhysics/rbrupraneet_agri_inno2026/tree/main/notebooks" class="btn btn-glass" target="_blank">🐙 View on GitHub</a>
                </div>
            </div>
        </section>

        <section class="container" style="padding: 4rem 1rem;">
            <div class="interactive-guide">
                <!-- Side Nav -->
                <aside class="guide-nav">
                    <div class="nav-item active" onclick="scrollToSession('session-1')">Session 1: Computer Vision</div>
                    <div class="nav-item" onclick="scrollToSession('session-2')">Session 2: Data Augmentation</div>
                    <div class="nav-item" onclick="scrollToSession('session-3')">Session 3: Neural Architecture</div>
                    <div class="nav-item" onclick="scrollToSession('session-4')">Session 4: Deployment AI</div>
                </aside>

                <!-- Content Area -->
                <div class="guide-content">
                    
                    <!-- Session 1 -->
                    <div id="session-1" class="session-card">
                        <span class="session-tag">Session 1 (3 Hours)</span>
                        <h2>ดวงตาของปัญญาประดิษฐ์</h2>
                        <p>เรียนรู้วิธีที่คอมพิวเตอร์ "มองเห็น" ภาพผ่าน OpenCV แปรรูปข้อมูลภาพเบื้องต้น (Pre-processing) เพื่อเตรียมเข้าสู่โครงข่ายประสาทเทียม</p>
                        
                        <div class="theory-panel" style="background: rgba(16, 185, 129, 0.05); border-left: 4px solid var(--workshop-accent); padding: 1.5rem; margin-bottom: 1.5rem; border-radius: var(--radius-md);">
                            <h4 style="color: var(--workshop-accent); margin-bottom: 0.5rem;">📚 ทฤษฎี: คอมพิวเตอร์มองเห็นได้อย่างไร?</h4>
                            <p style="font-size: 0.9rem; color: var(--text-secondary);">คอมพิวเตอร์มองภาพไม่ใช่เป็นรูป แต่เป็น "ตารางตัวเลข" (Matrix) ของพิกเซล โดยแต่ละพิกเซลจะมีค่าความสว่างของสี แดง (R), เขียว (G), และน้ำเงิน (B) การแปรรูปภาพ (Pre-processing) เช่น การแปลงเป็น RGB จึงสำคัญมากเพื่อให้ AI เข้าใจข้อมูลสีที่ถูกต้องของขอบใบไม้</p>
                        </div>
                        
                        <div class="code-container">
                            <div class="code-header">
                                <span>📁 cnn_s1.ipynb</span>
                                <div class="code-actions">
                                    <a href="<?php echo $github_base; ?>cnn_s1.ipynb" target="_blank" class="code-btn">GitHub</a>
                                    <a href="<?php echo $colab_base; ?>cnn_s1.ipynb" target="_blank" class="code-btn btn-colab">Open in Colab</a>
                                    <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                </div>
                            </div>
                            <pre><code class="language-python">import cv2
import matplotlib.pyplot as plt

# โหลดภาพใบพืชเพื่อวิเคราะห์
img = cv2.imread('leaf.jpg')
img_rgb = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)

# แสดงผลเบื้องต้น
plt.imshow(img_rgb)
plt.axis('off')
plt.show()</code></pre>
                        </div>

                        <div class="code-walkthrough" style="font-size: 0.85rem; color: var(--text-secondary); margin-top: 1rem;">
                            <h5 style="color: var(--text-primary); margin-bottom: 0.5rem;">🔍 เจาะลึกโค้ด (Code Walkthrough)</h5>
                            <ul style="padding-left: 1.2rem;">
                                <li><code>cv2.imread</code>: การอ่านไฟล์ภาพจากหน่วยความจำเข้ามาเป็นข้อมูลตัวเลข</li>
                                <li><code>cv2.cvtColor</code>: การสลับช่องสีจาก BGR (ค่าเริ่มต้นของ OpenCV) เป็น RGB เพื่อให้สีดูเป็นธรรมชาติ</li>
                                <li><code>plt.imshow</code>: คำสั่งจาก Library Matplotlib เพื่อวาดภาพพิกเซลออกมาให้มนุษย์ดู</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Session 2 -->
                    <div id="session-2" class="session-card">
                        <span class="session-tag">Session 2 (3 Hours)</span>
                        <h2>การทวีคูณข้อมูล (Data Augmentation)</h2>
                        <p>แก้ปัญหาข้อมูลไม่พอด้วยการดัดแปลงภาพต้นฉบับ (หมุน, พลิก, ปรับแสง) เพื่อให้ AI ของเรามีความฉลาดและแม่นยำยิ่งขึ้น</p>
                        
                        <div class="code-container">
                            <div class="code-header">
                                <span>📁 cnn_s2.ipynb</span>
                                <div class="code-actions">
                                    <a href="<?php echo $github_base; ?>cnn_s2.ipynb" target="_blank" class="code-btn">GitHub</a>
                                    <a href="<?php echo $colab_base; ?>cnn_s2.ipynb" target="_blank" class="code-btn btn-colab">Open in Colab</a>
                                    <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                </div>
                            </div>
                            <pre><code class="language-python">from tensorflow.keras.preprocessing.image import ImageDataGenerator

# สร้าง Generator สำหรับสุ่มเปลี่ยนลักษณะภาพ
train_datagen = ImageDataGenerator(
    rotation_range=40,
    horizontal_flip=True,
    fill_mode='nearest'
)</code></pre>
                        </div>
                    </div>

                    <!-- Session 3 -->
                    <div id="session-3" class="session-card">
                        <span class="session-tag">Session 3 (3 Hours)</span>
                        <h2>สร้างสมองกลด้วย CNN</h2>
                        <p>ลงลึกโครงสร้าง Convolutional Neural Network (Conv2D, Pooling, Dense) และเริ่มการเทรนโมเดลด้วย TensorFlow</p>
                        
                        <div class="code-container">
                            <div class="code-header">
                                <span>📁 cnn_s3.ipynb</span>
                                <div class="code-actions">
                                    <a href="<?php echo $github_base; ?>cnn_s3.ipynb" target="_blank" class="code-btn">GitHub</a>
                                    <a href="<?php echo $colab_base; ?>cnn_s3.ipynb" target="_blank" class="code-btn btn-colab">Open in Colab</a>
                                    <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                </div>
                            </div>
                            <pre><code class="language-python">from tensorflow.keras import layers, models

model = models.Sequential([
    layers.Conv2D(32, (3, 3), activation='relu', input_shape=(128, 128, 3)),
    layers.MaxPooling2D((2, 2)),
    layers.Flatten(),
    layers.Dense(3, activation='softmax') # จำแนก 3 หมวดหมู่
])

model.summary()</code></pre>
                        </div>
                    </div>

                    <!-- Session 4 -->
                    <div id="session-4" class="session-card">
                        <span class="session-tag">Session 4 (3 Hours)</span>
                        <h2>การวัดผลและการนำไปใช้จริง</h2>
                        <p>วิเคราะห์ Accuracy/Loss Curve และทดลองใช้ AI ที่เราสร้างขึ้นทำนายโรคพืชจากภาพถ่ายจริงในสวน</p>
                        
                        <div class="code-container">
                            <div class="code-header">
                                <span>📁 cnn_s4.ipynb</span>
                                <div class="code-actions">
                                    <a href="<?php echo $github_base; ?>cnn_s4.ipynb" target="_blank" class="code-btn">GitHub</a>
                                    <a href="<?php echo $colab_base; ?>cnn_s4.ipynb" target="_blank" class="code-btn btn-colab">Open in Colab</a>
                                    <button class="code-btn" onclick="copyCode(this)">Copy</button>
                                </div>
                            </div>
                            <pre><code class="language-python"># โหลดโมเดลที่เทรนเสร็จแล้วมาทำนาย
results = model.predict(test_images)
print(f"Prediction result: {results[0]}")</code></pre>
                        </div>
                    </div>

                    <!-- Smartphone Vision Lab (Ported Feature) -->
                    <div class="mt-20 p-10 rounded-[2.5rem] bg-slate-900 text-white relative overflow-hidden group border border-white/5">
                        <div class="absolute top-0 right-0 w-80 h-80 bg-orange-500 opacity-10 blur-[100px] -mr-40 -mt-40 group-hover:opacity-20 transition-opacity duration-700"></div>
                        <div class="relative z-10">
                            <div class="flex flex-col md:flex-row items-center gap-8 mb-8">
                                <div class="w-20 h-20 rounded-3xl bg-white/10 flex items-center justify-center text-4xl shadow-inner">📱</div>
                                <div class="text-center md:text-left">
                                    <h3 class="text-3xl font-black mb-2">Smartphone Vision Hub</h3>
                                    <p class="text-slate-400">Deploy and test your models in the real orchard</p>
                                </div>
                            </div>
                            <p class="text-slate-300 mb-10 leading-relaxed text-lg">
                                เมื่อฝึกฝนโมเดลเสร็จสิ้น นักเรียนสามารถส่งออกโมเดล (TFLite/Keras) เพื่อทดสอบผ่านสมาร์ทโฟน 
                                โดยใช้กล้องสแกนใบต้นไม้ในพื้นที่จริงเพื่อจำแนกโรคทุเรียนได้ทันทีผ่านระบบ Web-based Inference ที่เราจัดเตรียมไว้ให้
                            </p>
                            <div class="flex flex-wrap items-center gap-6">
                                <a href="virtual-lab.php" class="btn btn-primary" style="background: var(--primary-gradient); border: none; padding: 15px 35px; border-radius: 50px;">
                                    <span class="mr-2">🚀</span> Launch Test Simulation
                                </a>
                                <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-widest text-emerald-400">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                    Camera Interface Ready
                                </div>
                            </div>
                        </div>
                    </div>
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
                btn.style.borderColor = '#10b981';
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.borderColor = '#555';
                }, 2000);
            });
        }

        function scrollToSession(id) {
            const element = document.getElementById(id);
            const offset = 100;
            const bodyRect = document.body.getBoundingClientRect().top;
            const elementRect = element.getBoundingClientRect().top;
            const elementPosition = elementRect - bodyRect;
            const offsetPosition = elementPosition - offset;

            window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
        }

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
