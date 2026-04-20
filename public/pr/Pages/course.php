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

mysqli_set_charset($conn, 'utf8mb4');

function ensureCourseTasksTable(mysqli $conn): void
{
    $createSql = "
        CREATE TABLE IF NOT EXISTS course_tasks (
            id int(11) NOT NULL AUTO_INCREMENT,
            course_id int(11) NOT NULL,
            task_order tinyint(4) NOT NULL DEFAULT 1,
            title varchar(255) NOT NULL,
            body text NOT NULL,
            goal varchar(255) NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id),
            KEY idx_course_tasks_course_order (course_id, task_order)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";

    if (!mysqli_query($conn, $createSql)) {
        die('Не удалось подготовить таблицу заданий');
    }
}

function seedCourseTasks(mysqli $conn): void
{
    $countResult = mysqli_query($conn, 'SELECT COUNT(*) AS cnt FROM course_tasks');
    if (!$countResult) {
        return;
    }

    $countRow = mysqli_fetch_assoc($countResult);
    mysqli_free_result($countResult);

    if ((int)($countRow['cnt'] ?? 0) > 0) {
        return;
    }

    $tasksByTitle = [
        'Пластика и движение' => [
            [
                'title' => '1 задание (зеркало)',
                'body' => "Встань перед партнёром (или зеркалом).\nПовторяй движения максимально точно, как отражение.\nЗатем поменяйтесь ролями.",
                'goal' => 'Цель: контроль тела и внимание к деталям',
            ],
            [
                'title' => '2 задание (Замедленное действие)',
                'body' => "Выполни обычное действие (идти, взять предмет) в 10 раз медленнее.\nСледи за каждым движением.",
                'goal' => 'Цель: осознанность и пластика',
            ],
            [
                'title' => '3 задание (Животное внутри)',
                'body' => "Выбери животное и передай его характер через тело.\nБез слов, только движение.",
                'goal' => 'Цель: раскрепощение и выразительность',
            ],
        ],
        'Полная концентрация' => [
            [
                'title' => 'Точка фокуса',
                'body' => "Смотри на один предмет 2–3 минуты.\nНе отвлекайся на мысли.",
                'goal' => 'Цель: удержание внимания.',
            ],
            [
                'title' => 'Счёт с помехами',
                'body' => "Считай от 1 до 30.\nКаждый раз, когда слышишь звук — начинай заново.",
                'goal' => 'Цель: концентрация в стрессе.',
            ],
            [
                'title' => 'Здесь и сейчас',
                'body' => "Описывай вслух всё, что происходит вокруг (звуки, ощущения).",
                'goal' => 'Цель: присутствие в моменте.',
            ],
        ],
        'Четкая дикция' => [
            [
                'title' => 'Скороговорки с карандашом',
                'body' => "Зажми карандаш между зубами и проговаривай текст.\nЗатем повтори без него.",
                'goal' => 'Цель: улучшение артикуляции.',
            ],
            [
                'title' => 'Гласные на максимум',
                'body' => "Произноси слова, сильно растягивая гласные.\nНапример: “мааамааа”.",
                'goal' => 'Цель: чёткость речи.',
            ],
            [
                'title' => 'Чтение с эмоцией',
                'body' => "Прочитай один текст с разными эмоциями (злость, радость, страх).",
                'goal' => 'Цель: управляемая выразительность.',
            ],
        ],
        'Живые эмоции' => [
            [
                'title' => 'Эмоция за 10 секунд',
                'body' => "За 10 секунд войди в заданное состояние (радость, страх и т.д.).\nИспользуй воспоминания или воображение.",
                'goal' => 'Цель: быстрый эмоциональный доступ.',
            ],
            [
                'title' => 'История без слов',
                'body' => "Расскажи историю только мимикой и жестами.",
                'goal' => 'Цель: невербальная выразительность.',
            ],
            [
                'title' => 'Контраст',
                'body' => "Начни сцену с одной эмоцией, резко переключись на противоположную.\nНапример: смех → слёзы.",
                'goal' => 'Цель: гибкость эмоций.',
            ],
        ],
    ];

    $coursesResult = mysqli_query($conn, 'SELECT id, Title FROM Courses ORDER BY id ASC');
    if (!$coursesResult) {
        return;
    }

    $insertStmt = mysqli_prepare(
        $conn,
        'INSERT INTO course_tasks (course_id, task_order, title, body, goal) VALUES (?, ?, ?, ?, ?)'
    );

    if (!$insertStmt) {
        mysqli_free_result($coursesResult);
        return;
    }

    while ($courseRow = mysqli_fetch_assoc($coursesResult)) {
        $courseTitle = $courseRow['Title'] ?? '';
        $courseId = (int) ($courseRow['id'] ?? 0);

        if (!isset($tasksByTitle[$courseTitle]) || $courseId <= 0) {
            continue;
        }

        foreach ($tasksByTitle[$courseTitle] as $order => $task) {
            $taskOrder = $order + 1;
            $title = $task['title'];
            $body = $task['body'];
            $goal = $task['goal'];
            mysqli_stmt_bind_param($insertStmt, 'iisss', $courseId, $taskOrder, $title, $body, $goal);
            mysqli_stmt_execute($insertStmt);
        }
    }

    mysqli_stmt_close($insertStmt);
    mysqli_free_result($coursesResult);
}

ensureCourseTasksTable($conn);
seedCourseTasks($conn);

$courseId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$courseStmt = mysqli_prepare($conn, 'SELECT id, Title, Description, img FROM Courses WHERE id = ? LIMIT 1');

if (!$courseStmt) {
    die('Database error');
}

mysqli_stmt_bind_param($courseStmt, 'i', $courseId);
mysqli_stmt_execute($courseStmt);
$courseResult = mysqli_stmt_get_result($courseStmt);
$course = $courseResult ? mysqli_fetch_assoc($courseResult) : null;

if (!$course) {
    http_response_code(404);
    die('Курс не найден');
}

$taskStmt = mysqli_prepare(
    $conn,
    'SELECT task_order, title, body, goal
     FROM course_tasks
     WHERE course_id = ?
     ORDER BY task_order ASC, id ASC'
);

$courseTasks = [];

if ($taskStmt) {
    mysqli_stmt_bind_param($taskStmt, 'i', $courseId);
    mysqli_stmt_execute($taskStmt);
    $taskResult = mysqli_stmt_get_result($taskStmt);

    if ($taskResult) {
        while ($taskRow = mysqli_fetch_assoc($taskResult)) {
            $courseTasks[] = $taskRow;
        }
    }

    mysqli_stmt_close($taskStmt);
}

if (!$courseTasks) {
    $courseTasks = [
        [
            'task_order' => 1,
            'title' => 'Задание 1',
            'body' => 'Прочитай описание курса и выдели главную идею.',
            'goal' => 'Цель: понять основу темы.',
        ],
        [
            'task_order' => 2,
            'title' => 'Задание 2',
            'body' => 'Выполни один короткий этюд по теме курса.',
            'goal' => 'Цель: закрепить навык на практике.',
        ],
        [
            'task_order' => 3,
            'title' => 'Задание 3',
            'body' => 'Повтори упражнение 3 раза и сравни результат.',
            'goal' => 'Цель: отследить прогресс.',
        ],
    ];
}

$imageSrc = '../Style/Global/default-avatar.svg';
if (!empty($course['img'])) {
    $imageData = base64_encode($course['img']);
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['Title']); ?> | Studio Actor</title>
    <link rel="stylesheet" href="../Style/Global/fonts.css">
    <link rel="stylesheet" href="../Style/Components/courses.css">
</head>
<body class="course-page">
<div class="top-bar course-top-bar">
    <div class="brand-info">
        <h1>Курсы</h1>
        <p>Студия Актера</p>
    </div>
    <a href="courses.php" class="close-icon">×</a>
</div>

<div class="courses-list course-detail-layout">
    <div class="course-hero">
        <div class="course-image-box hero-image">
            <img src="<?php echo $imageSrc; ?>" alt="<?php echo htmlspecialchars($course['Title']); ?>">
        </div>
        <div class="course-hero-info">
            <h2><?php echo htmlspecialchars($course['Title']); ?></h2>
        </div>
    </div>

    <div class="course-task-stack">
        <?php foreach ($courseTasks as $task): ?>
            <div class="course-task-card">
                <div class="course-task-title"><?php echo htmlspecialchars($task['title']); ?></div>
                <p><?php echo nl2br(htmlspecialchars($task['body'])); ?></p>
                <span class="course-task-goal"><?php echo htmlspecialchars($task['goal']); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
