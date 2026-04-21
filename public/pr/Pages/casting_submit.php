<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

$host = '127.0.1.30';
$user = 'root';
$pass = '';
$db_name = 'Golubko';

function respondWithError(int $statusCode, string $message): void
{
    http_response_code($statusCode);
    echo json_encode(['success' => false, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

function startsWith(string $haystack, string $needle): bool
{
    return $needle === '' || strpos($haystack, $needle) === 0;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respondWithError(405, 'Метод не поддерживается');
}

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    respondWithError(500, 'Ошибка подключения к БД');
}

mysqli_set_charset($conn, 'utf8mb4');

$fullName = trim($_POST['fullname'] ?? '');
$phoneRaw = trim($_POST['phone'] ?? '');
$userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;

if ($fullName === '' || (function_exists('mb_strlen') ? mb_strlen($fullName) : strlen($fullName)) > 255) {
    respondWithError(422, 'Введите корректное ФИО');
}

$phoneDigits = preg_replace('/\D+/', '', $phoneRaw);

if (strlen($phoneDigits) === 11 && startsWith($phoneDigits, '8')) {
    $phoneDigits = '7' . substr($phoneDigits, 1);
}

if (strlen($phoneDigits) !== 11 || !startsWith($phoneDigits, '7')) {
    respondWithError(422, 'Введите корректный номер телефона в формате +7');
}

$phone = '+' . $phoneDigits;

if ($userId === null) {
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO castings (user_id, full_name, phone, status)
         VALUES (NULL, ?, ?, 'new')"
    );

    if (!$stmt) {
        respondWithError(500, 'Не удалось подготовить SQL-запрос');
    }

    mysqli_stmt_bind_param($stmt, 'ss', $fullName, $phone);
} else {
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO castings (user_id, full_name, phone, status)
         VALUES (?, ?, ?, 'new')"
    );

    if (!$stmt) {
        respondWithError(500, 'Не удалось подготовить SQL-запрос');
    }

    mysqli_stmt_bind_param($stmt, 'iss', $userId, $fullName, $phone);
}

if (!mysqli_stmt_execute($stmt)) {
    respondWithError(500, 'Не удалось сохранить заявку в БД');
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

echo json_encode([
    'success' => true,
    'message' => 'Заявка успешно отправлена'
], JSON_UNESCAPED_UNICODE);
?>
