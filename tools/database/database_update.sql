-- Admin Users Table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default Admin (username: admin, password: password)
INSERT INTO admins (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi') 
ON DUPLICATE KEY UPDATE id=id;

-- AI Knowledge Base (RAG)
CREATE TABLE IF NOT EXISTS knowledge_base (
    id INT AUTO_INCREMENT PRIMARY KEY,
    keywords TEXT NOT NULL, -- JSON array string or comma-separated
    answer_th TEXT NOT NULL,
    answer_en TEXT,
    answer_cn TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed initial KB data
INSERT INTO knowledge_base (keywords, answer_th, answer_en, answer_cn) VALUES
('["สวัสดี", "hello", "hi", "ทักทาย", "nihao"]', 
 'สวัสดีครับ! ผมคือ AI Agent ผู้ช่วยด้านนวัตกรรมเกษตร ของศูนย์ RBRU-Praneet ยินดีให้บริการครับ', 
 'Hello! I am the AI Agent of RBRU-Praneet Digital Agri-Innovation Center. How can I help you?',
 '你好！我是 RBRU-Praneet 数字农业创新中心的 AI 代理。有什么可以帮您的吗？'),
('["contact", "fa", "ที่อยู่", "location", "dizhi"]', 
 'คุณสามารถติดต่อเราได้ที่ อาคาร 36 คณะวิทยาศาสตร์และเทคโนโลยีการเกษตร มหาวิทยาลัยราชภัฏรำไพพรรณี', 
 'You can contact us at Building 36, Faculty of Science and Agricultural Technology, Rambhai Barni Rajabhat University.', 
 '您可以联系我们：Rambhai Barni Rajabhat University 科学与农业技术学院 36 号楼。');

-- Update Activities to support multi-language
ALTER TABLE activities ADD COLUMN IF NOT EXISTS title_th VARCHAR(255);
ALTER TABLE activities ADD COLUMN IF NOT EXISTS title_en VARCHAR(255);
ALTER TABLE activities ADD COLUMN IF NOT EXISTS title_cn VARCHAR(255);
ALTER TABLE activities ADD COLUMN IF NOT EXISTS description_th TEXT;
ALTER TABLE activities ADD COLUMN IF NOT EXISTS description_en TEXT;
ALTER TABLE activities ADD COLUMN IF NOT EXISTS description_cn TEXT;

-- Update existing data (migrate from title to title_th/en)
UPDATE activities SET title_th = title, title_en = title, title_cn = title WHERE title_th IS NULL;
