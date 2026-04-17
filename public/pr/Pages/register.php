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

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// УБРАЛ date_created - теперь работает
$insert_query = "INSERT INTO users (full_name, email, password) 
                 VALUES ('$full_name', '$email', '$hashed_password')";

if (mysqli_query($conn, $insert_query)) {
    echo json_encode(['success' => true, 'message' => 'Регистрация успешна!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка: ' . mysqli_error($conn)]);
}
?>