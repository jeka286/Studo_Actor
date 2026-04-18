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
    <link rel="stylesheet" href="../Style/Components/casting.css">
</head>
<body>

<div class="casting-container">
    <div class="casting-header">
        <h1># Кастинг</h1>
        <p class="casting-subtitle">Заполните форму для кастинга</p>
    </div>

    <form id="castingForm" class="casting-form" enctype="multipart/form-data">
        <div class="form-field">
            <label for="phone">Введите номер телефона (+7)</label>
            <input type="tel" id="phone" name="phone" placeholder="+7 (___) ___-__-__" required>
        </div>

        <div class="form-field">
            <label for="fullname">ФИО</label>
            <input type="text" id="fullname" name="fullname" placeholder="Иванов Иван Иванович" required>
        </div>

        <div class="form-field">
            <label for="fileInput">Загрузить PNG</label>
            <div class="upload-area" id="uploadArea">
                <div class="upload-icon">📎</div>
                <p class="upload-title">Выберите и загрузите PNG-файл</p>
                <p class="upload-hint">Перетащите файл сюда или нажмите на кнопку ниже<br>Только PNG, до 50MB</p>
                <input type="file" id="fileInput" name="image" accept=".png" class="visually-hidden" required>
                <button type="button" class="browse-file-btn" id="browseBtn">Выбрать файл</button>
            </div>
            <div id="fileInfo" class="file-selected is-hidden">
                <span id="fileName"></span>
                <button type="button" id="removeFileBtn" class="remove-file-btn">✕</button>
            </div>
        </div>

        <button type="submit" class="submit-button">Отправить</button>
    </form>
</div>

<div id="successModal" class="modal is-hidden">
    <div class="modal-window">
        <div class="modal-check">✓</div>
        <h2 class="modal-heading">Спасибо!</h2>
        <p class="modal-text">Ваша заявка успешно отправлена.<br>В ближайшее время мы с вами свяжемся!</p>
        <button class="modal-ok" id="modalOkBtn">ok</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('castingForm');
    const phoneInput = document.getElementById('phone');
    const nameInput = document.getElementById('fullname');
    const fileInput = document.getElementById('fileInput');
    const browseBtn = document.getElementById('browseBtn');
    const uploadArea = document.getElementById('uploadArea');
    const fileInfo = document.getElementById('fileInfo');
    const fileNameSpan = document.getElementById('fileName');
    const removeFileBtn = document.getElementById('removeFileBtn');
    const modal = document.getElementById('successModal');
    const modalOk = document.getElementById('modalOkBtn');
    const submitButton = form.querySelector('.submit-button');

    let selectedFile = null;

    if (browseBtn) {
        browseBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            fileInput.click();
        });
    }

    if (uploadArea) {
        uploadArea.addEventListener('click', function() {
            fileInput.click();
        });
    }

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                handleFile(e.target.files[0]);
            }
        });
    }

    if (uploadArea) {
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('drag-over');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');
            if (e.dataTransfer.files.length > 0) {
                handleFile(e.dataTransfer.files[0]);
            }
        });
    }

    function handleFile(file) {
        const maxSize = 50 * 1024 * 1024;
        const allowedExtensions = ['png'];
        const parts = file.name.split('.');
        const fileExtension = parts.length > 1 ? parts.pop().toLowerCase() : '';

        if (file.size > maxSize) {
            alert('Файл слишком большой. Максимальный размер 50MB');
            return;
        }

        if (!allowedExtensions.includes(fileExtension)) {
            alert('Можно загружать только PNG');
            return;
        }

        selectedFile = file;
        fileNameSpan.textContent = file.name;
        uploadArea.classList.add('is-hidden');
        fileInfo.classList.remove('is-hidden');
    }

    if (removeFileBtn) {
        removeFileBtn.addEventListener('click', function() {
            selectedFile = null;
            fileInput.value = '';
            uploadArea.classList.remove('is-hidden');
            fileInfo.classList.add('is-hidden');
        });
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const phone = phoneInput ? phoneInput.value.trim() : '';
        const fullname = nameInput ? nameInput.value.trim() : '';

        if (!phone) {
            alert('Пожалуйста, введите номер телефона');
            phoneInput.focus();
            return;
        }

        if (!fullname) {
            alert('Пожалуйста, введите ФИО');
            nameInput.focus();
            return;
        }

        if (!selectedFile) {
            alert('Пожалуйста, загрузите PNG-файл');
            return;
        }

        const formData = new FormData(form);

        try {
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Отправка...';
            }

            const response = await fetch('casting_submit.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Не удалось отправить заявку');
            }

            if (modal) {
                modal.classList.remove('is-hidden');
            }
        } catch (error) {
            alert(error.message || 'Ошибка при отправке заявки');
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = 'Отправить';
            }
        }
    });

    if (modalOk) {
        modalOk.addEventListener('click', function() {
            modal.classList.add('is-hidden');
            form.reset();
            selectedFile = null;
            fileInput.value = '';
            uploadArea.classList.remove('is-hidden');
            fileInfo.classList.add('is-hidden');
        });
    }

    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('is-hidden');
            }
        });
    }
});
</script>

</body>
</html>
