import os
import re

def escape_latex_outside_math(text):
    """Escapes LaTeX special characters outside inline math $...$ pairs."""
    # Split by inline math $ to protect math content
    parts = text.split('$')
    for i in range(len(parts)):
        if i % 2 == 0:  # Outside math
            t = parts[i]
            # Handle escapes. Note: backslash escape is tricky, but usually we don't have stray backslashes in markdown text.
            # In markdown, backslashes are mostly used in math, which is already split out.
            t = t.replace('&', '\\&')
            t = t.replace('%', '\\%')
            t = t.replace('_', '\\_')
            t = t.replace('#', '\\#')
            t = t.replace('{', '\\{')
            t = t.replace('}', '\\}')
            # Convert basic markdown formatting like inline code
            # `code` -> \texttt{code}
            t = re.sub(r'`([^`\n]+)`', r'\\texttt{\1}', t)
            # **bold** -> \textbf{bold}
            t = re.sub(r'\*\*([^*]+)\*\*', r'\\textbf{\1}', t)
            # *italic* -> \textit{italic}
            t = re.sub(r'\*([^*]+)\*', r'\\textit{\1}', t)
            parts[i] = t
    return '$'.join(parts)

def parse_markdown_to_latex(md_content):
    lines = md_content.split('\n')
    latex_out = []
    
    in_code = False
    code_lines = []
    code_lang = ""
    
    in_quote = False
    quote_type = None
    quote_lines = []
    
    in_table = False
    table_headers = []
    table_alignments = []
    table_rows = []
    
    in_list = False
    list_type = None # 'itemize' or 'enumerate'
    
    i = 0
    while i < len(lines):
        line = lines[i]
        line_stripped = line.strip()
        
        # ----------------------------------------------------
        # 1. Parse Code Blocks
        # ----------------------------------------------------
        if line_stripped.startswith('```'):
            if not in_code:
                in_code = True
                code_lang = line_stripped[3:].strip().lower()
                if not code_lang:
                    code_lang = 'text'
                code_lines = []
                i += 1
                continue
            else:
                # End of code block, render it!
                lang_mapping = {
                    'python': 'Python',
                    'py': 'Python',
                    'cpp': 'C++',
                    'c++': 'C++',
                    'arduino': 'C++',
                    'json': 'JSON',
                    'html': 'HTML',
                    'css': 'HTML'
                }
                tex_lang = lang_mapping.get(code_lang, 'TeX')
                
                latex_out.append(r'\begin{lstlisting}[language=' + tex_lang + ']')
                latex_out.append('\n'.join(code_lines))
                latex_out.append(r'\end{lstlisting}')
                latex_out.append('')
                
                in_code = False
                i += 1
                continue
                
        if in_code:
            code_lines.append(line) # Keep exact indentation
            i += 1
            continue
            
        # ----------------------------------------------------
        # 2. Parse Callouts (Blockquotes starting with >)
        # ----------------------------------------------------
        if line_stripped.startswith('>'):
            in_quote = True
            clean_line = re.sub(r'^>\s*', '', line_stripped)
            if '[!TIP]' in clean_line:
                quote_type = 'TIP'
                clean_line = clean_line.replace('[!TIP]', '').strip()
            elif '[!IMPORTANT]' in clean_line:
                quote_type = 'IMPORTANT'
                clean_line = clean_line.replace('[!IMPORTANT]', '').strip()
            
            if clean_line:
                quote_lines.append(clean_line)
            i += 1
            continue
        elif in_quote and not line_stripped.startswith('>'):
            # End of quote box, render it!
            box_env = 'tipbox' if quote_type == 'TIP' else 'importantbox'
            title = 'เคล็ดลับเพิ่มเติม (Tip)' if quote_type == 'TIP' else 'ข้อควรระวัง (Important)'
            
            latex_out.append(f'\\begin{{{box_env}}}{{{title}}}')
            for q_line in quote_lines:
                latex_out.append(escape_latex_outside_math(q_line) + r' \\')
            latex_out.append(f'\\end{{{box_env}}}')
            latex_out.append('')
            
            in_quote = False
            quote_type = None
            quote_lines = []
            
        # ----------------------------------------------------
        # 3. Parse Tables
        # ----------------------------------------------------
        if line_stripped.startswith('|'):
            if not in_table:
                in_table = True
                table_headers = [c.strip() for c in line_stripped.split('|')[1:-1]]
                table_rows = []
                
                # Check alignments in the next line
                i += 1
                sep_line = lines[i].strip()
                aligns = [c.strip() for c in sep_line.split('|')[1:-1]]
                table_alignments = []
                for a in aligns:
                    if a.startswith(':') and a.endswith(':'):
                        table_alignments.append('C')
                    elif a.endswith(':'):
                        table_alignments.append('R')
                    else:
                        table_alignments.append('L')
                i += 1
                continue
            else:
                row_cols = [c.strip() for c in line_stripped.split('|')[1:-1]]
                table_rows.append(row_cols)
                i += 1
                continue
        elif in_table and not line_stripped.startswith('|'):
            # End of table, render it!
            col_spec = ' '.join(table_alignments)
            latex_out.append(r'\begin{table}[htbp]')
            latex_out.append(r'\centering')
            latex_out.append(r'\begin{tabularx}{\textwidth}{' + col_spec + '}')
            latex_out.append(r'\toprule')
            
            # Write Headers
            escaped_headers = [escape_latex_outside_math(h) for h in table_headers]
            latex_out.append(' & '.join(escaped_headers) + r' \\')
            latex_out.append(r'\midrule')
            
            # Write Rows
            for row in table_rows:
                # Handle cell contents
                escaped_cells = [escape_latex_outside_math(c) for c in row]
                latex_out.append(' & '.join(escaped_cells) + r' \\')
                
            latex_out.append(r'\bottomrule')
            latex_out.append(r'\end{tabularx}')
            latex_out.append(r'\end{table}')
            latex_out.append('')
            
            in_table = False
            table_headers = []
            table_alignments = []
            table_rows = []
            
        # ----------------------------------------------------
        # 4. Parse Lists (Bullet Points and Enumerations)
        # ----------------------------------------------------
        is_bullet = line_stripped.startswith('* ') or line_stripped.startswith('- ')
        is_enum = re.match(r'^\d+\.\s', line_stripped) is not None
        
        if is_bullet or is_enum:
            current_type = 'itemize' if is_bullet else 'enumerate'
            if not in_list:
                in_list = True
                list_type = current_type
                latex_out.append(f'\\begin{{{list_type}}}')
            
            # Extract content
            if is_bullet:
                item_content = line_stripped[2:].strip()
            else:
                item_content = re.sub(r'^\d+\.\s*', '', line_stripped).strip()
                
            latex_out.append(f'  \\item {escape_latex_outside_math(item_content)}')
            i += 1
            continue
        elif in_list and not (is_bullet or is_enum) and line_stripped != "":
            # Continue the current list item
            latex_out.append(f'  {escape_latex_outside_math(line_stripped)}')
            i += 1
            continue
        elif in_list and line_stripped == "":
            # End of list
            latex_out.append(f'\\end{{{list_type}}}')
            latex_out.append('')
            in_list = False
            list_type = None
            
        # ----------------------------------------------------
        # 5. Parse Headings
        # ----------------------------------------------------
        if line_stripped.startswith('#'):
            level = len(line_stripped) - len(line_stripped.lstrip('#'))
            title_text = line_stripped[level:].strip()
            escaped_title = escape_latex_outside_math(title_text)
            
            if level == 1:
                # Chapter level
                # For book/report class, chapters are separated by \chapter
                # Let's check if it's the preface or references or standard chapter
                if 'คำนำ' in title_text or 'สารบัญ' in title_text:
                    latex_out.append(f'\\chapter*{{{escaped_title}}}')
                    latex_out.append(f'\\addcontentsline{{toc}}{{chapter}}{{{escaped_title}}}')
                elif 'บรรณานุกรม' in title_text:
                    latex_out.append(f'\\chapter*{{{escaped_title}}}')
                    latex_out.append(f'\\addcontentsline{{toc}}{{chapter}}{{{escaped_title}}}')
                else:
                    latex_out.append(f'\\chapter{{{escaped_title}}}')
            elif level == 2:
                # Section
                if 'ภาคผนวก' in title_text:
                    latex_out.append(f'\\chapter*{{{escaped_title}}}')
                    latex_out.append(f'\\addcontentsline{{toc}}{{chapter}}{{{escaped_title}}}')
                else:
                    latex_out.append(f'\\section{{{escaped_title}}}')
            elif level == 3:
                latex_out.append(f'\\subsection{{{escaped_title}}}')
            elif level == 4:
                latex_out.append(f'\\subsubsection{{{escaped_title}}}')
            else:
                latex_out.append(f'\\paragraph{{{escaped_title}}}')
                
            latex_out.append('')
            i += 1
            continue
            
        # ----------------------------------------------------
        # 6. Parse Empty lines and plain paragraphs
        # ----------------------------------------------------
        if line_stripped == "":
            latex_out.append('')
            i += 1
            continue
            
        # Let's handle math blocks explicitly to preserve display equations
        if line_stripped.startswith('$$') and line_stripped.endswith('$$') and len(line_stripped) > 2:
            latex_out.append(line_stripped)
            latex_out.append('')
            i += 1
            continue
            
        # Standard paragraph
        latex_out.append(escape_latex_outside_math(line_stripped))
        i += 1
        
    # Close any open environments
    if in_code:
        latex_out.append(r'\end{lstlisting}')
    if in_quote:
        latex_out.append(f'\\end{{{quote_type}}}')
    if in_table:
        latex_out.append(r'\end{tabularx}')
        latex_out.append(r'\end{table}')
    if in_list:
        latex_out.append(f'\\end{{{list_type}}}')
        
    return '\n'.join(latex_out)

def build_latex_document():
    md_path = "/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/docs/agri_innovation_handbook_3days.md"
    tex_path = "/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/docs/agri_innovation_handbook_3days.tex"
    
    print(f"Reading consolidated Markdown from: {md_path}")
    if not os.path.exists(md_path):
        print(f"[ERROR] Markdown file not found at: {md_path}")
        return
        
    with open(md_path, 'r', encoding='utf-8') as f:
        md_content = f.read()
        
    # Convert Markdown body
    latex_body = parse_markdown_to_latex(md_content)
    
    # Elegant Preamble for Thai XeLaTeX
    latex_document = r"""\documentclass[11pt,a4paper,openany]{report}
\usepackage[a4paper, top=2.5cm, bottom=2.5cm, left=3cm, right=2.5cm]{geometry}
\usepackage{fontspec}
\usepackage{xunicode}
\usepackage{xltxtra}
\usepackage{amsmath}
\usepackage{amssymb}
\usepackage{amsfonts}
\usepackage{booktabs}
\usepackage{tabularx}
\usepackage{array}
\usepackage{listings}
\usepackage{xcolor}
\usepackage{tcolorbox}
\usepackage{graphicx}
\usepackage{fancyhdr}
\usepackage{tocloft}

% Thai Word Break settings for XeLaTeX
\XeTeXlinebreaklocale "th"
\XeTeXlinebreakskip = 0pt plus 1pt

% Primary Font Setup (Using system-installed TH Sarabun New)
\setmainfont[
  Path = /Users/chewathassana/Library/Fonts/,
  Scale = 1.45,
  Extension = .ttf,
  BoldFeatures = {FakeBold=3.5},
  ItalicFeatures = {FakeSlant=0.2},
  BoldItalicFeatures = {FakeBold=3.5, FakeSlant=0.2}
]{THSarabunNew}


\setmonofont[Scale=0.9]{Courier New}

% Column alignments for tabularx
\newcolumntype{L}{>{\raggedright\arraybackslash}X}
\newcolumntype{C}{>{\centering\arraybackslash}X}
\newcolumntype{R}{>{\raggedleft\arraybackslash}X}

% Code block styling (Listings)
\definecolor{codebg}{rgb}{0.96,0.96,0.96}
\definecolor{primary}{rgb}{0.0, 0.34, 0.57} % Deep Blue
\definecolor{secondary}{rgb}{0.0, 0.5, 0.5}  % Teal

\lstset{
  backgroundcolor=\color{codebg},
  basicstyle=\ttfamily\small,
  breaklines=true,
  captionpos=b,
  commentstyle=\color{gray}\itshape,
  frame=leftline,
  framerule=2.5pt,
  rulecolor=\color{primary},
  keywordstyle=\color{primary}\bfseries,
  stringstyle=\color{secondary},
  showstringspaces=false,
  xleftmargin=10pt,
  framexleftmargin=5pt
}

% Callout environments using tcolorbox
\tcbuselibrary{most}
\newtcolorbox{tipbox}[1]{
  colback=green!5!white,
  colframe=green!60!black,
  fonttitle=\bfseries,
  title={#1},
  enhanced,
  attach boxed title to top left={yshift=-2mm,xshift=2mm},
  boxed title style={colback=green!60!black},
  before skip=10pt,
  after skip=10pt
}

\newtcolorbox{importantbox}[1]{
  colback=red!5!white,
  colframe=red!60!black,
  fonttitle=\bfseries,
  title={#1},
  enhanced,
  attach boxed title to top left={yshift=-2mm,xshift=2mm},
  boxed title style={colback=red!60!black},
  before skip=10pt,
  after skip=10pt
}

% Header and Footer Styling
\pagestyle{fancy}
\fancyhf{}
\fancyhead[L]{\small คู่มือนวัตกรเกษตรดิจิทัลรุ่นเยาว์ (3 วัน)}
\fancyhead[R]{\small คณะวิทยาศาสตร์และเทคโนโลยี มรภ.รำไพพรรณี}
\fancyfoot[C]{\thepage}
\renewcommand{\headrulewidth}{0.4pt}

% Title / Cover Page Styling
\begin{document}

\begin{titlepage}
    \centering
    \vspace*{2cm}
    {\large\bfseries คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏรำไพพรรณี\par}
    \vspace{2.5cm}
    {\Huge\bfseries คู่มือนวัตกรเกษตรดิจิทัลรุ่นเยาว์\par}
    \vspace{0.5cm}
    {\Large\bfseries การบูรณาการปัญญาประดิษฐ์และอินเทอร์เน็ตของสรรพสิ่งในแปลงเกษตรแม่นยำ\par}
    \vspace{2.5cm}
    {\large\bfseries ผู้เขียน/วิทยากรบรรยายหลัก:\par}
    \vspace{0.3cm}
    {\Large\bfseries รศ.ดร. ชีวะ ทัศนา และ ผศ.อรรถกร คำฉัตร\par}
    \vfill
    {\large โครงการศูนย์พัฒนานวัตกรรมเกษตรดิจิทัลรำไพพรรณี ประณีตวิทยาคม\par}
    {\large สนับสนุนโดย ยุทธศาสตร์การพัฒนาการเกษตรแม่นยำอัจฉริยะ พ.ศ. 2569\par}
\end{titlepage}

\tableofcontents
\newpage

""" + latex_body + r"""
\end{document}
"""

    print(f"Writing beautiful LaTeX document to: {tex_path}")
    with open(tex_path, 'w', encoding='utf-8') as f:
        f.write(latex_document)
    print("[SUCCESS] LaTeX conversion finished.")

if __name__ == "__main__":
    build_latex_document()
