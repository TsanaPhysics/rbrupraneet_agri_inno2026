import os
import glob

# Define replacements
replacements = [
    # Thai name replacements (full name with location)
    ("ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล รำไพพรรณี-ประณีตวิทยาคม", "AIDA xAI Center ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม"),
    ("ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัลรำไพพรรณี-ประณีตวิทยาคม", "AIDA xAI Center ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม"),
    # Thai name replacements (short name)
    ("ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล มหาวิทยาลัยราชภัฏรำไพพรรณี", "AIDA xAI Center มหาวิทยาลัยราชภัฏรำไพพรรณี"),
    # Thai hero title (must come after longer matches)
    ("'hero_title' => 'ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล'", "'hero_title' => 'AIDA xAI Center'"),
    # Footer Thai short
    ("ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล<br>", "AIDA xAI Center<br>"),
    # English name replacements
    ("RBRU-Praneet Digital Agri-Innovation Center", "AIDA xAI Center — RBRU-Praneet"),
    ("Digital Agri-Innovation Center", "AIDA xAI Center"),
    ("Digital Agri-Innovation", "AIDA xAI Center"),
    # English hero title
    ("'hero_title' => 'Digital Agri-Innovation Center'", "'hero_title' => 'AIDA xAI Center'"),
    # Footer copyright
    ("RBRU-Praneet Digital Agri-Innovation Center.", "AIDA xAI Center — Center for AI Innovation & Development in Agriculture and Environment."),
    # Manual footer-main
    (">ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล</div>", ">AIDA xAI Center</div>"),
    # Manual footer-sub
    (">Digital Agri-Innovation Center</div>", ">Center for AI Innovation & Development in Agriculture and Environment</div>"),
    # Manual CSS content
    ('content: "ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล รำไพพรรณี-ประณีตวิทยาคม"', 'content: "AIDA xAI Center — Center for AI Innovation & Development in Agriculture and Environment"'),
    # Setup/knowledge base
    ("ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล (RBRU-Praneet)", "AIDA xAI Center (RBRU-Praneet)"),
    # about_rationale in th.php
    ('"ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล"', '"AIDA xAI Center"'),
    # Poster specific
    ("ศูนย์นวัตกรรมเกษตรดิจิทัล RBRU-Praneet", "AIDA xAI Center — RBRU-Praneet"),
]

# Find all PHP files
php_files = glob.glob("/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/**/*.php", recursive=True)
php_files += glob.glob("/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/*.php")

# Deduplicate
php_files = list(set(php_files))

total_changes = 0
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
        total_changes += 1
        print(f"✅ Updated: {os.path.basename(fpath)}")

print(f"\n🎯 Total files updated: {total_changes}")
