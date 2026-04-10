<?php require_once __DIR__ . '/../db_connect.php'; ?>
<section id="registration" class="registration-section">
    <div class="container">
        <h2 class="section-title">ลงทะเบียนกิจกรรม</h2>
        <form action="register.php" method="POST" class="registration-form">
            <div class="form-group">
                <label for="name">ชื่อ-สกุล</label>
                <input type="text" id="name" name="name" required placeholder="กรอกชื่อ-นามสกุลของคุณ" />
            </div>
            <div class="form-group">
                <label for="school">โรงเรียน / สถาบัน</label>
                <input type="text" id="school" name="school" placeholder="ระบุโรงเรียนหรือหน่วยงาน" />
            </div>
            <div class="form-group">
                <label for="email">อีเมล (สำหรับส่งใบเกียรติบัตร)</label>
                <input type="email" id="email" name="email" required placeholder="example@email.com" />
            </div>
            <div class="form-group">
                <label for="activity_id">เลือกกิจกรรม</label>
                <select id="activity_id" name="activity_id" required>
                    <option value="" disabled selected>-- เลือกกิจกรรมที่ต้องการเข้าร่วม --</option>
                    <?php
                    // Use JSON DB instead of PDO
                        if (isset($db_activities)) {
                            $list = $db_activities->all();
                            foreach ($list as $act) {
                                // Default to TH title or fallback
                                $title = isset($act['title_th']) ? $act['title_th'] : 'Activity';
                                echo '<option value="' . $act['id'] . '">' . htmlspecialchars($title) . '</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn-primary">ลงทะเบียน</button>
        </form>
    </div>
</section>
