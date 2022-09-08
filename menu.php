<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $pdo = require 'db_connect.php'; // подключение базы
    require 'functions.php';
    list($_SESSION['first_name'], $_SESSION['id']) = info_client($pdo, $_SESSION['login']);

    if ( isset($_POST['action']) && $_POST['action'] === "Выход"){
        session_unset();
        header('location:index.php');
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Что будем делать?</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="parent">
    <div class="block_menu">
        <h2><?php echo $_SESSION['first_name']?> - Вам доступно 3 варианта:</h2>
            <a href="new_record.php"><button class="button_menu">Создать новую запись</button></a>
            <span>*вы можете добавить новую запись в Ваш дневник</span>
            <a href="arhive.php"><button class="button_menu">Посмотреть архив</button></a>
            <span>*вы можете посмотреть Ваши старые записи</span>
            <form action="" method="post">
                <input class="button" type="submit" name="action" value="Выход">
            </form>
             <span></span>
    </div>
</div>
</body>
</html>
