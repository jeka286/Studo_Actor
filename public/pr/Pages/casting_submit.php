<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

$host = '127.0.1.30';
$user = 'root';
$pass = '';
$db_name = 'Golubko';

$maxFileSize = 50 * 1024 * 1024;
$allowedExtensions = ['png'];
$allowedMimeTypes = [
    'image/png'
];

function startsWith($haystack, $needle)
{
    return $needle === '' || strpos($haystack, $needle) === 0;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Метод не поддерживается']);
    exit;
}

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Ошибка подключения к БД']);
    exit;
}

mysqli_set_charset($conn, 'utf8mb4');

$fullName = trim($_POST['fullname'] ?? '');
$phoneRaw = trim($_POST['phone'] ?? '');
$userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
$fullNameLength = function_exists('mb_strlen') ? mb_strlen($fullName) : strlen($fullName);

if ($fullName === '' || $fullNameLength > 255) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Введите корректное ФИО']);
    exit;
}

$phoneDigits = preg_replace('/\D+/', '', $phoneRaw);

if (strlen($phoneDigits) === 11 && startsWith($phoneDigits, '8')) {
    $phoneDigits = '7' . substr($phoneDigits, 1);
}

if (strlen($phoneDigits) !== 11 || !startsWith($phoneDigits, '7')) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Введите корректный номер телефона в формате +7']);
    exit;
}

$phone = '+' . $phoneDigits;

if (!isset($_FILES['image'])) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Загрузите PNG-файл']);
    exit;
}

$file = $_FILES['image'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Ошибка загрузки файла']);
    exit;
}

if ($file['size'] > $maxFileSize) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Файл слишком большой. Максимум 50MB']);
    exit;
}

$originalFileName = basename($file['name']);
$extension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

if (!in_array($extension, $allowedExtensions, true)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Разрешены только PNG-файлы']);
    exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']) ?: '';
finfo_close($finfo);

if (!in_array($mimeType, $allowedMimeTypes, true)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Некорректный формат файла']);
    exit;
}

$imageData = file_get_contents($file['tmp_name']);

if ($imageData === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Не удалось прочитать PNG-файл']);
    exit;
}

$fileSize = (int) $file['size'];
$filePath = null;

if ($userId === null) {
    $stmt = mysqli_prepare(
        $conn,
        'INSERT INTO castings (user_id, full_name, phone, file_path, original_file_name, mime_type, file_size, image_data)
         VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)'
    );

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Не удалось подготовить SQL-запрос']);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmt,
        'sssssib',
        $fullName,
        $phone,
        $filePath,
        $originalFileName,
        $mimeType,
        $fileSize,
        $imageData
    );
    mysqli_stmt_send_long_data($stmt, 6, $imageData);
} else {
    $stmt = mysqli_prepare(
        $conn,
        'INSERT INTO castings (user_id, full_name, phone, file_path, original_file_name, mime_type, file_size, image_data)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
    );

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Не удалось подготовить SQL-запрос']);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmt,
        'isssssib',
        $userId,
        $fullName,
        $phone,
        $filePath,
        $originalFileName,
        $mimeType,
        $fileSize,
        $imageData
    );
    mysqli_stmt_send_long_data($stmt, 7, $imageData);
}

if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Не удалось сохранить заявку в БД']);
    exit;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

echo json_encode([
    'success' => true,
    'message' => 'Заявка успешно отправлена'
]);
?>
