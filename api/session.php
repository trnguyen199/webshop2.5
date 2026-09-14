<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

if (!isset($_SESSION["user_id"])) {

    echo json_encode([
        "success" => true,
        "logged_in" => false
    ]);

    exit;
}

echo json_encode([
    "success" => true,
    "logged_in" => true,
    "user" => [
        "id" => $_SESSION["user_id"],
        "name" => $_SESSION["user_name"],
        "email" => $_SESSION["user_email"],
        "role" => $_SESSION["user_role"]
    ]
]);
?>