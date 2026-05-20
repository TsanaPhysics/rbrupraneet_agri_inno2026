import re

file_path = 'manual-pocketbook.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

start_marker = '<!-- PAGE 03: SESSION 1 (Expanded) -->'
end_marker = '<div style="margin-top: 5rem; text-align: center; padding: 4rem; border-top: 1px solid var(--orange-soft);">'

start_idx = content.find(start_marker)
end_idx = content.find(end_marker, start_idx)

if start_idx != -1 and end_idx != -1:
    before = content[:start_idx]
    after = content[end_idx:]
    
    dynamic_loop = """        <!-- DYNAMIC SESSIONS LOOP (Expanded 12-Sessions) -->
        <?php foreach($climate_sessions as $index => $s): ?>
        <section class="page" style="page-break-after: always; display: block; margin-bottom: 2rem;">
            <div class="topic-header-box">
                <span>Session <?= $index+1 ?>: RBRU Module</span>
                <span class="page-num"><?= str_pad($index+3, 2, '0', STR_PAD_LEFT) ?></span>
                <h2 class="mag-title" style="margin-top: 1rem; font-size: 2.2rem; line-height: 1.2;"><?= htmlspecialchars($s['title']) ?></h2>
                <p style="text-indent: 0; color: var(--gold); font-weight: 500; font-size: 1.1rem; margin-top: 1rem;"><?= htmlspecialchars($s['desc']) ?></p>
            </div>

            <?php if(isset($s['examples']) && count($s['examples']) > 0): ?>
            <div class="magazine-columns" style="margin-top: 2rem;">
                <p class="dropcap" style="font-size: 1rem;">
                    เจาะลึกทักษะหลักด้วย <?= count($s['examples']) ?> ตัวอย่างการเขียนกระบวนการทางคณิตศาสตร์และตรรกะแบบขั้นบันได ให้นักเรียนได้ต่อยอดไปสู่ระบบอัจฉริยะแบบ Step-by-step
                </p>
            </div>

            <?php foreach($s['examples'] as $ex_idx => $ex): ?>
            <h4 style="color: var(--gold); margin-top: 1.5rem;">🔹 <?= htmlspecialchars($ex['title']) ?></h4>
            <div class="tech-insight" style="padding: 1.5rem; margin-top: 1rem; break-inside: avoid;">
                <div class="code-block" style="background: rgba(0,0,0,0.5); padding: 1.25rem;">
                    <?= nl2br(str_replace('  ', '&nbsp;&nbsp;', htmlspecialchars($ex['code']))) ?>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>

            <div style="margin-top: 2rem; border-top: 2px dashed var(--gold); padding-top: 1.5rem; text-align: center; break-inside: avoid;">
                <h4 style="color: var(--primary); margin-bottom: 0;">▼ The Simulator Perspective ▼</h4>
                <p style="font-size: 0.85rem; color: #666; text-indent: 0; margin-bottom: 0.5rem;"><?= htmlspecialchars($s['xr_caption']) ?></p>
                <img src="<?= $s['xr_image'] ?>" class="mag-img" style="margin-top: 0.5rem; max-width: 500px;" alt="XR Simulation">
            </div>
        </section>
        <?php endforeach; ?>

            """
    
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(before + dynamic_loop + after)
    print("Python string replacement success.")
else:
    print("Could not find markers.")
