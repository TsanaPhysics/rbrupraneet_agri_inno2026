<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <!-- Column 1: Brand & Partners -->
            <div class="footer-brand">
                <div class="footer-logo">
                    <div class="logo-icon">🌿</div>
                    <div class="brand-text">
                        <div class="brand-name">RBRU-Praneet</div>
                        <div class="brand-subtitle">AIDA xAI Center</div>
                    </div>
                </div>
                <p class="footer-description">
                    <strong>ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม</strong><br>
                    ความร่วมมือทางวิชาการและเทคโนโลยีระหว่าง คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏรำไพพรรณี (RBRU) และ โรงเรียนประณีตวิทยาคม จ.ตราด เพื่อขับเคลื่อนเยาวชนสู่นักนวัตกรเกษตรดิจิทัลรุ่นเยาว์
                </p>
            </div>

            <!-- Column 2: Navigation Links -->
            <div class="footer-column">
                <h4><?php echo isset($lang['nav_about']) ? $lang['nav_about'] : 'เมนูหลัก'; ?></h4>
                <a href="index.php"><span class="icon">🏠</span> <?php echo isset($lang['nav_home']) ? $lang['nav_home'] : 'หน้าหลัก'; ?></a>
                <a href="workshop-climate.php"><span class="icon">🌦️</span> Climate Data</a>
                <a href="workshop-cnn.php"><span class="icon">🍃</span> AI Leaf Diseases</a>
                <a href="workshop-iot.php"><span class="icon">🤖</span> Smart Farm IoT</a>
                <a href="virtual-lab.php"><span class="icon">🎮</span> Digital Twin Lab</a>
                <a href="showcase.php"><span class="icon">🚀</span> <?php echo isset($lang['nav_workshop_4']) ? $lang['nav_workshop_4'] : 'ผลงานสิ่งประดิษฐ์'; ?></a>
                <a href="responsible1.php"><span class="icon">👨‍💻</span> <?php echo isset($lang['nav_team']) ? $lang['nav_team'] : 'คณะผู้จัดทำ'; ?></a>
            </div>

            <!-- Column 3: Contact Details -->
            <div class="footer-column">
                <h4>ช่องทางติดต่อ</h4>
                <div class="footer-contact-item">
                    <span class="icon">📍</span>
                    <span>
                        <strong>โรงเรียนประณีตวิทยาคม</strong><br>
                        หมู่ 2 ต.ประณีต อ.เขาสมิง จ.ตราด 23150
                    </span>
                </div>
                <div class="footer-contact-item">
                    <span class="icon">👨‍🏫</span>
                    <span>
                        <strong>รศ.ดร. ชีวะ ทัศนา</strong><br>
                        คณะวิทยาศาสตร์และเทคโนโลยี มรภ.รำไพพรรณี
                    </span>
                </div>
                <div class="footer-contact-item">
                    <span class="icon">🌐</span>
                    <span><a href="https://chewa.rbru.ac.th" target="_blank" style="display:inline; margin:0; padding:0; font-size:inherit; font-weight:inherit; color:inherit;">chewa.rbru.ac.th</a></span>
                </div>
            </div>

            <!-- Column 4: Location Map -->
            <div class="footer-column">
                <h4>พิกัดศูนย์การเรียนรู้</h4>
                <div class="footer-map-container">
                    <iframe 
                        src="https://maps.google.com/maps?q=โรงเรียนประณีตวิทยาคม%20ตราด&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p><?php echo isset($lang['footer_copyright']) ? $lang['footer_copyright'] : '&copy; 2026 RBRU-Praneet. All rights reserved.'; ?></p>
            
            <div class="footer-partners">
                <span style="font-size: 0.8rem; color: #475569; font-weight: 700;">PARTNERS:</span>
                <span style="font-size: 0.85rem; color: #94a3b8; font-weight: 600;">Rampai Phanni Rajabhat University</span>
                <span style="font-size: 0.85rem; color: #64748b;">x</span>
                <span style="font-size: 0.85rem; color: #94a3b8; font-weight: 600;">Praneet Wittayakhom School</span>
            </div>

            <a href="admin/login.php" class="admin-link" style="margin-top: 15px; font-size: 0.75rem; color: #475569; text-decoration: none; opacity: 0.6; transition: opacity 0.3s; font-weight: 600;">🔐 Admin Control Panel</a>
        </div>
    </div>
</footer>
