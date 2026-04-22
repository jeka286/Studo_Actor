<?php
session_start();

$host = '127.0.1.30';
$user = 'root';
$pass = '';
$db_name = 'Golubko';

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    die('Ошибка подключения: ' . mysqli_connect_error());
}

$query = "SELECT * FROM Courses ORDER BY id ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Ошибка запроса: ' . mysqli_error($conn));
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

<div class="top-bar courses-top-bar">
    <div class="brand-info">
        <h1>Курсы</h1>
        <p>Студия Актера</p>
    </div>
    <div class="courses-toolbar">
        <input type="search" id="courseSearch" class="course-search" placeholder="Поиск">
        <a href="dashboard.php" class="close-icon">×</a>
    </div>
</div>

<div class="courses-list" id="coursesList">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($course = mysqli_fetch_assoc($result)): ?>
            <?php
            $courseText = mb_strtolower(($course['Title'] ?? '') . ' ' . ($course['Description'] ?? ''), 'UTF-8');
            ?>
            <div class="course-item" data-course-item data-course-title="<?php echo htmlspecialchars($courseText, ENT_QUOTES, 'UTF-8'); ?>">
                <div class="course-image-box">
                    <?php if (!empty($course['img'])): ?>
                        <?php $imageData = base64_encode($course['img']); ?>
                        <img src="data:image/jpeg;base64,<?php echo $imageData; ?>" alt="<?php echo htmlspecialchars($course['Title']); ?>">
                    <?php else: ?>
                        <div class="no-image">Нет фото</div>
                    <?php endif; ?>
                </div>
                <a class="course-info course-link" href="course.php?id=<?php echo (int) $course['id']; ?>">
                    <h3><?php echo htmlspecialchars($course['Title']); ?></h3>
                    <p><?php echo htmlspecialchars($course['Description']); ?></p>
                    <span class="course-link-hint">Подробнее</span>
                </a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="courses-empty">
            <p>Курсы пока не добавлены</p>
            <p class="courses-empty-hint">Добавьте данные в таблицу Courses в БД</p>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('courseSearch');
    const courseItems = document.querySelectorAll('[data-course-item]');

    if (!searchInput) return;

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim().toLowerCase();

        courseItems.forEach(function (item) {
            const text = item.getAttribute('data-course-title') || '';
            item.style.display = text.includes(query) ? 'flex' : 'none';
        });
    });
});
</script>

</body>
</html>
