<?php
require_once 'db_connect.php';

// ... (Previous setup code for Admin/Activities/Team remains, just appending or keeping it) ...

// Seed Notebook Sources
if ($db_notebook->count() == 0) {
    $db_notebook->insert([
        'title' => 'ข้อมูลทั่วไปของศูนย์ (General Info)',
        'content' => 'ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล (RBRU-Praneet) ตั้งอยู่ที่อาคาร 36 คณะวิทยาศาสตร์ฯ มรภ.รำไพพรรณี มีเป้าหมายเพื่อพัฒนาทักษะ AI, IoT ให้กับเยาวชนและเกษตรกร',
        'type' => 'note',
        'tags' => ['general', 'location', 'rbru']
    ]);
    $db_notebook->insert([
        'title' => 'หลักสูตร Python for Data Science',
        'content' => 'หลักสูตรนี้เน้นการสอนภาษา Python พื้นฐาน จนถึงการใช้ Library เช่น Pandas, Matplotlib ในการวิเคราะห์ข้อมูลสภาพอากาศ เหมาะสำหรับผู้เริ่มต้น',
        'type' => 'note',
        'tags' => ['course', 'python', 'data']
    ]);
    $db_notebook->insert([
        'title' => 'การจัดการโรคพืชด้วย AI',
        'content' => 'เราใช้เทคโนโลยี Deep Learning (CNN) ในการจำแนกโรคพืช โดยใช้ Image Processing ตรวจจับลักษณะผิดปกติบนใบพืช เช่น จุดเหลือง หรือรอยไหม้',
        'type' => 'note',
        'tags' => ['ai', 'disease', 'tech']
    ]);
    echo "Notebook sources seeded.\n";
}
?>
