<!-- Navigation -->
<nav class="navbar floating-nav">
    <div class="nav-container container">
        <div class="nav-glass-pod">
            <div class="nav-brand">
                <div class="logo-glow"></div>
                <div class="logo-icon">🌾</div>
                <div class="brand-text">
                    <a href="index.php" class="brand-link">
                        <div class="brand-name">RBRU-Praneet</div>
                        <div class="brand-subtitle">Digital Agri-Innovation</div>
                    </a>
                </div>
            </div>
            
            <ul class="nav-links">
                <li><a href="index.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"><?php echo $lang['nav_home']; ?></a></li>
                <li><a href="plan.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'plan.php') ? 'active' : ''; ?>"><?php echo $lang['nav_docs']; ?></a></li>
                
                <!-- Workshop Dropdown -->
                <li class="has-dropdown-wrapper">
                    <div class="nav-link has-dropdown"><?php echo $lang['nav_workshop']; ?> <span class="dropdown-icon">▼</span></div>
                    <div class="dropdown-menu">
                        <ul class="dropdown-list">
                            <li><a href="workshop-climate.php" class="dropdown-item"><span class="item-icon">🌦️</span> <?php echo $lang['nav_workshop_1']; ?></a></li>
                            <li><a href="workshop-cnn.php" class="dropdown-item"><span class="item-icon">🍃</span> <?php echo $lang['nav_workshop_2']; ?></a></li>
                            <li><a href="workshop-iot.php" class="dropdown-item"><span class="item-icon">🤖</span> <?php echo $lang['nav_workshop_3']; ?></a></li>
                            <li><a href="showcase.php" class="dropdown-item"><span class="item-icon">🚀</span> <?php echo $lang['nav_workshop_4']; ?></a></li>
                            <li><a href="index.php#activities" class="dropdown-item"><span class="item-icon">📌</span> <?php echo $lang['nav_activities']; ?></a></li>
                        </ul>
                    </div>
                </li>

                <li><a href="ai-agent.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'ai-agent.php') ? 'active' : ''; ?>"><?php echo $lang['nav_ai']; ?></a></li>

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
            </ul>

            <!-- Language Switcher Pill -->
            <div class="nav-extra">
                <div class="lang-pill">
                    <a href="?lang=th" class="lang-option <?php echo ($lang_code == 'th') ? 'active' : ''; ?>">TH</a>
                    <a href="?lang=en" class="lang-option <?php echo ($lang_code == 'en') ? 'active' : ''; ?>">EN</a>
                    <span class="lang-slider"></span>
                </div>
            </div>
            
            <!-- Mobile Toggle -->
            <div class="mobile-toggle">
                <span></span><span></span><span></span>
            </div>
        </div>
    </div>
</nav>
