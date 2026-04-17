<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кастинг | Студия Актера</title>
    
    <link rel="stylesheet" href="../Style/Global/fonts.css">
    <link rel="stylesheet" href="../Style/Layouts/header.css">
    <link rel="stylesheet" href="../Style/Layouts/footer.css">
    <link rel="stylesheet" href="../Style/Components/casting.css">
    <link rel="stylesheet" href="../Style/Components/modal.css">
</head>
<body>

<div class="casting-page">
    <!-- Шапка -->
    <div class="casting-header">
        <a href="dashboard.php" class="back-link">
            <span class="back-arrow">←</span> Назад
        </a>
        <div class="casting-logo">
            <h1># Кастинг</h1>
            <p>Заполните форму для кастинга</p>
        </div>
    </div>

    <!-- Форма кастинга -->
    <form id="castingForm" class="casting-form" enctype="multipart/form-data">
        <div class="form-group">
            <label for="phone">Введите номер телефона (+7)</label>
            <input type="tel" id="phone" name="phone" placeholder="+7 (___) ___-__-__" required>
        </div>

        <div class="form-group">
            <label for="fullname">ФИО</label>
            <input type="text" id="fullname" name="fullname" placeholder="Иванов Иван Иванович" required>
        </div>

        <div class="form-group file-upload-group">
            <label>Загрузить файл</label>
            <div class="file-drop-zone" id="fileDropZone">
                <div class="file-upload-icon">📎</div>
                <p class="file-upload-text">Select and upload the files of your choice</p>
                <p class="file-upload-hint">Choose a file or drag & drop it here<br>JPEG, PNG, PDF, and MP4 formats, up to 50MB</p>
                <input type="file" id="fileInput" name="file" accept=".jpeg,.jpg,.png,.pdf,.mp4" style="display: none;">
                <button type="button" class="browse-btn" id="browseBtn">Browse File</button>
            </div>
            <div id="fileInfo" class="file-info" style="display: none;">
                <span id="fileName"></span>
                <button type="button" id="removeFileBtn" class="remove-file">✕</button>
            </div>
        </div>

        <button type="submit" class="submit-btn">Отправить</button>
    </form>
</div>

<!-- Модальное окно (успех) -->
<div id="successModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-icon">✓</div>
        <h2 class="modal-title">Спасибо!</h2>
        <p class="modal-message">Ваша заявка успешно отправлена.<br>В ближайшее время мы с вами свяжемся!</p>
        <button class="modal-ok-btn" id="modalOkBtn">ok</button>
    </div>
</div>

<script src="../Scripts/JS casting.js"></script>
</body>
</html>