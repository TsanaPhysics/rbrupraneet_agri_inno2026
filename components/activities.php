<!-- Activities Section -->
<?php
if (!isset($db_activities)) {
    require_once __DIR__ . '/../db_connect.php';
}
$activities_list = $db_activities->all();
?>
<section id="activities" class="activities">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Learning Journey</span>
            <h2 class="section-title"><?php echo isset($lang['nav_activities']) ? $lang['nav_activities'] : 'Activities'; ?></h2>
            <p class="section-description">
                กิจกรรมหลักที่จะพาคุณก้าวสู่โลกของนวัตกรรมเกษตรดิจิทัล
            </p>
        </div>

        <div class="activities-grid">
            <?php foreach ($activities_list as $index => $act): ?>
            <?php 
                $title = $act['title_th']; // Default
                if (isset($lang_code) && isset($act['title_' . $lang_code]) && !empty($act['title_' . $lang_code])) {
                    $title = $act['title_' . $lang_code];
                }
                $icon = isset($act['icon']) ? $act['icon'] : '📅';
                $subtitle = isset($act['subtitle_th']) ? $act['subtitle_th'] : '';
                $desc = isset($act['description_th']) ? $act['description_th'] : '';
                
                // Fix: Check correctly if image is not empty, otherwise default
                $image = (!empty($act['image'])) ? $act['image'] : 'assets/images/default_activity.png';
                
                // Date Range Logic
                $date_text = '';
                $start = isset($act['date_start']) ? $act['date_start'] : (isset($act['activity_date']) ? $act['activity_date'] : '');
                $end = isset($act['date_end']) ? $act['date_end'] : '';
                
                if($start) {
                    $date_obj = date_create($start);
                    $date_text = date_format($date_obj, "d M Y");
                    if($end && $end != $start) {
                        $date_end_obj = date_create($end);
                        $date_text .= ' - ' . date_format($date_end_obj, "d M Y");
                    }
                }

                $time = isset($act['activity_time']) ? $act['activity_time'] : '';
                $location = isset($act['location']) ? $act['location'] : '';
                $link = isset($act['link_url']) ? $act['link_url'] : '';
                $doc_path = isset($act['document_path']) ? $act['document_path'] : '';
            ?>
            <!-- Activity Item -->
            <div class="activity-card" data-activity="<?php echo $act['id']; ?>">
                <div class="activity-image">
                    <img src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($title); ?>" 
                         style="background: #eee;"
                         onerror="this.src='https://via.placeholder.com/400x300?text=No+Image';">
                </div>
                <div class="activity-number"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></div>
                <div class="activity-icon"><?php echo $icon; ?></div>
                
                <h3 class="activity-title"><?php echo htmlspecialchars($title); ?></h3>
                <p class="activity-subtitle"><?php echo htmlspecialchars($subtitle); ?></p>
                
                <!-- Date/Location Badge -->
                <?php if($date_text || $location): ?>
                <div class="activity-meta" style="font-size: 0.85rem; color: #555; margin-bottom: 12px; background: #f0f4f8; padding: 10px; border-radius: 8px; border-left: 3px solid var(--primary-color);">
                    <?php if($date_text): ?>
                        <div class="mb-1"><i class="me-1">📅</i> <strong>Date:</strong> <?php echo $date_text; ?></div>
                    <?php endif; ?>
                    <?php if($time): ?>
                        <div class="mb-1"><i class="me-1">⏰</i> <strong>Time:</strong> <?php echo htmlspecialchars($time); ?></div>
                    <?php endif; ?>
                    <?php if($location): ?>
                        <div><i class="me-1">📍</i> <strong>Loc:</strong> <?php echo htmlspecialchars($location); ?></div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <p class="activity-description">
                    <?php echo htmlspecialchars($desc); ?>
                </p>

                <div class="activity-actions" style="margin-top: auto; padding-top: 15px; display: flex; flex-direction: column; gap: 8px;">
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button class="activity-toggle">
                            <span class="toggle-text">รายละเอียด</span>
                            <span class="toggle-icon">+</span>
                        </button>
                        
                        <?php if($link): ?>
                            <a href="<?php echo htmlspecialchars($link); ?>" target="_blank" class="btn-action btn-visit">
                                🌐 Visit Website
                            </a>
                        <?php endif; ?>

                        <?php if($doc_path): ?>
                            <a href="<?php echo htmlspecialchars($doc_path); ?>" target="_blank" class="btn-action btn-download" download>
                                📥 Download Doc
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
/* Ensure Card is Flex for sticky footer actions */
.activity-card {
    display: flex;
    flex-direction: column;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 500;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    text-decoration: none;
    color: white;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    color: white;
}

.btn-visit {
    background: linear-gradient(135deg, #00b4db, #0083b0);
}

.btn-download {
    background: linear-gradient(135deg, #f2994a, #f2c94c);
    color: #333; /* Darker text for contrast on yellow/orange */
}
.btn-download:hover {
    color: #000;
}
</style>
