<?php
//    ini_set('display_errors', 1);
//    ini_set('display_startup_errors', 1);
//    error_reporting(E_ALL);

    $pdo = require 'db_connect.php'; // подключение базы
    require 'functions.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php

//    if ($_SERVER['REQUEST_METHOD'] === "POST"){
    if ( isset($_POST['action']) && $_POST['action'] === "Зарегистрироваться") {
        list($input, $errors) = validate_form_extended();
        if ($errors) {
            show_reg_form($errors, $input);
        } else {
            if (check_login_in_base($pdo, $input)) {
                $errors['login'] = 'Логин уже занят';
                show_reg_form($errors, $input);
            } else {
                reg_db($pdo, $input);
                show_reg_ok($input);
            }
        }
    } else if ( isset($_POST['action']) && $_POST['action'] === "Назад") {
                header('location:index.php');
            }else {
        // страница загр впервые, отобразить форму
        show_reg_form();
    }