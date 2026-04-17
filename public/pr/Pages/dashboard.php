<?php
session_start();

// Обработка выхода
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: main.php');
    exit;
}

// Проверка: если пользователь не вошел, отправляем его на главную
if (!isset($_SESSION['user_id'])) {
    header('Location: main.php');
    exit;
}

// Подключение к БД
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
    <title>Studio Actor - Назад</title>
    <link rel="stylesheet" href="../Style/General.css">
    <script src="../Scripts/footer.js"></script>
    <link rel="stylesheet" href="../Style/Layouts/footer.css">

    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 0 40px; background-color: #fff; }
        .header { display: flex; justify-content: space-between; align-items: center; padding: 20px 0; margin-bottom: 40px; }
        .logo-title { font-weight: bold; font-size: 24px; color: #4a6cf7; display: block; }
        .logo-subtitle { font-size: 12px; color: #999; }
        .header-user { display: flex; align-items: center; gap: 15px; }
        .user-info { text-align: right; }
        .user-email { display: block; font-size: 14px; font-weight: bold; color: #333; }
        .logout-link { font-size: 12px; color: #ff4d4d; text-decoration: none; }
        .logout-link:hover { text-decoration: underline; }
        .user-avatar img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; background: #eee; }
        .cards-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 80px; }
        .card { border-radius: 25px; padding: 45px; min-height: 350px; display: flex; flex-direction: column; justify-content: space-between; color: white; position: relative; overflow: hidden; }
        .card-circles { background-color: #5d9eff; background-image: radial-gradient(circle at 100% 100%, rgba(243, 243, 243, 0.1) 0%, transparent 40%); }
        .card-pattern { background-color: #3661eb; background-image: linear-gradient(135deg, rgba(255,255,255,0.05) 25%, transparent 25%), linear-gradient(225deg, rgba(255,255,255,0.05) 25%, transparent 25%); background-size: 40px 40px; }
        .btn-card { 
            align-self: flex-start; 
            padding: 14px 35px; 
            border-radius: 12px; 
            border: none; 
            color: white; 
            font-weight: bold; 
            cursor: pointer; 
            transition: 0.3s; 
            background: #4a6cf7;
            text-decoration: none;
            display: inline-block;
        }
        .btn-card:hover { background: #3a5ce0; }
        .footer { display: flex; justify-content: space-between; padding: 60px 0; border-top: 1px solid #f0f0f0; }
    </style>
</head>
<body>

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
<a href="casting.php" class="btn-card">Пройти на кастинг</a>
<main class="main-content">
    <div class="cards-grid">
        <div class="card card-circles">
            <div>
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
<?php include 'footer.php'; ?>
</html>