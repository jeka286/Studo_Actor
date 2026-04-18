// casting.js - логика формы кастинга

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
    
    // Открыть выбор файла
    if (browseBtn) {
        browseBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            fileInput.click();
        });
    }
    
    // Клик по области загрузки
    if (uploadArea) {
        uploadArea.addEventListener('click', function() {
            fileInput.click();
        });
    }
    
    // Выбор файла
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0]);
        }
    });
    
    // Drag & drop
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
        const validTypes = ['image/jpeg', 'image/png', 'application/pdf', 'video/mp4'];
        const maxSize = 50 * 1024 * 1024;
        
        if (!validTypes.includes(file.type)) {
            alert('Неподдерживаемый формат. Используйте JPEG, PNG, PDF или MP4');
            return;
        }
        
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
    
    // Отправка формы
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
        
        // Показать модальное окно
        if (modal) {
            modal.style.display = 'flex';
        }
    });
    
    // Закрыть модальное окно
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
    
    // Закрыть по клику на фон
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    }
});