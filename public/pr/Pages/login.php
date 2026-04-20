<?php
session_start();
header('Content-Type: application/json');

$host = '127.0.1.30';
$user = 'root';
$pass = '';
$db_name = 'Golubko';

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Ошибка подключения к БД']);
    exit;
}

require_once __DIR__ . '/db_helpers.php';
ensureUsersPhoneColumn($conn);

$email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$query = "SELECT id, full_name, email, phone, password FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_phone'] = $user['phone'] ?? null;

        echo json_encode(['success' => true, 'message' => 'Вход выполнен успешно!']);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Неверный пароль']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Пользователь не найден']);
?>
