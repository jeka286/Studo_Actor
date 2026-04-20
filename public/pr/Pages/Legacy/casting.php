<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кастинг | Studio Actor</title>
    <link rel="stylesheet" href="../Style/Global/fonts.css">
    <style>
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: #f6f8ff;
            color: #1f2430;
            padding: 24px;
        }
        .card {
            max-width: 560px;
            width: 100%;
            background: #fff;
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 24px 60px rgba(31, 36, 48, 0.12);
            text-align: center;
        }
        h1 {
            margin: 0 0 12px;
            color: #3b5bdb;
            font-size: 32px;
        }
        p {
            margin: 0 0 20px;
            line-height: 1.6;
            color: #6f7685;
        }
        a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 180px;
            padding: 12px 20px;
            border-radius: 999px;
            background: #4f6ef7;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Кастинг</h1>
        <p>Отдельная загрузка файлов больше не используется. Теперь заявка отправляется только с телефоном и ФИО через модальное окно.</p>
        <a href="dashboard.php">Вернуться в кабинет</a>
    </div>
</body>
</html>
