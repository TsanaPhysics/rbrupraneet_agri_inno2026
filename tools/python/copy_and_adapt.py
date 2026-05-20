import re

print("Starting structural transfer from climate to cnn...")

# 1. Read climate template
with open('workshop-climate.php', 'r', encoding='utf-8') as f:
    html = f.read()

# 2. Modify Hero Texts & Paths
html = html.replace('Climate Data Hacking | IDEA Center Workshop', 'Deep Dive Lab: CNN | IDEA Center Workshop')
html = html.replace('Climate Data Hacking', 'Deep Dive Lab: CNN')
html = html.replace('เปลี่ยนพยากรณ์อากาศให้เป็นปัญญาประดิษฐ์ (Interactive Dashboard)', 'กิจกรรมที่ 2: ปัญญาประดิษฐ์จำแนกโรคพืชด้วย Deep Learning (Visual Dashboard)')
html = html.replace('manual-pocketbook.php', 'manual-cnn-pocketbook.php')

# Change images
html = html.replace('url(\'assets/images/manual_cover_orange_1775878501210.png\')', 'url(\'assets/images/activities/cnn_plant_lab.png\')')

# Change JSON loaders
html = html.replace('data/climate_sessions.json', 'data/cnn_sessions.json')
html = html.replace('$climate_sessions', '$cnn_sessions')
html = html.replace('climate_starter.py', 'cnn_starter.py')
html = html.replace('rbru_climate_master.py', 'rbru_cnn_master.py')
html = html.replace('chanthaburi_climate_sample.csv', 'leaf_disease_dataset.zip')

# Change specific colors to Emerald green to fit CNN vibe
# Orange -> Emerald
html = html.replace('--workshop-accent: #f97316;', '--workshop-accent: #10b981;')
html = html.replace('--workshop-amber: #fbbf24;', '--workshop-amber: #34d399;')
html = html.replace('--workshop-gold: #d97706;', '--workshop-gold: #059669;')
html = html.replace('--workshop-soft: rgba(249, 115, 22, 0.05);', '--workshop-soft: rgba(16, 185, 129, 0.05);')
html = html.replace('rgba(249, 115, 22, 0.2)', 'rgba(16, 185, 129, 0.2)')
html = html.replace('rgba(249, 115, 22, 0.5)', 'rgba(16, 185, 129, 0.5)')
html = html.replace('rgba(249, 115, 22, 0.3)', 'rgba(16, 185, 129, 0.3)')
html = html.replace('rgba(249, 115, 22, 0.4)', 'rgba(16, 185, 129, 0.4)')
html = html.replace('rgba(249, 115, 22, 0.05)', 'rgba(16, 185, 129, 0.05)')
html = html.replace('rgba(249, 115, 22, 0.15)', 'rgba(16, 185, 129, 0.15)')

# 3. Write to workshop-cnn.php
with open('workshop-cnn.php', 'w', encoding='utf-8') as f:
    f.write(html)

print("✅ Successfully adapted workshop-cnn.php using the climate template.")
