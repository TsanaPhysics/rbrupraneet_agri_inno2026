import re
import os

files_to_update = ['manual-pocketbook.php', 'manual-cnn-pocketbook.php', 'manual-iot-pocketbook.php']

new_css = """        @media print {
            @page {
                size: A4;
                margin: 0;
            }
            body {
                background: white !important;
                color: black !important;
                font-size: 11pt !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .pocketbook {
                margin: 0;
                box-shadow: none;
                max-width: none;
                width: 100%;
            }
            .page {
                page-break-after: always;
                padding: 1.5cm 2cm 1.5cm 2.5cm !important;
                min-height: auto;
                background: white !important;
                border: none !important;
            }
            h2.mag-title {
                font-size: 1.6rem !important;
                margin-top: 1rem !important;
                margin-bottom: 1rem !important;
                color: black !important;
            }
            .topic-header-box {
                padding: 1.5rem !important;
                margin-bottom: 2rem !important;
            }
            .topic-header-box h2 {
                font-size: 1.8rem !important;
            }
            .code-block {
                font-size: 10pt !important;
                padding: 1rem !important;
                border-left: 3px solid var(--accent) !important;
            }
            .magazine-columns {
                column-gap: 2rem !important;
            }
            p {
                margin-bottom: 0.8rem !important;
                line-height: 1.5 !important;
            }
            .dropcap::first-letter {
                font-size: 3.5rem !important;
                padding-right: 8px !important;
            }
            /* Hide non-print elements */
            .btn-print {
                display: none !important;
            }
            /* Avoid page breaks inside important info blocks */
            .tech-insight, .code-block, .topic-header-box {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }"""

for filename in files_to_update:
    if os.path.exists(filename):
        with open(filename, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Regex to match the old @media print { ... } completely, safely
        # We will split at "@media print {" and look for the next "        .btn-print {"
        
        start_idx = content.find("@media print {")
        end_idx = content.find(".btn-print {", start_idx)
        
        if start_idx != -1 and end_idx != -1:
            # We want to replace everything from start_idx to just before ".btn-print {"
            new_content = content[:start_idx] + new_css + "\n\n        " + content[end_idx:]
            
            with open(filename, 'w', encoding='utf-8') as f:
                f.write(new_content)
            print(f"✅ Updated print CSS in {filename}")
        else:
            print(f"⚠️ Could not find print block in {filename}")
