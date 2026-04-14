<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDIO ACTOR</title>
    <style>
        /* Базовые сбросы */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: #f9f9f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Шапка с кнопками */
        .main-header {
            background: white;
            border-bottom: 1px solid #eee;
            padding: 16px 0;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .studio-title {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #195ad4;
            margin: 0;
        }

        .auth-buttons {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: 0.2s;
        }

        .btn-login {
            background: transparent;
            color: #195ad4;
            border: 1px solid #195ad4;
        }

        .btn-login:hover {
            background: #f0f0f0;
        }

        .btn-register {
            background: transparent;
            color: #195ad4;
            border: 1px solid #195ad4;
        }

        .btn-register:hover {
            background: #f0f0f0;
        }

        /* Секция навыков */
        .skills-section {
            max-width: 1200px;
            margin: 60px auto;
            padding: 0 24px;
            flex: 1;
        }

        .skills-header {
            text-align: center;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 48px;
            color: #195ad4;
        }

        /* Горизонтальные карточки */
        .skills-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            justify-content: center;
            color: #195ad4;
        }

        .skill-card {
            flex: 1 1 220px;
            min-width: 220px;
            max-width: 280px;
            background: white;
            padding: 28px 20px;
            border-radius: 24px;
            box-shadow: 0 10px 25px rgba(35, 64, 153, 0.03);
            border: 1px solid #2642c0;
            transition: 0.2s;
        }

        .skill-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px rgba(146, 24, 24, 0.05);
            border-color: #2642c0;
        }

        .skill-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #040404;
        }

        .skill-description {
            font-size: 16px;
            line-height: 1.5;
            color: #040404;
            margin: 0;
        }

        /* Модальные окна */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 32px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .modal-title {
            font-size: 32px;
            font-weight: 700;
            color: #195ad4;
            margin-bottom: 8px;
        }

        .modal-subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            padding: 16px 20px;
            border: 1px solid #ddd;
            border-radius: 16px;
            font-size: 16px;
            transition: 0.2s;
            background: #f8f8f8;
        }

        .form-group input:focus {
            outline: none;
            border-color: #195ad4;
            background: white;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
            cursor: pointer;
        }

        .checkbox-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .forgot-link {
            color: #195ad4;
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: #195ad4;
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 24px;
            transition: 0.2s;
        }

        .btn-submit:hover {
            background: #0e3a9e;
        }

        .modal-footer {
            text-align: center;
            color: #666;
            font-size: 15px;
        }

        .modal-footer a {
            color: #195ad4;
            text-decoration: none;
            font-weight: 500;
            margin-left: 4px;
        }

        .modal-footer a:hover {
            text-decoration: underline;
        }

        /* СТИЛИ ДЛЯ ФУТЕРА */
        .footer {
            background: white;
            border-top: 1px solid #eee;
            padding: 40px 0 20px;
            margin-top: 60px;
            width: 100%;
        }

        .footer__container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .footer__title {
            font-size: 24px;
            font-weight: 700;
            color: #195ad4;
            margin-bottom: 8px;
        }

        .footer__subtitle {
            color: #666;
            margin-bottom: 32px;
        }

        .footer__grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer__column-title {
            font-size: 16px;
            font-weight: 600;
            color: #195ad4;
            margin-bottom: 16px;
        }

        .footer__links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer__links li {
            margin-bottom: 8px;
        }

        .footer__links a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .footer__links a:hover {
            color: #195ad4;
        }

        .footer__bottom {
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #888;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- Шапка с кнопками входа и регистрации -->
<header class="main-header">
    <div class="header-container">
        <h1 class="studio-title">STUDIO ACTOR</h1>
        <div class="auth-buttons">
            <button class="btn btn-login" onclick="openModal('login')">Войти</button>
            <button class="btn btn-register" onclick="openModal('register')">Регистрация</button>
        </div>
    </div>
</header>

<section class="skills-section">
    <h2 class="skills-header">Навыки, которые ты прокачаешь</h2>
    
    <div class="skills-grid">
        <!-- Пластика и движение -->
        <div class="skill-card">
            <h3 class="skill-title">Пластика и движение</h3>
            <p class="skill-description">
                Сценическое движение: Перестань бояться своего тела, обретешь пластичность и координацию
            </p>
        </div>

        <!-- Четкая дикция -->
        <div class="skill-card">
            <h3 class="skill-title">Четкая дикция</h3>
            <p class="skill-description">
                Техника речи и дикция: Сделаем голос звонким, а речь чистой, чтобы тебя слушали с открытым ртом
            </p>
        </div>

        <!-- Живые эмоции -->
        <div class="skill-card">
            <h3 class="skill-title">Живые эмоции</h3>
            <p class="skill-description">
                Эмоциональный интеллект: Научишься вызывать любую эмоцию по заказу и управлять чувствами зрителя
            </p>
        </div>

        <!-- Полная концентрация -->
        <div class="skill-card">
            <h3 class="skill-title">Полная концентрация</h3>
            <p class="skill-description">
                Актерская концентрация: Сможешь забыть о зажимах и панике на сцене, будешь в моменте здесь и сейчас
            </p>
        </div>
    </div>
</section>

<!-- Модальное окно регистрации -->
<div class="modal" id="registerModal">
    <div class="modal-content">
        <h2 class="modal-title">Создать аккаунт</h2>
        <p class="modal-subtitle">Заполните форму для регистрации</p>
        
        <form>
            <div class="form-group">
                <input type="text" placeholder="First & Last Name" required>
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Confirm Password" required>
            </div>
            
            <button type="submit" class="btn-submit">Зарегистрироваться</button>
            
            <div class="modal-footer">
                Уже есть аккаунт? <a href="#" onclick="switchModal('login')">Войти</a>
            </div>
        </form>
    </div>
</div>

<!-- Модальное окно входа -->
<div class="modal" id="loginModal">
    <div class="modal-content">
        <h2 class="modal-title">Вход в аккаунт</h2>
        <p class="modal-subtitle">Введите свои данные для входа в сервис</p>
        
        <form>
            <div class="form-group">
                <input type="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Password" required>
            </div>
            
            <div class="form-row">
                <label class="checkbox-label">
                    <input type="checkbox"> Запомнить меня
                </label>
                <a href="#" class="forgot-link">Забыли пароль?</a>
            </div>
            
            <button type="submit" class="btn-submit">Войти</button>
            
            <div class="modal-footer">
                Нет аккаунта? <a href="#" onclick="switchModal('register')">Зарегистрируйтесь</a>
            </div>
        </form>
    </div>
</div>

<!-- Футер как web-компонент -->
<my-footer></my-footer>

<!-- Подключаем скрипт футера -->
<script src="./footer.js"></script>

<script>
    function openModal(type) {
        document.getElementById('registerModal').classList.remove('active');
        document.getElementById('loginModal').classList.remove('active');
        document.getElementById(type + 'Modal').classList.add('active');
    }

    function switchModal(type) {
        openModal(type);
    }

    // Закрытие модального окна при клике вне его
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.classList.remove('active');
        }
    }
</script>

</body>
</html>