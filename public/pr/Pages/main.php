<?php
session_start();

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

    <link rel="stylesheet" href="../Style/Global/fonts.css">
    <link rel="stylesheet" href="../Style/Pages/main.css">
    <link rel="stylesheet" href="../Style/Layouts/header.css">
    <link rel="stylesheet" href="../Style/Layouts/footer.css">
    <link rel="stylesheet" href="../Style/Components/skills.css">
    <link rel="stylesheet" href="../Style/Components/modal.css">
    <link rel="stylesheet" href="../Style/Components/casting-modal.css">
</head>
<body class="main-page">
<?php
$host = '127.0.1.30';
$user = 'root';
$pass = '';
$db_name = 'Golubko';

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    die('Ошибка подключения: ' . mysqli_connect_error());
}
?>
<header class="header">
    <div class="logo">
        <h1>Studio actor</h1>
        <p>Студия Актера</p>
    </div>
    <div class="auth-buttons">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php" class="btn btn-link">Личный кабинет</a>
            <a href="?logout=1" class="btn btn-link btn-danger">Выйти</a>
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

<?php include '../Includes/footer.php'; ?>

<div id="loginModal" class="modal-overlay">
    <div class="modal-card">
        <button class="close-btn" id="closeLogin">&times;</button>

        <h2 class="modal-title">Вход в аккаунт</h2>
        <p class="modal-subtitle">Введите свои данные для входа в сервис</p>

        <form class="modal-form" id="loginForm">
            <div class="modal-field">
                <label>Email</label>
                <input type="email" id="loginEmail" name="email" required placeholder="example@mail.com">
            </div>

            <div class="modal-field modal-field-password">
                <label>Password</label>
                <input type="password" id="loginPassword" name="password" required placeholder="••••••••">
                <a href="#" class="modal-helper-link">Забыли пароль?</a>
            </div>

            <button type="submit" id="loginSubmitBtn" class="blue-submit-btn">Войти</button>
        </form>

        <p class="modal-switch-text">
            Нет аккаунта? <a href="#" id="linkToRegister" class="blue-link">Зарегистрируйтесь</a>
        </p>
    </div>
</div>

<div id="registerModal" class="modal-overlay">
    <div class="modal-card">
        <button class="close-btn" id="closeRegister">&times;</button>

        <h2 class="modal-title">Создать аккаунт</h2>
        <p class="modal-subtitle">Заполните форму для регистрации</p>

        <form class="modal-form" id="registerForm">
            <div class="modal-field">
                <label>First & Last Name</label>
                <input type="text" id="fullname" name="fullname" required placeholder="Иван Иванов">
            </div>

            <div class="modal-field">
                <label>Email</label>
                <input type="email" id="email" name="email" required placeholder="example@mail.com">
            </div>

            <div class="modal-field">
                <label>Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <div class="modal-field">
                <label>Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="••••••••">
            </div>

            <button type="submit" id="registerSubmitBtn" class="blue-submit-btn">Зарегистрироваться</button>
        </form>

        <p class="modal-switch-text">
            Уже есть аккаунт? <a href="#" id="linkToLogin" class="blue-link">Войти</a>
        </p>
    </div>
</div>

<?php include '../Includes/casting_modal.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');
    const registerForm = document.getElementById('registerForm');
    const loginForm = document.getElementById('loginForm');
    const openLoginBtn = document.getElementById('openLogin');
    const openRegisterBtn = document.getElementById('openRegister');
    const closeLogin = document.getElementById('closeLogin');
    const closeRegister = document.getElementById('closeRegister');
    const linkToRegister = document.getElementById('linkToRegister');
    const linkToLogin = document.getElementById('linkToLogin');

    if (openLoginBtn) {
        openLoginBtn.onclick = (e) => {
            e.preventDefault();
            loginModal.style.display = 'flex';
        };
    }

    if (openRegisterBtn) {
        openRegisterBtn.onclick = (e) => {
            e.preventDefault();
            registerModal.style.display = 'flex';
        };
    }

    if (closeLogin) closeLogin.onclick = () => { loginModal.style.display = 'none'; };
    if (closeRegister) closeRegister.onclick = () => { registerModal.style.display = 'none'; };

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
                    loginModal.style.display = 'none';
                    window.location.href = 'dashboard.php';
                } else {
                    alert(result.message || 'Не удалось выполнить вход');
                }
            } catch (error) {
                alert('Ошибка при входе: ' + error.message);
            }

            return false;
        };
    }

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
                    registerModal.style.display = 'none';
                    alert('Успешная регистрация');
                    loginModal.style.display = 'flex';
                    registerForm.reset();
                } else {
                    alert(result.message || 'Не удалось зарегистрироваться');
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
