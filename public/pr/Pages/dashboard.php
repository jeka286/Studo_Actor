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

require_once __DIR__ . '/db_helpers.php';
ensureUsersPhoneColumn($conn);

$user_id = $_SESSION['user_id'];
$stmt = mysqli_prepare($conn, 'SELECT full_name, email, phone FROM users WHERE id = ? LIMIT 1');
if (!$stmt) {
    die('Database error');
}
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $user_full_name, $user_email, $user_phone);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$user_data = [
    'full_name' => $user_full_name ?? '',
    'email' => $user_email ?? '',
    'phone' => $user_phone ?? ''
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Actor - Назад</title>
    <link rel="stylesheet" href="../Style/Global/fonts.css">
    <link rel="stylesheet" href="../Style/dashboard.css">
    <link rel="stylesheet" href="../Style/Layouts/footer.css">
    <link rel="stylesheet" href="../Style/Components/casting-modal.css">
    <link rel="stylesheet" href="../Style/Components/profile-modal.css">
</head>
<body class="dashboard-page">

<header class="header">
    <div class="header-logo">
        <span class="logo-title">Studio actor</span>
        <span class="logo-subtitle">Студия Актера</span>
    </div>
    <div class="header-user">
        <div class="user-actions">
            <button type="button" class="profile-button" data-open-profile>Личный кабинет</button>
            <a href="?logout=1" class="logout-link">Выйти</a>
        </div>
        <div class="user-avatar">
            <img src="../Style/Global/default-avatar.svg" alt="Avatar">
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
            <button type="button" class="btn-card" data-open-casting>Пройти на кастинг</button>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
<?php include 'casting_modal.php'; ?>
<?php include 'profile_modal.php'; ?>
</body>
</html>
