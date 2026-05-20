<!-- About Section -->
<section id="about" class="about">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">About Project</span>
            <h2 class="section-title">เกี่ยวกับโครงการ</h2>
            <p class="section-description">
                โครงการที่ผสานเทคโนโลยีล้ำสมัยเข้ากับเกษตรกรรม<br>
                เพื่อสร้างนวัตกรรมที่ตอบโจทย์ท้าทายของโลกรวน
            </p>
        </div>
        
        <div class="about-content" style="max-width: 1200px; margin: 0 auto;">
            <!-- Objectives Section -->
            <div class="objectives-section" style="max-width: 900px; margin: 0 auto 4rem auto;">
            <div class="rationale-card glass-card reveal" style="padding: 3rem; margin-bottom: 3rem; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -20px; right: -20px; font-size: 8rem; opacity: 0.03; font-weight: 800; pointer-events: none;">RATIONALE</div>
                <span class="section-tag" style="display: inline-block; background: var(--primary-gradient); color: white; padding: 4px 15px; border-radius: 50px; font-size: 0.8rem; margin-bottom: 1.5rem; -webkit-text-fill-color: white;"><?php echo $lang['about_tag']; ?></span>
                <h2 class="section-title" style="margin-bottom: 2rem;"><?php echo $lang['about_title']; ?></h2>
                <p style="font-size: 1.1rem; line-height: 1.8; color: var(--text-secondary); text-align: justify;">
                    <?php echo $lang['about_rationale']; ?>
                </p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 2.5rem;">
                    <div style="padding: 1rem; border-left: 4px solid var(--accent-color); background: rgba(139, 92, 246, 0.05); border-radius: 0 var(--radius-md) var(--radius-md) 0;">
                        <h4 style="color: var(--accent-color); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">ประเภทโครงการหลัก</h4>
                        <p style="font-weight: 700; color: var(--text-primary);">BCG Economic Model</p>
                    </div>
                    <div style="padding: 1rem; border-left: 4px solid var(--primary-color); background: rgba(16, 185, 129, 0.05); border-radius: 0 var(--radius-md) var(--radius-md) 0;">
                        <h4 style="color: var(--primary-color); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">พื้นที่ดำเนินการ</h4>
                        <p style="font-weight: 700; color: var(--text-primary);">จ.จันทบุรี และ ตราด</p>
                    </div>
                </div>
            </div>

            <div class="objectives-section" style="margin-top: 4rem;">
                <h3 style="text-align: center; margin-bottom: 3.5rem; font-size: 2.2rem; font-weight: 800; color: var(--text-primary);" class="reveal"><?php echo $lang['obj_title']; ?></h3>
                <div class="obj-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
                    <div class="obj-card glass-card reveal" style="padding: 2.5rem 2rem; border-radius: var(--radius-2xl); border-bottom: 6px solid var(--primary-color); text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1.5rem; filter: drop-shadow(0 5px 10px rgba(16, 185, 129, 0.3));">🎓</div>
                        <p style="font-weight: 800; line-height: 1.6; font-size: 1.05rem; color: var(--text-primary);"><?php echo $lang['obj_1']; ?></p>
                    </div>
                    <div class="obj-card glass-card reveal" style="padding: 2.5rem 2rem; border-radius: var(--radius-2xl); border-bottom: 6px solid var(--secondary-color); text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1.5rem; filter: drop-shadow(0 5px 10px rgba(251, 191, 36, 0.3));">🍎</div>
                        <p style="font-weight: 800; line-height: 1.6; font-size: 1.05rem; color: var(--text-primary);"><?php echo $lang['obj_2']; ?></p>
                    </div>
                    <div class="obj-card glass-card reveal" style="padding: 2.5rem 2rem; border-radius: var(--radius-2xl); border-bottom: 6px solid var(--accent-color); text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1.5rem; filter: drop-shadow(0 5px 10px rgba(139, 92, 246, 0.3));">🤝</div>
                        <p style="font-weight: 800; line-height: 1.6; font-size: 1.05rem; color: var(--text-primary);"><?php echo $lang['obj_3']; ?></p>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="pillars-section" style="margin-top: 5rem;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h3 style="font-size: 2.2rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1rem;">เสาหลักทางเทคโนโลยี (Technical Pillars)</h3>
                <p style="color: var(--text-secondary); font-size: 1.1rem; max-width: 800px; margin: 0 auto;">หัวใจสำคัญของการขับเคลื่อนเทคโนโลยีของโครงการ RBRU-Praneet ประกอบด้วย 3 ด้านหลัก ดังนี้:</p>
            </div>

            <div class="about-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
                <div class="about-card reveal">
                    <div class="card-image">
                        <img src="assets/images/pillar_data.png" alt="Data Analysis">
                    </div>
                    <div class="card-content" style="padding: 1.5rem 0 0 0;">
                        <h3>Data Analysis (การวิเคราะห์ข้อมูล)</h3>
                        <p style="text-align: justify; margin-top: 0.5rem;">มุ่งเน้นการใช้ภาษา Python เพื่อวิเคราะห์ข้อมูลสภาพอากาศและสิ่งแวดล้อมเชิงลึก</p>
                    </div>
                </div>
                <div class="about-card reveal">
                    <div class="card-image">
                        <img src="assets/images/pillar_ai.png" alt="AI Development">
                    </div>
                    <div class="card-content" style="padding: 1.5rem 0 0 0;">
                        <h3>AI Development (การพัฒนาระบบปัญญาประดิษฐ์)</h3>
                        <p style="text-align: justify; margin-top: 0.5rem;">มุ่งเน้นการสร้างโมเดล Deep Learning (CNN) เพื่อการวินิจฉัยโรคพืชและสุขภาพผลผลิต</p>
                    </div>
                </div>
                <div class="about-card reveal">
                    <div class="card-image">
                        <img src="assets/images/pillar_iot.png" alt="IoT Integration">
                    </div>
                    <div class="card-content" style="padding: 1.5rem 0 0 0;">
                        <h3>IoT Integration (การบูรณาการอินเทอร์เน็ตสรรพสิ่ง)</h3>
                        <p style="text-align: justify; margin-top: 0.5rem;">มุ่งเน้นการสร้างระบบเซ็นเซอร์อัจฉริยะแบบไร้สายและระบบ Digital Twin เพื่อการควบคุมสวนอัจฉริยะ</p>
                    </div>
                </div>
            </div>
        </div>

        <style>
            @media (max-width: 992px) {
                .obj-grid, .about-grid {
                    grid-template-columns: repeat(2, 1fr) !important;
                }
            }
            @media (max-width: 768px) {
                .obj-grid, .about-grid {
                    grid-template-columns: 1fr !important;
                }
            }
            .obj-card:hover {
                transform: translateY(-15px);
                box-shadow: 0 25px 50px rgba(0,0,0,0.1) !important;
                border-bottom-width: 10px !important;
            }
        </style>
    </div>
</section>
