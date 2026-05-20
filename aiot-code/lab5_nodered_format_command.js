// Function Node Code (JavaScript)
// โค้ดนี้ทำหน้าที่รับค่า Payload จากปุ่ม (msg.payload)
// และจัดรูปแบบให้เป็นข้อความที่พร้อมส่งออก (msg.payload)

// ตัวแปร 'msg' คือ Message Object ที่ถูกส่งมาจากโหนดก่อนหน้า
// ในกรณีนี้ msg.payload คือ "1" หรือ "0" ที่มาจากปุ่ม

// 1. ตรวจสอบว่าค่าที่เข้ามาเป็นตัวเลขหรือไม่
let commandValue = msg.payload;

// 2. ตรวจสอบความถูกต้องของค่า (Optional: เพิ่มการตรวจสอบ)
if (typeof commandValue !== 'string' || (commandValue !== "1" && commandValue !== "0")) {
    // ถ้าค่าไม่ถูกต้อง ให้ส่งค่าว่างออกไปเพื่อป้องกันข้อผิดพลาด
    return null; 
}

// 3. กำหนดค่า Payload ใหม่ให้เป็นค่าที่เราต้องการส่งออก
// ในที่นี้เราต้องการส่งค่า "1" หรือ "0" เป็น String
msg.payload = commandValue;

// 4. ส่ง Message Object ที่ถูกปรับปรุงแล้วออกไป
return msg;
