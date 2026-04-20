<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Требуется авторизация'], JSON_UNESCAPED_UNICODE);
    exit;
}

$host = '127.0.1.30';
$user = 'root';
$pass = '';
$db_name = 'Golubko';

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Ошибка подключения к БД'], JSON_UNESCAPED_UNICODE);
    exit;
}

require_once __DIR__ . '/db_helpers.php';
ensureUsersPhoneColumn($conn);

mysqli_set_charset($conn, 'utf8mb4');

$userId = (int) $_SESSION['user_id'];
$fullName = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

if ($fullName === '' || (function_exists('mb_strlen') ? mb_strlen($fullName) : strlen($fullName)) > 100) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Введите корректное ФИО'], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Введите корректный email'], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($phone !== '') {
    $phoneDigits = preg_replace('/\D+/', '', $phone);
    if (strlen($phoneDigits) === 11 && $phoneDigits[0] === '8') {
        $phoneDigits = '7' . substr($phoneDigits, 1);
    }
    if (strlen($phoneDigits) !== 11 || $phoneDigits[0] !== '7') {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'Введите корректный телефон в формате +7'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    $phone = '+' . $phoneDigits;
} else {
    $phone = null;
}

$checkStmt = mysqli_prepare($conn, 'SELECT id FROM users WHERE email = ? AND id <> ? LIMIT 1');
if (!$checkStmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Не удалось подготовить проверку email'], JSON_UNESCAPED_UNICODE);
    exit;
}

mysqli_stmt_bind_param($checkStmt, 'si', $email, $userId);
mysqli_stmt_execute($checkStmt);
mysqli_stmt_store_result($checkStmt);

if (mysqli_stmt_num_rows($checkStmt) > 0) {
    mysqli_stmt_close($checkStmt);
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Этот email уже занят'], JSON_UNESCAPED_UNICODE);
    exit;
}

mysqli_stmt_close($checkStmt);

$stmt = mysqli_prepare($conn, 'UPDATE users SET full_name = ?, email = ?, phone = ? WHERE id = ?');

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Не удалось подготовить запрос обновления'], JSON_UNESCAPED_UNICODE);
    exit;
}

mysqli_stmt_bind_param($stmt, 'sssi', $fullName, $email, $phone, $userId);

if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Не удалось сохранить профиль'], JSON_UNESCAPED_UNICODE);
    exit;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

$_SESSION['user_name'] = $fullName;
$_SESSION['user_email'] = $email;
$_SESSION['user_phone'] = $phone;

echo json_encode([
    'success' => true,
    'message' => 'Профиль сохранен',
    'full_name' => $fullName,
    'email' => $email,
    'phone' => $phone
], JSON_UNESCAPED_UNICODE);
?>
