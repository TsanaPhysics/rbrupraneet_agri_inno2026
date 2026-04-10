# RBRU-Praneet Digital Agri-Innovation Center

## โครงสร้างโปรเจ็กต์

```
rbru-agri-innovation/
├── index.php                  # ไฟล์หลักที่รวม components
├── index.html                 # ไฟล์เดิม (สำรอง)
├── styles.css                 # ไฟล์เดิม (สำรอง)
├── script.js                  # ไฟล์เดิม (สำรอง)
├── components/                # Components แยกตาม sections
│   ├── navigation.php        # Navigation bar
│   ├── hero.php              # Hero section + animated background
│   ├── about.php             # About section
│   ├── activities.php        # Activities section (4 cards)
│   ├── cta.php               # Call-to-action section
│   └── footer.php            # Footer section
├── css/                      # Stylesheets แบบแยกไฟล์
│   ├── main.css             # Import ทุกไฟล์
│   ├── base.css             # Variables, reset, base styles
│   ├── components.css       # Reusable components
│   └── sections.css         # Section-specific styles
├── js/                       # JavaScript modules
│   ├── main.js              # Main entry point
│   ├── navigation.js        # Navigation functionality
│   └── activities.js        # Activities & animations
└── assets/                   # Static assets
    └── images/              
        ├── hero/            # Hero images
        └── activities/      # Activity images
```

## การใช้งาน

### ติดตั้งและรัน

1. **ใช้กับ XAMPP:**
   - คัดลอกโฟลเดอร์นี้ไปที่ `/Applications/XAMPP/xamppfiles/htdocs/`
   - เปิด XAMPP และ start Apache
   - เข้าถึงที่ `http://localhost/rbru-agri-innovation/`

2. **ใช้กับ PHP Built-in Server:**
   ```bash
   cd /path/to/rbru-agri-innovation
   php -S localhost:8000
   ```
   - เข้าถึงที่ `http://localhost:8000/`

### การพัฒนาต่อ

- **แก้ไข HTML/Content:** แก้ไฟล์ใน `components/`
- **แก้ไข CSS:** แก้ไฟล์ใน `css/`
- **แก้ไข JavaScript:** แก้ไฟล์ใน `js/`
- **เพิ่มรูปภาพ:** วางไฟล์ใน `assets/images/`

## คุณสมบัติ

- ✅ โครงสร้างแบบ modular ง่ายต่อการดูแล
- ✅ แยก components ชัดเจน
- ✅ CSS และ JS แบ่งตามหน้าที่
- ✅ ใช้ PHP includes สำหรับ component loading
- ✅ Responsive design
- ✅ Modern animations and interactions

## หมายเหตุ

ไฟล์เดิม (`index.html`, `styles.css`, `script.js`) ยังคงอยู่เป็นการสำรองข้อมูล คุณสามารถลบออกได้เมื่อแน่ใจว่าระบบใหม่ทำงานได้อย่างถูกต้อง
# rbrupraneet_agri_inno2026
