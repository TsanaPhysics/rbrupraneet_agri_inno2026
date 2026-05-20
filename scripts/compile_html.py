import os
import re
import markdown

INPUT_MD_FILE = "/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/aiiot2026/training_manual_expanded.md"
OUTPUT_HTML_FILE = "/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/scratch/manual.html"

def compile_markdown_to_html():
    print(f"[PROCESS] Reading Markdown file: {INPUT_MD_FILE} ...")
    if not os.path.exists(INPUT_MD_FILE):
        print(f"[ERROR] Markdown file does not exist: {INPUT_MD_FILE}")
        return
        
    with open(INPUT_MD_FILE, "r", encoding="utf-8") as f:
        md_content = f.read()

    # Strip the title headers from the beginning of md_content to avoid duplicate titles
    # Since our custom HTML cover page will provide a stunning title, we don't want the raw md text headers.
    # The first header in training_manual_expanded.md is:
    # # คู่มือปฏิบัติการวิศวกรรมระบบน้ำอัตโนมัติและไอโอทีเกษตรอัจฉริยะ 2568
    # Let's locate the Table of Contents or first module and keep from there.
    # We will look for "## สารบัญโมดูลการเรียนรู้ (Table of Contents)" and start from there.
    toc_marker = "## สารบัญโมดูลการเรียนรู้ (Table of Contents)"
    toc_idx = md_content.find(toc_marker)
    if toc_idx != -1:
        md_body = md_content[toc_idx:]
    else:
        md_body = md_content

    print("[PROCESS] Parsing Markdown with fenced_code and tables extensions ...")
    # Convert markdown to HTML
    html_body = markdown.markdown(md_body, extensions=['fenced_code', 'tables', 'toc'])

    # Style improvements to parsed HTML output:
    # 1. Add class "math-eq" to equations
    html_body = re.sub(r'<p>(\$\$.*?\$\$)</p>', r'<div class="math-eq">\1</div>', html_body, flags=re.DOTALL)
    
    # 2. Add border to all generated tables
    html_body = html_body.replace('<table>', '<table class="academic-table">')

    # Premium HTML + CSS Template for A4 PDF Book
    html_template = f"""<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>คู่มือปฏิบัติการวิศวกรรมระบบน้ำอัตโนมัติและไอโอทีเกษตรอัจฉริยะ</title>
  
  <!-- Premium Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Sarabun:ital,wght@0,300;0,400;0,600;0,700;1,400&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
  
  <!-- Highlight.js for Code Highlighting -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
  <script>hljs.highlightAll();</script>

  <!-- MathJax for rendering equations in PDF -->
  <script>
    window.MathJax = {{
      tex: {{
        inlineMath: [['$', '$'], ['\\\\(', '\\\\)']],
        displayMath: [['$$', '$$'], ['\\\\[', '\\\\]']]
      }},
      svg: {{
        fontCache: 'global'
      }}
    }};
  </script>
  <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js" id="MathJax-script" async></script>

  <style>
    /* Global Print & Page Styling */
    @page {{
      size: A4;
      margin: 1.8cm 2cm 2cm 2cm;
    }}
    
    @page:first {{
      margin: 0 !important;
    }}
    
    body {{
      font-family: 'Sarabun', 'Outfit', sans-serif;
      font-size: 14px;
      line-height: 1.7;
      color: #2c3e50;
      background-color: #ffffff;
    }}
    
    /* Cover Page Styling */
    .cover-page {{
      page-break-after: always;
      height: 100vh;
      padding: 2cm;
      box-sizing: border-box;
      background-color: #fafbfc;
    }}
    
    .cover-border {{
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border: 3px double #1b5e20;
      padding: 30px;
      box-sizing: border-box;
      text-align: center;
    }}
    
    .cover-header {{
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 20px;
    }}
    
    .cover-badge {{
      border: 2px solid #1b5e20;
      color: #1b5e20;
      font-family: 'Outfit', sans-serif;
      font-weight: 700;
      padding: 6px 16px;
      font-size: 12px;
      border-radius: 20px;
      letter-spacing: 2px;
      margin-bottom: 20px;
      background-color: #e8f5e9;
    }}
    
    .cover-title {{
      font-size: 28px;
      color: #1b5e20;
      font-weight: 700;
      line-height: 1.3;
      margin: 20px 0;
      font-family: 'Sarabun', sans-serif;
    }}
    
    .cover-divider {{
      width: 80px;
      height: 4px;
      background-color: #c5a880;
      margin: 15px auto;
      border-radius: 2px;
    }}
    
    .cover-subtitle {{
      font-size: 16px;
      color: #555;
      line-height: 1.6;
      max-width: 600px;
      margin: 0 auto;
    }}
    
    .cover-center {{
      margin: auto 0;
      display: flex;
      flex-direction: column;
      align-items: center;
    }}
    
    .cover-target {{
      font-size: 14px;
      color: #2e7d32;
      background-color: #f1f8e9;
      padding: 8px 24px;
      border-radius: 4px;
      font-weight: 600;
      display: inline-block;
      margin-bottom: 40px;
    }}
    
    .stamp-container {{
      border: 3px solid #c5a880;
      color: #c5a880;
      font-family: 'Outfit', sans-serif;
      font-weight: 700;
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 6px;
      letter-spacing: 1px;
      text-transform: uppercase;
      display: inline-block;
      transform: rotate(-3deg);
      margin: 20px 0;
    }}
    
    .cover-footer {{
      margin-bottom: 20px;
    }}
    
    .cover-author {{
      font-size: 15px;
      font-weight: 600;
      color: #333;
      margin-bottom: 5px;
    }}
    
    .cover-org {{
      font-size: 12px;
      color: #666;
      line-height: 1.5;
    }}
    
    /* Academic Typography */
    h1, h2, h3, h4 {{
      font-family: 'Outfit', 'Sarabun', sans-serif;
      color: #1b5e20;
      font-weight: 700;
      page-break-inside: avoid;
    }}
    
    h1 {{
      font-size: 20px;
      border-bottom: 2px solid #81c784;
      padding-bottom: 8px;
      margin-top: 35px;
      margin-bottom: 15px;
      page-break-before: always;
    }}
    
    .cover-page h1 {{
      page-break-before: avoid;
      border-bottom: none;
      padding-bottom: 0;
      margin-top: 0;
    }}
    
    h2 {{
      font-size: 16px;
      margin-top: 25px;
      margin-bottom: 12px;
      border-left: 4px solid #c5a880;
      padding-left: 10px;
    }}
    
    h3 {{
      font-size: 14px;
      margin-top: 20px;
      margin-bottom: 10px;
      color: #2e7d32;
    }}
    
    p {{
      margin-top: 0;
      margin-bottom: 15px;
      text-align: justify;
    }}
    
    /* Math & LaTeX Styling */
    .math-eq {{
      background-color: #f9fbf9;
      padding: 15px 20px;
      border-radius: 6px;
      border-left: 4px solid #2e7d32;
      margin: 20px 0;
      page-break-inside: avoid;
      display: flex;
      justify-content: center;
      overflow-x: auto;
    }}
    
    /* Tables Styling */
    .academic-table {{
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
      font-size: 12.5px;
      page-break-inside: avoid;
    }}
    
    .academic-table th, .academic-table td {{
      border: 1px solid #dcdcdc;
      padding: 8px 12px;
      text-align: left;
    }}
    
    .academic-table th {{
      background-color: #1b5e20;
      color: #ffffff;
      font-weight: 600;
    }}
    
    .academic-table tr:nth-child(even) {{
      background-color: #f8faf8;
    }}
    
    /* Code Blocks */
    pre {{
      background-color: #f5f7f5;
      border: 1px solid #e1e4e1;
      border-radius: 6px;
      padding: 15px;
      overflow-x: auto;
      margin: 20px 0;
      page-break-inside: avoid;
    }}
    
    code {{
      font-family: 'JetBrains Mono', 'Courier New', monospace;
      font-size: 12px;
    }}
    
    p code, li code {{
      background-color: #f1f3f1;
      padding: 2px 6px;
      border-radius: 3px;
      font-size: 12px;
      color: #c0392b;
    }}
    
    /* Lists */
    ul, ol {{
      margin-top: 0;
      margin-bottom: 15px;
      padding-left: 20px;
    }}
    
    li {{
      margin-bottom: 6px;
    }}
    
    /* Highlight Alert Styling matching GitHub */
    blockquote {{
      margin: 20px 0;
      padding: 12px 20px;
      border-left: 5px solid #1b5e20;
      background-color: #f1f8e9;
      border-radius: 0 6px 6px 0;
      page-break-inside: avoid;
    }}
    
    blockquote p {{
      margin: 0;
      font-style: italic;
    }}
  </style>
</head>
<body>

  <!-- Bespoke Cover Page -->
  <div class="cover-page">
    <div class="cover-border">
      <div class="cover-header">
        <div class="cover-badge">PRECISION IRRIGATION &amp; IOT</div>
        <h1 class="cover-title">คู่มือปฏิบัติการวิศวกรรมระบบน้ำอัตโนมัติ<br>และไอโอทีเกษตรอัจฉริยะ 2568</h1>
        <div class="cover-divider"></div>
        <div class="cover-subtitle">หลักสูตรการปฏิบัติการเทคโนโลยีชลศาสตร์ เกษตรแม่นยำ และระบบควบคุมระบบอัตโนมัติในสวนทุเรียน</div>
      </div>
      
      <div class="cover-center">
        <div class="cover-target">ระดับการเรียนรู้: มัธยมศึกษาตอนต้น (STEM Integration)</div>
        <div class="stamp-container">รศ. Standard 2026</div>
      </div>
      
      <div class="cover-footer">
        <div class="cover-author">ปัญญาประดิษฐ์ไอด้า ด้านฟิสิกส์การเกษตร วิศวกรรมชลประทานแม่นยำ และ IoT</div>
        <div class="cover-org">ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล รำไพพรรณี<br>โครงการความร่วมมือทางวิชาการและงานวิจัยเชิงพื้นที่</div>
      </div>
    </div>
  </div>

  <!-- Merged Main Content -->
  <div class="content-body">
    {html_body}
  </div>

</body>
</html>
"""

    os.makedirs(os.path.dirname(OUTPUT_HTML_FILE), exist_ok=True)
    with open(OUTPUT_HTML_FILE, "w", encoding="utf-8") as f:
        f.write(html_template)
    print(f"[SUCCESS] Beautiful styled HTML written to: {OUTPUT_HTML_FILE}")

if __name__ == "__main__":
    compile_markdown_to_html()
