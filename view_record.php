<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body{
            background: none;
        }
        .box{
            padding: 10px;
            display: flex;
        }
        .box p{
            margin-left: 20px;
            font-size: 15px;
        }
    </style>
</head>
<body>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $pdo = require 'db_connect.php'; // подключение базы
    require 'functions.php';

    $today = date("Y-m-d");
    $get_date = $_SESSION['get_date'].'%';

    $query = "SELECT full_text, image 
                            FROM records 
                            WHERE `add_date` LIKE ? AND `author_id` = ?
                            ORDER BY `add_date` DESC ;";

    $result = $pdo->prepare($query);
    $result->execute([$get_date, $_SESSION['id']]);
    $records = [];
    $i = 0;
    while ($records_in_bd = $result->fetch(PDO::FETCH_ASSOC)) {
        $records[$i]['text'] = $records_in_bd['full_text'];
        $records[$i]['image'] = $records_in_bd['image'];
        $i++;
    }
    foreach ($records as $record) {
        echo '<div class="box">';
        if (!empty($record['image'])) {
            echo '<img src=' . $record['image'] . ' width="200px" height="100%" alt="' . $record['image'] . '">';
        }
        echo '<p>' . $record['text'] . '</p>';
        echo '</div>';
        echo '<hr>';
    }
?>
</body>
</html>
