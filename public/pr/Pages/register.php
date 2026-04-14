<?php
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

$full_name = mysqli_real_escape_string($conn, $_POST['fullname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    echo json_encode(['success' => false, 'message' => 'Пароли не совпадают']);
    exit;
}

$check_query = "SELECT id FROM users WHERE email = '$email'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    echo json_encode(['success' => false, 'message' => 'Пользователь с таким email уже существует']);
    exit;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$insert_query = "INSERT INTO users (full_name, email, password, date_created) 
                 VALUES ('$full_name', '$email', '$hashed_password', NOW())";

if (mysqli_query($conn, $insert_query)) {
    echo json_encode(['success' => true, 'message' => 'Регистрация успешна!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка: ' . mysqli_error($conn)]);
}
?>