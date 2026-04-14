<?php
session_start();

// Подключение к БД
$host = '127.0.1.30'; 
$user = 'root';      
$pass = '';          
$db_name = 'Golubko'; 

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Запрос всех курсов из таблицы Courses
$query = "SELECT * FROM Courses ORDER BY id ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Ошибка запроса: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Курсы | Студия Актера</title>
    
    <link rel="stylesheet" href="../Style/Global/fonts.css">
    <link rel="stylesheet" href="../Style/Layouts/header.css">
    <link rel="stylesheet" href="../Style/Components/courses.css">
</head>
<body>

<div class="top-bar">
    <div class="brand-info">
        <h1>Курсы</h1>
        <p>Студия Актера</p>
    </div>
    <a href="dashboard.php" class="close-icon">✕</a>
</div>

<div class="courses-list">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($course = mysqli_fetch_assoc($result)): ?>
            <div class="course-item">
                <div class="course-image-box">
                    <?php 
                    // Проверяем, есть ли изображение в BLOB поле
                    if (!empty($course['img'])): 
                        // Преобразуем BLOB в base64 для отображения
                        $imageData = base64_encode($course['img']);
                        $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                    ?>
                        <img src="<?php echo $imageSrc; ?>" alt="<?php echo htmlspecialchars($course['Title']); ?>">
                    <?php else: ?>
                        <div class="no-image">Нет фото</div>
                    <?php endif; ?>
                </div>
                <div class="course-info">
                    <h3><?php echo htmlspecialchars($course['Title']); ?></h3>
                    <p><?php echo htmlspecialchars($course['Description']); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div style="text-align: center; padding: 50px; color: #888;">
            <p>Курсы пока не добавлены</p>
            <p style="font-size: 12px; margin-top: 10px;">Добавьте данные в таблицу Courses в БД</p>
        </div>
    <?php endif; ?>
</div>


</body>
</html>