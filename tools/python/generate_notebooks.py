import json
import os

files = ['climate_sessions.json', 'cnn_sessions.json', 'iot_sessions.json']

for fname in files:
    # Handle executing from tools/python/ or project root
    data_path = 'data/' + fname
    if not os.path.exists(data_path) and os.path.exists('../../data/' + fname):
        data_path = '../../data/' + fname
        
    if not os.path.exists(data_path): continue
    
    with open(data_path, 'r', encoding='utf-8') as f:
        sessions = json.load(f)
        
    # Determine subfolder based on json filename
    subfolder = 'climate'
    if 'cnn' in fname:
        subfolder = 'cnn'
    elif 'iot' in fname:
        subfolder = 'iot'
        
    # Handle output path when executing from tools/python/ or root
    out_dir = f"notebooks/{subfolder}"
    if not os.path.exists('notebooks') and os.path.exists('../../notebooks'):
        out_dir = f"../../notebooks/{subfolder}"
        
    os.makedirs(out_dir, exist_ok=True)
        
    for i, s in enumerate(sessions):
        for j, ex in enumerate(s.get('examples', [])):
            notebook_content = {
                "cells": [
                    {
                        "cell_type": "markdown",
                        "metadata": {},
                        "source": [f"# {s['title']}\n", f"## {ex['title']}"]
                    },
                    {
                        "cell_type": "code",
                        "execution_count": None,
                        "metadata": {},
                        "outputs": [],
                        "source": [line + "\n" for line in ex['code'].split('\n')]
                    }
                ],
                "metadata": {
                    "kernelspec": {
                        "display_name": "Python 3",
                        "language": "python",
                        "name": "python3"
                    },
                    "language_info": {
                        "name": "python",
                        "version": "3.8"
                    }
                },
                "nbformat": 4,
                "nbformat_minor": 4
            }
            
            # File name pattern: notebooks/{subfolder}/{s['id']}_ex{j+1}.ipynb
            nb_path = f"{out_dir}/{s['id']}_ex{j+1}.ipynb"
            with open(nb_path, 'w', encoding='utf-8') as f:
                json.dump(notebook_content, f, indent=2, ensure_ascii=False)
                
print("✅ Generated all Jupyter Notebooks in organized subfolders (/notebooks/climate, /notebooks/cnn, /notebooks/iot)")
