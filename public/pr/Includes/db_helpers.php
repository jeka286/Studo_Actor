<?php

function ensureUsersPhoneColumn(mysqli $conn): void
{
    $sql = "
        SELECT COUNT(*)
        FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = 'users'
          AND COLUMN_NAME = 'phone'
    ";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        return;
    }

    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);

    $columnExists = $row ? (int) $row[0] : 0;
    if ($columnExists === 0) {
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN phone VARCHAR(20) NULL AFTER email");
    }
}
