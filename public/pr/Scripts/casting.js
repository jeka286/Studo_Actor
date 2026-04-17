// casting.js - логика страницы кастинга

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('castingForm');
    const fileInput = document.getElementById('fileInput');
    const browseBtn = document.getElementById('browseBtn');
    const dropZone = document.getElementById('fileDropZone');
    const fileInfo = document.getElementById('fileInfo');
    const fileNameSpan = document.getElementById('fileName');
    const removeFileBtn = document.getElementById('removeFileBtn');
    const modal = document.getElementById('successModal');
    const modalOkBtn = document.getElementById('modalOkBtn');
    
    let selectedFile = null;
    
    // Открыть выбор файла
    browseBtn.addEventListener('click', function() {
        fileInput.click();
    });
    
    // Клик по зоне для выбора файла
    dropZone.addEventListener('click', function(e) {
        if (e.target !== browseBtn && !browseBtn.contains(e.target)) {
            fileInput.click();
        }
    });
    
    // Выбор файла
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            handleFileSelect(e.target.files[0]);
        }
    });
    
    // Drag & drop
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('drag-over');
    });
    
    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
    });
    
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        
        if (e.dataTransfer.files.length > 0) {
            handleFileSelect(e.dataTransfer.files[0]);
        }
    });
    
    // Обработка выбранного файла
    function handleFileSelect(file) {
        const validTypes = ['image/jpeg', 'image/png', 'application/pdf', 'video/mp4'];
        const maxSize = 50 * 1024 * 1024; // 50MB
        
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
        fileInfo.style.display = 'flex';
        dropZone.style.display = 'none';
    }
    
    // Удалить файл
    if (removeFileBtn) {
        removeFileBtn.addEventListener('click', function() {
            selectedFile = null;
            fileInput.value = '';
            fileInfo.style.display = 'none';
            dropZone.style.display = 'block';
        });
    }
    
    // Отправка формы
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const phone = document.getElementById('phone').value;
        const fullname = document.getElementById('fullname').value;
        
        // Простая валидация
        if (!phone || !fullname) {
            alert('Пожалуйста, заполните все поля');
            return;
        }
        
        // Здесь можно добавить AJAX отправку на сервер
        // Для демонстрации просто показываем модальное окно
        
        // Показать модальное окно
        modal.style.display = 'flex';
    });
    
    // Закрыть модальное окно
    modalOkBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        // Очистить форму после отправки
        form.reset();
        selectedFile = null;
        fileInput.value = '';
        fileInfo.style.display = 'none';
        dropZone.style.display = 'block';
    });
    
    // Закрыть модальное окно по клику вне его
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});