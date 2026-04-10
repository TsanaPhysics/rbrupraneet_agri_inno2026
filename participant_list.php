<?php
// participant_list.php - Public page to list registered participants and download certificates
require_once __DIR__ . '/db_connect.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$whereClause = '';
$params = [];

if ($search) {
    $whereClause = "WHERE s.name LIKE :search OR s.school LIKE :search";
    $params[':search'] = "%$search%";
}

try {
    $sql = "SELECT r.id, s.name, s.school, a.title, r.completed 
            FROM registrations r 
            JOIN students s ON r.student_id = s.id 
            JOIN activities a ON r.activity_id = a.id 
            $whereClause
            ORDER BY r.registration_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $registrations = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายชื่อผู้เข้าร่วมกิจกรรม | RBRU-Praneet Digital Agri-Innovation Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Thai:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <style>
        body {
            background-color: var(--bg-secondary);
            font-family: 'Noto Sans Thai', 'Inter', sans-serif;
            color: var(--text-primary);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            padding-top: 2rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-shadow: 0 0 20px rgba(74, 144, 226, 0.3);
        }

        .page-subtitle {
            font-size: 1.1rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        .search-box {
            background: white;
            padding: 2rem;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            align-items: center;
            justify-content: center;
        }

        .search-input {
            padding: 0.8rem 1.5rem;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-full);
            width: 100%;
            max-width: 400px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.1);
        }

        .search-btn {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: var(--radius-full);
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .participants-table {
            width: 100%;
            background: white;
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border-collapse: collapse;
        }

        .participants-table th,
        .participants-table td {
            padding: 1.2rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .participants-table th {
            background: var(--bg-secondary);
            font-weight: 700;
            color: var(--primary-dark);
        }

        .participants-table tr:hover {
            background-color: rgba(74, 144, 226, 0.05);
        }

        .status-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: var(--radius-full);
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .btn-certificate {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--secondary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .btn-certificate:hover {
            background: var(--secondary-dark);
            transform: translateY(-1px);
        }

        .empty-state {
            text-align: center;
            padding: 4rem;
            color: var(--text-secondary);
        }
        
    </style>
</head>

<body>
    <?php include 'components/navigation.php'; ?>

    <div class="container" style="margin-top: 80px;">
        <div class="header">
            <h1 class="page-title">รายชื่อผู้เข้าร่วมโครงการ</h1>
            <p class="page-subtitle">ตรวจสอบรายชื่อและสถานะการเข้าร่วมกิจกรรม พร้อมดาวน์โหลดเกียรติบัตรสำหรับผู้ที่ผ่านการอบรม</p>
        </div>

        <div class="search-box">
            <form method="GET" style="display: flex; gap: 1rem; width: 100%; justify-content: center;">
                <input type="text" name="search" class="search-input" placeholder="ค้นหาด้วยชื่อ หรือโรงเรียน..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="search-btn">ค้นหา</button>
            </form>
        </div>

        <?php if (empty($registrations)): ?>
            <div class="participants-table">
                <div class="empty-state">
                    <h3>ไม่พบข้อมูลผู้เข้าร่วม</h3>
                    <p>ลองค้นหาด้วยคำอื่น หรือยังไม่มีการลงทะเบียน</p>
                </div>
            </div>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table class="participants-table">
                    <thead>
                        <tr>
                            <th>ชื่อ-นามสกุล</th>
                            <th>โรงเรียน</th>
                            <th>กิจกรรม</th>
                            <th>สถานะ</th>
                            <th>เกียรติบัตร</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registrations as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['school']); ?></td>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td>
                                    <?php if ($row['completed']): ?>
                                        <span class="status-badge status-completed">ผ่านการอบรม</span>
                                    <?php else: ?>
                                        <span class="status-badge status-pending">รอการตรวจสอบ</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['completed']): ?>
                                <div class="btn-group" role="group">
                                    <a href="view_certificate.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i> ดูตัวอย่าง
                                    </a>
                                    <a href="generate_certificate.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success">
                                        <i class="bi bi-download"></i> ดาวน์โหลด
                                    </a>
                                </div>
                                    <?php else: ?>
                                        <span style="color: var(--text-light); font-size: 0.9rem;">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 3rem;">
            <a href="index.php" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">&larr; กลับสู่หน้าหลัก</a>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
</body>

</html>
