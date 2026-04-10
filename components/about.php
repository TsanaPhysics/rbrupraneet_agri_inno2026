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
            
        <div class="about-content" style="max-width: 900px; margin: 0 auto;">
            <div class="rationale-card" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); padding: 3rem; border-radius: var(--radius-2xl); border: 1px solid rgba(255,255,255,0.1); margin-bottom: 3rem; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -20px; right: -20px; font-size: 8rem; opacity: 0.03; font-weight: 800; pointer-events: none;">RATIONALE</div>
                <span class="section-tag" style="display: inline-block; background: var(--primary-color); color: white; padding: 4px 15px; border-radius: 50px; font-size: 0.8rem; margin-bottom: 1.5rem;"><?php echo $lang['about_tag']; ?></span>
                <h2 class="section-title" style="margin-bottom: 2rem;"><?php echo $lang['about_title']; ?></h2>
                <p style="font-size: 1.1rem; line-height: 1.8; color: var(--text-secondary); text-align: justify;">
                    <?php echo $lang['about_rationale']; ?>
                </p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 2.5rem;">
                    <div style="padding: 1rem; border-left: 4px solid var(--accent-color); background: rgba(var(--accent-rgb), 0.1);">
                        <h4 style="color: var(--primary-color); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">ประเภทโครงการหลัก</h4>
                        <p style="font-weight: 500;">BCG Economic Model</p>
                    </div>
                    <div style="padding: 1rem; border-left: 4px solid var(--primary-color); background: rgba(var(--primary-rgb), 0.1);">
                        <h4 style="color: var(--primary-color); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">พื้นที่ดำเนินการ</h4>
                        <p style="font-weight: 500;">จ.จันทบุรี และ ตราด</p>
                    </div>
                </div>
            </div>

            <div class="objectives-section" style="margin-top: 4rem;">
                <h3 style="text-align: center; margin-bottom: 3rem; font-size: 2rem;"><?php echo $lang['obj_title']; ?></h3>
                <div class="obj-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
                    <div class="obj-card" style="background: var(--bg-secondary); padding: 2rem; border-radius: var(--radius-xl); transition: transform 0.3s ease; border-bottom: 5px solid #4facfe;">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">🎓</div>
                        <p style="font-weight: 600; line-height: 1.6;"><?php echo $lang['obj_1']; ?></p>
                    </div>
                    <div class="obj-card" style="background: var(--bg-secondary); padding: 2rem; border-radius: var(--radius-xl); transition: transform 0.3s ease; border-bottom: 5px solid #00f2fe;">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">🍎</div>
                        <p style="font-weight: 600; line-height: 1.6;"><?php echo $lang['obj_2']; ?></p>
                    </div>
                    <div class="obj-card" style="background: var(--bg-secondary); padding: 2rem; border-radius: var(--radius-xl); transition: transform 0.3s ease; border-bottom: 5px solid #38f9d7;">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">🤝</div>
                        <p style="font-weight: 600; line-height: 1.6;"><?php echo $lang['obj_3']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="about-grid">
            <div class="about-card">
                <div class="card-image">
                    <img src="assets/images/pillar_data.png" alt="Data Analysis">
                </div>
                <div class="card-content">
                    <h3>Data Analysis</h3>
                    <p>วิเคราะห์ข้อมูลสภาพอากาศและสภาพแวดล้อมด้วยเทคโนโลยี Python</p>
                </div>
            </div>
            <div class="about-card">
                <div class="card-image">
                    <img src="assets/images/pillar_ai.png" alt="AI Development">
                </div>
                <div class="card-content">
                    <h3>AI Development</h3>
                    <p>พัฒนาโมเดล AI เพื่อจำแนกโรคพืชและวิเคราะห์สุขภาพพืช</p>
                </div>
            </div>
            <div class="about-card">
                <div class="card-image">
                    <img src="assets/images/pillar_iot.png" alt="IoT Integration">
                </div>
                <div class="card-content">
                    <h3>IoT Integration</h3>
                    <p>สร้างระบบเซ็นเซอร์อัจฉริยะเพื่อเก็บข้อมูลแบบเรียลไทม์</p>
                </div>
            </div>
        </div>
    </div>
</section>
