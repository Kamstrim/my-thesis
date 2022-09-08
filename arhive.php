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
    <title>Добавляем новую информацию в Дневник</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="parent">
    <?php
            $today = date("Y-m-d");
            if ( isset($_GET['action']) && $_GET['action'] === "Выбрать данную дату") {
                $get_date = htmlspecialchars(trim($_GET['date']));
                $_SESSION['get_date'] = $get_date;
                show_rec_archive($_SESSION['get_date']);
            }else {
                $record_in_base = check_record_in_base($pdo, $_SESSION['id']);
                show_select_record($pdo, $today, $record_in_base, $_SESSION['id']);
            }
?>
</div>
</body>
</html>
