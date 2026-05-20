<?php
session_start();
// Language Handler
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'th';
if (!in_array($lang_code, ['th', 'en', 'cn'])) {
    $lang_code = 'th';
}
require_once "languages/{$lang_code}.php";
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIDA xAI Center — RBRU-Praneet | ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม</title>
    <meta name="description"
        content="AIDA xAI Center — ศูนย์พัฒนานวัตกรรมดิจิทัล-ปัญญาประดิษฐ์เพื่อการเกษตรและสิ่งแวดล้อม - พัฒนาทักษะด้าน AI, IoT และ Data Science เพื่อเกษตรสมัยใหม่">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Thai:wght@300;400;500;600;700;800&family=Orbitron:wght@400;500;600;700;800;900&family=Rajdhani:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/main.css?v=2.0">
</head>

<body>
    <?php include 'components/navigation.php'; ?>
    
    <?php include 'components/hero.php'; ?>
    
    <?php include 'components/about.php'; ?>
    
    <?php include 'components/activities.php'; ?>
    
    <?php include 'components/registration.php'; ?>
    
    <?php include 'components/ai_assistant.php'; ?>
    
    
    <?php include 'components/responsible1.php'; ?>
    
    <?php include 'components/cta.php'; ?>
    
    <?php include 'components/footer.php'; ?>

    <script type="module" src="js/main.js"></script>
    <script src="js/ai_agent_widget.js?v=AIDAv2"></script>
</body>

</html>
