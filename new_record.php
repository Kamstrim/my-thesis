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
    <style>


    </style>
</head>
<body>
<?php
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ((!empty($_POST['new_record'])) && ($_POST['new_record'] !== 'Сюда нужно добавить текст!')){
            $fulltext = htmlspecialchars(trim($_POST['new_record']));
            if (!empty($_FILES['file_1']['name'])) {
                $file = $_FILES['file_1'];
                $errors = check_files($file);
                if ($errors) {
                    show_new_reccord_form($errors, $fulltext);
                } else {
                    $name_1 = $file['name'];
                    $tmp_name_1 = $file['tmp_name'];
                    $name_in_db = 'images/' . $file['size'] . '_' . $name_1;
                    move_uploaded_file($tmp_name_1, $name_in_db);

                    $insert_query = $pdo->prepare("INSERT INTO records (`full_text`,`image`,`author_id`) VALUES (?,?,?)");
                    $insert_query->execute([$fulltext, $name_in_db, $_SESSION['id']]);
                    show_rec_ok();
                }
            }else{
                $insert_query = $pdo->prepare("INSERT INTO records (`full_text`,author_id) VALUES (?,?)");
                $insert_query->execute([$fulltext, $_SESSION['id']]);
                show_rec_ok();
            }
        }else if ( isset($_POST['action']) && $_POST['action'] === "Назад") {
            header('location:menu.php');
        }else{
        show_new_reccord_form();
        }
    }else{
        show_new_reccord_form();
    }