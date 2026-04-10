<!-- Navigation -->
<nav class="navbar">
    <div class="container">
        <div class="nav-brand">
            <div class="logo-icon">🌾</div>
            <div class="brand-text">
                <a href="index.php" class="nav-link active" style="padding: 0;">
                <div class="brand-name">RBRU-Praneet</div>
                <div class="brand-subtitle">Digital Agri-Innovation</div>
                </a>
            </div>
        </div>
        <ul class="nav-links">
            <li><a href="index.php" class="nav-link active"><?php echo $lang['nav_home']; ?></a></li>
            <li><a href="plan.php" class="nav-link"><?php echo $lang['nav_docs']; ?></a></li>
            
            <!-- Workshop Dropdown -->
            <li class="has-dropdown-wrapper">
                <div class="nav-link has-dropdown"><?php echo $lang['nav_workshop']; ?> <span class="dropdown-icon">▼</span></div>
                <div class="dropdown-menu">
                    <ul class="dropdown-list">
                        <li><a href="workshop-climate.php" class="dropdown-item"><span class="item-icon">🌦️</span> <?php echo $lang['nav_workshop_1']; ?></a></li>
                            <li><a href="workshop-iot.php" class="dropdown-item"><span class="item-icon">🤖</span> <?php echo $lang['nav_workshop_3']; ?></a></li>
                            <li><a href="virtual-lab.php" class="dropdown-item"><span class="item-icon">🎮</span> Digital Twin Lab</a></li>
                            <li><a href="showcase.php" class="dropdown-item"><span class="item-icon">🚀</span> <?php echo $lang['nav_workshop_4']; ?></a></li>
                        <li><a href="index.php#activities" class="dropdown-item"><span class="item-icon">📌</span> <?php echo $lang['nav_activities']; ?></a></li>
                    </ul>
                </div>
            </li>

            <li><a href="ai-agent.php" class="nav-link"><?php echo $lang['nav_ai']; ?></a></li>

            <!-- About Us Dropdown -->
            <li class="has-dropdown-wrapper">
                <div class="nav-link has-dropdown"><?php echo $lang['nav_about']; ?> <span class="dropdown-icon">▼</span></div>
                <div class="dropdown-menu">
                    <ul class="dropdown-list">
                        <li><a href="index.php#about" class="dropdown-item"><span class="item-icon">📝</span> <?php echo $lang['nav_about_rationale']; ?></a></li>
                        <li><a href="responsible1.php" class="dropdown-item"><span class="item-icon">👨‍💻</span> <?php echo $lang['nav_team']; ?></a></li>
                        <li><a href="participant_list.php" class="dropdown-item"><span class="item-icon">📜</span> <?php echo $lang['nav_participants']; ?></a></li>
                    </ul>
                </div>
            </li>

            <!-- Admin Button Moved to Footer -->
            
            <!-- Language Switcher -->
            <li>
                <div class="lang-switcher" style="display: flex; align-items: center; margin-left: 15px; background: rgba(0,0,0,0.05); padding: 5px 10px; border-radius: 50px;">
                    <a href="?lang=th" style="text-decoration: none; margin-right: 8px; opacity: <?php echo ($lang_code == 'th') ? '1' : '0.4'; ?>; transition: opacity 0.3s;">🇹🇭</a>
                    <a href="?lang=en" style="text-decoration: none; opacity: <?php echo ($lang_code == 'en') ? '1' : '0.4'; ?>; transition: opacity 0.3s;">🇬🇧</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
