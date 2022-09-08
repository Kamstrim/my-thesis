<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

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
    <title>Ваш персональный онлайн дневник</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php

        if ( isset($_POST['action']) && $_POST['action'] === "Войти"){
        list( $input, $errors ) = validate_form_short();
        if ( $errors ){
            show_start_form($errors, $input);
        }else {
            if (!check_login_in_base($pdo, $input)) {
                $errors['login'] = 'Логин не найден в базе';
                show_start_form($errors, $input);
            } else {
                list($input, $errors) = check_pass($pdo, $input);
                if ($errors) {
                    show_start_form($errors, $input);
                } else {
                    $_SESSION['login'] = $input['login'];
                    header('location:menu.php');
                }
            }
        }
    } else if ( isset($_POST['action']) && $_POST['action'] === "Регистрация"){
            header('location:access.php');}
        else {
         // страница загр впервые, отобразить форму
        show_start_form();
    }