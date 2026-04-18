<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кастинг | Студия Актера</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #fff;
            min-height: 100vh;
        }

        .casting-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 60px 24px 80px;
        }

        /* Заголовок */
        .casting-header {
            margin-bottom: 48px;
        }

        .casting-header h1 {
            font-size: 36px;
            font-weight: 700;
            color: #4a6cf7;
            margin-bottom: 8px;
        }

        .casting-subtitle {
            font-size: 16px;
            color: #666;
        }

        /* Форма */
        .casting-form {
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .form-field {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-field label {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        .form-field input[type="tel"],
        .form-field input[type="text"] {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.2s;
            background: #fff;
        }

        .form-field input:focus {
            outline: none;
            border-color: #4a6cf7;
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.1);
        }

        .form-field input::placeholder {
            color: #bbb;
        }

        /* Область загрузки файла */
        .upload-area {
            border: 2px dashed #d0d5dd;
            border-radius: 16px;
            padding: 32px 24px;
            text-align: center;
            background: #fafbfc;
            cursor: pointer;
            transition: all 0.2s;
        }

        .upload-area:hover {
            border-color: #4a6cf7;
            background: #f5f8ff;
        }

        .upload-icon {
            font-size: 36px;
            margin-bottom: 12px;
        }

        .upload-title {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .upload-hint {
            font-size: 12px;
            color: #999;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .browse-file-btn {
            background: #fff;
            border: 1px solid #4a6cf7;
            color: #4a6cf7;
            padding: 10px 28px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .browse-file-btn:hover {
            background: #4a6cf7;
            color: #fff;
        }

        .file-selected {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f0f4fe;
            padding: 12px 16px;
            border-radius: 12px;
        }

        .file-selected span {
            font-size: 14px;
            color: #4a6cf7;
            word-break: break-all;
        }

        .remove-file-btn {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #999;
            padding: 0 8px;
        }

        .remove-file-btn:hover {
            color: #ff4d4d;
        }

        .submit-button {
            width: 100%;
            background: #4a6cf7;
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 40px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
        }

        .submit-button:hover {
            background: #3a5ce0;
            transform: translateY(-1px);
        }

        .upload-area.drag-over {
            border-color: #4a6cf7;
            background: #eef3ff;
        }

        /* Модальное окно */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-window {
            background: #fff;
            border-radius: 32px;
            padding: 48px 40px;
            text-align: center;
            max-width: 420px;
            width: 90%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            animation: modalAppear 0.3s ease;
        }

        @keyframes modalAppear {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-check {
            width: 64px;
            height: 64px;
            background: #4caf50;
            color: #fff;
            font-size: 36px;
            font-weight: bold;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .modal-heading {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 16px;
        }

        .modal-text {
            font-size: 15px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 32px;
        }

        .modal-ok {
            background: #4a6cf7;
            color: #fff;
            border: none;
            padding: 12px 48px;
            border-radius: 40px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-transform: uppercase;
        }

        .modal-ok:hover {
            background: #3a5ce0;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="casting-container">
    <div class="casting-header">
        <h1># Кастинг</h1>
        <p class="casting-subtitle">Заполните форму для кастинга</p>
    </div>

    <form id="castingForm" class="casting-form">
        <div class="form-field">
            <label>Введите номер телефона (+7)</label>
            <input type="tel" id="phone" name="phone" placeholder="+7 (___) ___-__-__" required>
        </div>

        <div class="form-field">
            <label>ФИО</label>
            <input type="text" id="fullname" name="fullname" placeholder="Иванов Иван Иванович" required>
        </div>

        <div class="form-field">
            <label>Загрузить файл</label>
            <div class="upload-area" id="uploadArea">
                <div class="upload-icon">📎</div>
                <p class="upload-title">Select and upload the files of your choice</p>
                <p class="upload-hint">Choose a file or drag & drop it here<br>JPEG, PNG, PSD, and MP4 formats, up to 50MB</p>
                <input type="file" id="fileInput" name="file" accept=".jpeg,.jpg,.png,.psd,.mp4" style="display: none;">
                <button type="button" class="browse-file-btn" id="browseBtn">Browse File</button>
            </div>
            <div id="fileInfo" class="file-selected" style="display: none;">
                <span id="fileName"></span>
                <button type="button" id="removeFileBtn" class="remove-file-btn">✕</button>
            </div>
        </div>

        <button type="submit" class="submit-button">Отправить</button>
    </form>
</div>


<div id="successModal" class="modal" style="display: none;">
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
    
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0]);
        }
    });
    
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
        const validTypes = ['image/jpeg', 'image/png', 'application/pdf', 'video/mp4', 'image/vnd.adobe.photoshop'];
        const maxSize = 50 * 1024 * 1024;
        
        if (file.size > maxSize) {
            alert('Файл слишком большой. Максимальный размер 50MB');
            return;
        }
        
        selectedFile = file;
        fileNameSpan.textContent = file.name;
        uploadArea.style.display = 'none';
        fileInfo.style.display = 'flex';
    }
    
    if (removeFileBtn) {
        removeFileBtn.addEventListener('click', function() {
            selectedFile = null;
            fileInput.value = '';
            uploadArea.style.display = 'block';
            fileInfo.style.display = 'none';
        });
    }
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const phone = phoneInput?.value.trim();
        const fullname = nameInput?.value.trim();
        
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
        
        if (modal) {
            modal.style.display = 'flex';
        }
    });
    
    if (modalOk) {
        modalOk.addEventListener('click', function() {
            modal.style.display = 'none';
            form.reset();
            selectedFile = null;
            fileInput.value = '';
            uploadArea.style.display = 'block';
            fileInfo.style.display = 'none';
        });
    }
    
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    }
});
</script>

</body>
</html>