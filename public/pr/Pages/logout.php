<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: main.php');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header('Location: main.php');
    exit;
}

$host = '127.0.1.30';
$user = 'root';
$pass = '';
$db_name = 'Golubko';
$conn = mysqli_connect($host, $user, $pass, $db_name);

$user_id = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT email FROM users WHERE id = '$user_id'");
$user_data = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Actor - Личный кабинет</title>
    <link rel="stylesheet" href="../Style/Global/fonts.css">
    <link rel="stylesheet" href="../Style/dashboard.css">
</head>
<body class="dashboard-page">

<header class="header">
    <div class="header-logo">
        <span class="logo-title">Studio actor</span>
        <span class="logo-subtitle">Студия Актера</span>
    </div>
    <div class="header-user">
        <div class="user-info">
            <span class="user-email"><?php echo htmlspecialchars($user_data['email']); ?></span>
            <a href="?logout=1" class="logout-link">Выйти</a>
        </div>
        <div class="user-avatar">
            <img src="https://ui-avatars.com/api?name=<?php echo urlencode($user_data['email']); ?>&background=4a6cf7&color=fff" alt="Avatar">
        </div>
    </div>
</header>

<main class="main-content">
    <div class="cards-grid">
        <div class="card card-circles">
            <div class="card-content">
                <h2>Твоя жизнь — <br> твоя роль</h2>
                <p>Погружение в мир кино и театра для взрослых и детей.</p>
            </div>
            <a href="courses.php" class="btn-card">Выбрать курс</a>
        </div>

        <div class="card card-pattern">
            <div>
                <h2>Студия, где <br> рождаются звезды</h2>
                <p>Хочешь сниматься в кино? Мы знаем, что тебе нужно.</p>
            </div>
            <a href="casting.php" class="btn-card">Пройти на кастинг</a>
        </div>
    </div>
</main>

</body>
</html>
