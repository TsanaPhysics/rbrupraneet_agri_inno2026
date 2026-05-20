import re

print("Starting structural transfer of manual...")

with open('manual-pocketbook.php', 'r', encoding='utf-8') as f:
    html = f.read()

# 1. Update text metadata & titles
html = html.replace('ePocketbook: Climate Hacking 2026', 'ePocketbook: CNN Plant Disease 2026')
html = html.replace('Climate Hacking Handbook', 'CNN Deep Dive Lab Handbook')
html = html.replace('เปลี่ยนพยากรณ์อากาศให้เป็นปัญญาประดิษฐ์อัตโนมัติ', 'ระบบจำแนกโรคพืชด้วยโครงข่ายประสาทเทียม (Computer Vision)')
html = html.replace('Intelligent Climate Control System', 'AI Plant Disease Vision System')

# 2. Update JSON sources
html = html.replace('data/climate_sessions.json', 'data/cnn_sessions.json')
html = html.replace('$climate_sessions', '$cnn_sessions')

# 3. Swap main brand imagery
html = html.replace('assets/images/manual_cover_orange_1775878501210.png', 'assets/images/activities/cnn_plant_lab.png')
html = html.replace('assets/images/manual_interior_page_illustration_1775860235095.png', 'assets/images/sim/agri_drone.png')

# 4. Color transformations for print layout (Soft Emerald vibes instead of Orange)
html = html.replace('--primary: #d97706;', '--primary: #059669;')
html = html.replace('--accent: #f97316;', '--accent: #10b981;')
html = html.replace('--gold: #b45309;', '--gold: #047857;')
html = html.replace('--orange-soft: rgba(249, 115, 22, 0.1);', '--orange-soft: rgba(16, 185, 129, 0.1);')
html = html.replace('var(--orange-soft)', 'var(--orange-soft)') # Leave variable name to avoid deep CSS refactoring, just changes hex

with open('manual-cnn-pocketbook.php', 'w', encoding='utf-8') as f:
    f.write(html)

print("✅ Successfully generated manual-cnn-pocketbook.php")
