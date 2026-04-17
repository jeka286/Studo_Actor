<?php
session_start();

// Обработка выхода
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: main.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Actor | Главная</title>
    
    <!-- Твои стили -->
    <link rel="stylesheet" href="../Style/Global/fonts.css">
    <link rel="stylesheet" href="../Style/Layouts/header.css">
    <link rel="stylesheet" href="../Style/Layouts/footer.css">
    <link rel="stylesheet" href="../Style/Components/skills.css">
    <link rel="stylesheet" href="../Style/Components/modal.css">
    
    <!-- Дополнительные стили для футера -->
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0 40px;
        }
        .skills-section {
            flex: 1;
        }
        .footer {
            margin-top: auto;
        }
    </style>
</head>
<body>
    <?php
    $host = '127.0.1.30'; 
    $user = 'root';      
    $pass = '';          
    $db_name = 'Golubko'; 

    $conn = mysqli_connect($host, $user, $pass, $db_name);

    if (!$conn) {
        die("Ошибка подключения: " . mysqli_connect_error());
    }
    ?>
    <header class="header">
        <div class="logo">
            <h1>Studio actor</h1>
            <p>Студия Актера</p>
        </div>
        <div class="auth-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="btn" style="text-decoration: none; display: inline-block; line-height: normal;">Личный кабинет</a>
                <a href="?logout=1" class="btn" style="text-decoration: none; display: inline-block; line-height: normal; background: #ff4757;">Выйти</a>
            <?php else: ?>
                <button class="btn" id="openLogin">Войти</button>
                <button class="btn" id="openRegister">Зарегистрироваться</button>
            <?php endif; ?>
        </div>
    </header>

    <main class="skills-section">
        <h2 class="section-title">Навыки, которые ты прокачаешь</h2>
        
        <div class="cards-container">
            <div class="card">
                <h3>Пластика и движение</h3>
                <p>Перестанешь бояться своего тела, обретешь пластичность и координацию.</p>
            </div>
            <div class="card">
                <h3>Четкая дикция</h3>
                <p>Сделаем голос звонким, а речь чистой, чтобы тебя слушали с открытым ртом.</p>
            </div>
            <div class="card">
                <h3>Живые эмоции</h3>
                <p>Научишься вызывать любую эмоцию по заказу и управлять чувствами зрителя.</p>
            </div>
            <div class="card">
                <h3>Полная концентрация</h3>
                <p>Сможешь забыть о зажимах и панике на сцене, будешь в моменте.</p>
            </div>
        </div>
    </main>

    <!-- Футер ПОДКЛЮЧАЕТСЯ ЗДЕСЬ (внутри body) -->
    <?php include 'footer.php'; ?>

    <!-- Модальное окно ВХОДА -->
    <div id="loginModal" class="modal-overlay" style="display: none;">
        <div class="modal-card">
            <button class="close-btn" id="closeLogin">&times;</button>
            
            <h2 class="modal-title" style="color: #4a6cf7; text-align: center; margin-bottom: 5px;">Вход в аккаунт</h2>
            <p class="modal-subtitle" style="color: #999; text-align: center; font-size: 12px; margin-bottom: 25px;">Введите свои данные для входа в сервис</p>

            <form class="modal-form" id="loginForm">
                <div class="modal-field" style="display: flex; flex-direction: column; margin-bottom: 15px;">
                    <label style="font-size: 12px; font-weight: bold; margin-bottom: 5px;">Email</label>
                    <input type="email" id="loginEmail" name="email" required placeholder="example@mail.com" style="padding: 10px; border: 1px solid #dce4f5; border-radius: 8px; outline: none;">
                </div>
                
                <div class="modal-field" style="display: flex; flex-direction: column; margin-bottom: 15px; position: relative;">
                    <label style="font-size: 12px; font-weight: bold; margin-bottom: 5px;">Password</label>
                    <input type="password" id="loginPassword" name="password" required placeholder="••••••••" style="padding: 10px; border: 1px solid #dce4f5; border-radius: 8px; outline: none;">
                    <a href="#" style="color: #4a6cf7; text-decoration: none; font-size: 11px; align-self: flex-end; margin-top: 5px;">Забыли пароль?</a>
                </div>

                <div class="modal-options" style="display: flex; align-items: center; gap: 8px; margin: 20px 0;">
                    <input type="checkbox" id="remember">
                    <label for="remember" style="color: #154add; font-size: 13px;">Запомнить меня</label>
                </div>

                <button type="submit" id="loginSubmitBtn" style="width: 80%; margin: 0 auto; display: block; background: #4a6cf7; color: white; border: none; padding: 12px; border-radius: 10px; cursor: pointer; font-weight: bold;">Войти</button>
            </form>

            <p style="text-align: center; margin-top: 20px; font-size: 12px; color: #999;">
                Нет аккаунта? <a href="#" id="linkToRegister" style="color: #4a6cf7; text-decoration: none; font-weight: bold;">Зарегистрируйтесь</a>
            </p>
        </div>
    </div>

    <!-- Модальное окно РЕГИСТРАЦИИ -->
    <div id="registerModal" class="modal-overlay" style="display: none;">
        <div class="modal-card">
            <button class="close-btn" id="closeRegister">&times;</button>
            
            <h2 class="modal-title" style="color: #4a6cf7; text-align: center; margin-bottom: 5px;">Создать аккаунт</h2>
            <p class="modal-subtitle" style="color: #999; text-align: center; font-size: 12px; margin-bottom: 25px;">Заполните форму для регистрации</p>

            <form class="modal-form" id="registerForm">
                <div class="modal-field" style="display: flex; flex-direction: column; margin-bottom: 15px;">
                    <label style="font-size: 12px; font-weight: bold; margin-bottom: 5px;">First & Last Name</label>
                    <input type="text" id="fullname" name="fullname" required placeholder="Иван Иванов" style="padding: 10px; border: 1px solid #dce4f5; border-radius: 8px; outline: none;">
                </div>

                <div class="modal-field" style="display: flex; flex-direction: column; margin-bottom: 15px;">
                    <label style="font-size: 12px; font-weight: bold; margin-bottom: 5px;">Email</label>
                    <input type="email" id="email" name="email" required placeholder="example@mail.com" style="padding: 10px; border: 1px solid #dce4f5; border-radius: 8px; outline: none;">
                </div>
                
                <div class="modal-field" style="display: flex; flex-direction: column; margin-bottom: 15px;">
                    <label style="font-size: 12px; font-weight: bold; margin-bottom: 5px;">Password</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••" style="padding: 10px; border: 1px solid #dce4f5; border-radius: 8px; outline: none;">
                </div>

                <div class="modal-field" style="display: flex; flex-direction: column; margin-bottom: 15px;">
                    <label style="font-size: 12px; font-weight: bold; margin-bottom: 5px;">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required placeholder="••••••••" style="padding: 10px; border: 1px solid #dce4f5; border-radius: 8px; outline: none;">
                </div>

                <button type="submit" id="registerSubmitBtn" style="width: 80%; margin: 0 auto; display: block; background: #4a6cf7; color: white; border: none; padding: 12px; border-radius: 10px; cursor: pointer; font-weight: bold;">Зарегистрироваться</button>
            </form>

            <p style="text-align: center; margin-top: 20px; font-size: 12px; color: #999;">
                Уже есть аккаунт? <a href="#" id="linkToLogin" style="color: #4a6cf7; text-decoration: none; font-weight: bold;">Войти</a>
            </p>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginModal = document.getElementById('loginModal');
            const registerModal = document.getElementById('registerModal');
            const registerForm = document.getElementById('registerForm');
            const loginForm = document.getElementById('loginForm');

            // Открытие окон
            const openLoginBtn = document.getElementById('openLogin');
            const openRegisterBtn = document.getElementById('openRegister');
            
            if (openLoginBtn) {
                openLoginBtn.onclick = (e) => { e.preventDefault(); loginModal.style.display = 'flex'; };
            }
            if (openRegisterBtn) {
                openRegisterBtn.onclick = (e) => { e.preventDefault(); registerModal.style.display = 'flex'; };
            }

            // Закрытие окон
            const closeLogin = document.getElementById('closeLogin');
            const closeRegister = document.getElementById('closeRegister');
            if (closeLogin) closeLogin.onclick = () => { loginModal.style.display = 'none'; };
            if (closeRegister) closeRegister.onclick = () => { registerModal.style.display = 'none'; };

            // Переключение между окнами
            const linkToRegister = document.getElementById('linkToRegister');
            const linkToLogin = document.getElementById('linkToLogin');
            
            if (linkToRegister) {
                linkToRegister.onclick = (e) => {
                    e.preventDefault();
                    loginModal.style.display = 'none';
                    registerModal.style.display = 'flex';
                };
            }
            
            if (linkToLogin) {
                linkToLogin.onclick = (e) => {
                    e.preventDefault();
                    registerModal.style.display = 'none';
                    loginModal.style.display = 'flex';
                };
            }

            // Обработка ВХОДА
            if (loginForm) {
                loginForm.onsubmit = async (e) => {
                    e.preventDefault();
                    
                    const email = document.getElementById('loginEmail').value;
                    const password = document.getElementById('loginPassword').value;
                    
                    const formData = new FormData();
                    formData.append('email', email);
                    formData.append('password', password);
                    
                    try {
                        const response = await fetch('login.php', {
                            method: 'POST',
                            body: formData
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            alert(result.message);
                            window.location.href = 'dashboard.php';
                        } else {
                            alert(result.message);
                        }
                    } catch (error) {
                        alert('Ошибка при входе: ' + error.message);
                    }
                    
                    return false;
                };
            }

            // Обработка РЕГИСТРАЦИИ
            if (registerForm) {
                registerForm.onsubmit = async (e) => {
                    e.preventDefault();
                    
                    const fullname = document.getElementById('fullname').value;
                    const email = document.getElementById('email').value;
                    const password = document.getElementById('password').value;
                    const confirm_password = document.getElementById('confirm_password').value;
                    
                    if (password !== confirm_password) {
                        alert('Пароли не совпадают!');
                        return false;
                    }
                    
                    const formData = new FormData();
                    formData.append('fullname', fullname);
                    formData.append('email', email);
                    formData.append('password', password);
                    formData.append('confirm_password', confirm_password);
                    
                    try {
                        const response = await fetch('register.php', {
                            method: 'POST',
                            body: formData
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            alert(result.message);
                            registerModal.style.display = 'none';
                            loginModal.style.display = 'flex';
                            registerForm.reset();
                        } else {
                            alert(result.message);
                        }
                    } catch (error) {
                        alert('Ошибка при регистрации: ' + error.message);
                    }
                    
                    return false;
                };
            }
        });
    </script>
</body>

</html>