<!-- Responsible Persons Section -->
<?php
// Ensure $db_team exists
if (!isset($db_team)) {
    require_once __DIR__ . '/../db_connect.php';
}
// Check if table empty or not set, fallback gracefully
$team_list = [];
if (isset($db_team)) {
    $team_list = $db_team->all();
    
    // Sort logic to match Admin Panel
    usort($team_list, function($a, $b) {
        $oa = isset($a['order_index']) ? $a['order_index'] : 9999;
        $ob = isset($b['order_index']) ? $b['order_index'] : 9999;
        
        if ($oa == $ob) return $a['id'] - $b['id'];
        return $oa - $ob;
    });
}
?>
<section id="responsible" class="responsible">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Our Team</span>
            <h2 class="section-title">สมาชิกทีม RBRU-Praneet</h2>
        </div>

        <div class="team-grid">
            <?php if(empty($team_list)): ?>
                <p class="text-center">No team members found.</p>
            <?php else: ?>
                <?php foreach($team_list as $member): ?>
                <div class="team-card">
                    <div class="team-photo">
                        <!-- Fix path relative to index.php vs admin -->
                        <img src="<?php echo htmlspecialchars($member['image']); ?>" 
                             alt="<?php echo htmlspecialchars($member['name']); ?>"
                             onerror="this.src='assets/images/placeholder_user.png';">
                    </div>
                    <div class="team-info">
                        <h3 class="team-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                        <p class="team-role"><?php echo htmlspecialchars($member['role']); ?></p>
                        <p class="team-department"><?php echo htmlspecialchars($member['department']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    padding: 2rem 0;
}

.team-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
}

.team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
}

.team-photo {
    width: 100%;
    height: 350px; /* Taller for better portrait view */
    overflow: hidden;
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
}

.team-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
}

.team-info {
    padding: 1.5rem;
    padding-top: 1rem;
}

.team-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1a202c;
    margin-bottom: 0.5rem;
}

.team-role {
    font-size: 0.9rem;
    color: #00b4db; /* Match brand color */
    font-weight: 600;
    margin-bottom: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.team-department {
    font-size: 0.85rem;
    color: #718096;
}
</style>
