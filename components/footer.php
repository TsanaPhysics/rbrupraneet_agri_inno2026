<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <div class="footer-logo">
                    <div class="logo-icon">🌾</div>
                    <div class="brand-text">
                        <div class="brand-name">RBRU-Praneet</div>
                        <div class="brand-subtitle">Digital Agri-Innovation Center</div>
                    </div>
                </div>
                <p class="footer-description">
                    ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล<br>
                    รำไพพรรณี-ประณีตวิทยาคม
                </p>
            </div>
            <div class="footer-links">
                <div class="footer-column">
                    <h4>เกี่ยวกับ</h4>
                    <a href="#about"><?php echo isset($lang['nav_about']) ? $lang['nav_about'] : 'About'; ?></a>
                    <a href="#activities"><?php echo isset($lang['nav_activities']) ? $lang['nav_activities'] : 'Activities'; ?></a>
                    <a href="#responsible">Team</a>
                </div>
                <div class="footer-column">
                    <h4>ทักษะที่พัฒนา</h4>
                    <a href="#activities">Data Analysis</a>
                    <a href="#activities">AI Development</a>
                    <a href="#activities">IoT Prototyping</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p><?php echo isset($lang['footer_copyright']) ? $lang['footer_copyright'] : '&copy; 2026 RBRU-Praneet'; ?></p>
            <a href="admin/login.php" class="admin-link" style="font-size: 0.75rem; color: var(--text-muted); text-decoration: none; opacity: 0.5; transition: opacity 0.3s;">Admin Login</a>
        </div>
    </div>
</footer>
