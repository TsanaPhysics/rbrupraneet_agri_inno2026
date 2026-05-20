<!-- Navigation -->
<nav class="navbar">
    <div class="container">
        <div class="nav-brand">
            <div class="logo-icon">🌿</div>
            <div class="brand-text">
                <a href="index.php">
                    <div class="brand-name">RBRU-Praneet</div>
                    <div class="brand-subtitle">AIDA xAI Center</div>
                </a>
            </div>
        </div>
        <ul class="nav-links">
            <li><a href="index.php" class="nav-link active"><?php echo $lang['nav_home']; ?></a></li>

            <!-- Workshop Dropdown -->
            <li class="has-dropdown-wrapper">
                <div class="nav-link has-dropdown"><?php echo $lang['nav_workshop']; ?> <span class="dropdown-icon">▼</span></div>
                <div class="dropdown-menu glass-card">
                    <ul class="dropdown-list">
                        <li><a href="workshop-climate.php" class="dropdown-item"><span class="item-icon">🌦️</span> <?php echo $lang['nav_workshop_1']; ?></a></li>
                        <li><a href="workshop-cnn.php" class="dropdown-item"><span class="item-icon">🍃</span> <?php echo $lang['nav_workshop_2']; ?></a></li>
                        <li><a href="workshop-iot.php" class="dropdown-item"><span class="item-icon">🤖</span> <?php echo $lang['nav_workshop_3']; ?></a></li>
                        <li><a href="virtual-lab.php" class="dropdown-item"><span class="item-icon">🎮</span> Digital Twin Lab</a></li>
                        <li><a href="showcase.php" class="dropdown-item"><span class="item-icon">🚀</span> <?php echo $lang['nav_workshop_4']; ?></a></li>
                        <li><a href="index.php#activities" class="dropdown-item"><span class="item-icon">📌</span> <?php echo $lang['nav_activities']; ?></a></li>
                        <li><a href="plan.php" class="dropdown-item"><span class="item-icon">📄</span> <?php echo $lang['nav_docs']; ?></a></li>
                    </ul>
                </div>
            </li>

            <li><a href="ai-agent.php" class="nav-link"><?php echo $lang['nav_ai']; ?></a></li>

            <!-- About Us Dropdown -->
            <li class="has-dropdown-wrapper">
                <div class="nav-link has-dropdown"><?php echo $lang['nav_about']; ?> <span class="dropdown-icon">▼</span></div>
                <div class="dropdown-menu glass-card">
                    <ul class="dropdown-list">
                        <li><a href="index.php#about" class="dropdown-item"><span class="item-icon">📝</span> <?php echo $lang['nav_about_rationale']; ?></a></li>
                        <li><a href="responsible1.php" class="dropdown-item"><span class="item-icon">👨‍💻</span> <?php echo $lang['nav_team']; ?></a></li>
                        <li><a href="participant_list.php" class="dropdown-item"><span class="item-icon">📜</span> <?php echo $lang['nav_participants']; ?></a></li>
                    </ul>
                </div>
            </li>

            <!-- Language Switcher -->
            <li>
                <div class="lang-switcher" style="display: flex; align-items: center; margin-left: 15px; background: rgba(16, 185, 129, 0.08); padding: 4px; border-radius: 50px; border: 1px solid rgba(16, 185, 129, 0.15);">
                    <a href="?lang=th" class="lang-btn" style="text-decoration: none; font-size: 0.75rem; font-weight: 700; padding: 4px 12px; border-radius: 50px; color: <?php echo ($lang_code == 'th') ? 'white' : 'var(--text-secondary)'; ?>; background: <?php echo ($lang_code == 'th') ? 'var(--primary-gradient)' : 'transparent'; ?>; box-shadow: <?php echo ($lang_code == 'th') ? '0 4px 10px rgba(16,185,129,0.2)' : 'none'; ?>; transition: all 0.3s ease;">TH</a>
                    <a href="?lang=en" class="lang-btn" style="text-decoration: none; font-size: 0.75rem; font-weight: 700; padding: 4px 12px; border-radius: 50px; color: <?php echo ($lang_code == 'en') ? 'white' : 'var(--text-secondary)'; ?>; background: <?php echo ($lang_code == 'en') ? 'var(--primary-gradient)' : 'transparent'; ?>; box-shadow: <?php echo ($lang_code == 'en') ? '0 4px 10px rgba(16,185,129,0.2)' : 'none'; ?>; transition: all 0.3s ease;">EN</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
