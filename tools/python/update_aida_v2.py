import os
import glob

replacements = [
    # 1. Manual back cover: "DIGITAL AGRI-INNOVATION CENTER" → EN full name
    ("DIGITAL AGRI-INNOVATION CENTER", "Center for AI Innovation & Development in Agriculture and Environment"),
    
    # 2. Manual back cover: "RBRU-PRANEET" (big text) → "AIDA xAI Center"
    (">RBRU-PRANEET</p>", ">AIDA xAI Center</p>"),
    
    # 3. Manual cover vol line
    ("RBRU-PRANEET</div>", "AIDA xAI Center</div>"),
    
    # 4. Manual h3 back page: remove "AIDA xAI Center" prefix, keep Thai + add EN
    ('>AIDA xAI Center ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม</h3>',
     '>ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม</h3>'),
    
    # 5. CSS content in manuals
    ('content: "AIDA xAI Center ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม"',
     'content: "ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม"'),
    
    # 6. Certificate template logo-text
    ('>AIDA xAI Center ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม</div>',
     '>ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม</div>'),
    
    # 7. Certificate v2
    ("AIDA xAI Center ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม<br>",
     "ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม<br>Center for AI Innovation & Development in Agriculture and Environment<br>"),
    
    # 8. Certificate watermark
    (">RBRU-PRANEET</div>", ">AIDA</div>"),
    
    # 9. Meta description
    ('content="AIDA xAI Center ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม',
     'content="AIDA xAI Center — ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม'),
    
    # 10. Poster logo area
    ("AIDA xAI Center มหาวิทยาลัยราชภัฏรำไพพรรณี",
     "ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม"),
    
    # 11. Poster intro text
    ("ศูนย์ RBRU-Praneet ขอเชิญชวน",
     "ศูนย์ AIDA xAI Center ขอเชิญชวน"),
    
    # 12. Poster contact
    ("สอบถามเพิ่มเติม: AIDA xAI Center — RBRU-Praneet",
     "สอบถามเพิ่มเติม: AIDA xAI Center — Center for AI Innovation & Development in Agriculture and Environment"),
]

php_files = glob.glob("/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/**/*.php", recursive=True)
php_files += glob.glob("/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/*.php")
php_files = list(set(php_files))

total = 0
for fpath in sorted(php_files):
    try:
        with open(fpath, 'r', encoding='utf-8') as f:
            content = f.read()
    except:
        continue
    original = content
    for old, new in replacements:
        content = content.replace(old, new)
    if content != original:
        with open(fpath, 'w', encoding='utf-8') as f:
            f.write(content)
        total += 1
        print(f"✅ {os.path.basename(fpath)}")

print(f"\n🎯 Total: {total} files updated")
