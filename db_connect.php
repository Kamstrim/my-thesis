<?php
//переменные для подключения к БД (PDO)
$login = 'root';
$password = '';
$host = 'localhost';
$db_name = 'personal_diary';

//создаем подключение к БД
    try{
        return new PDO ("mysql:host=$host; dbname=$db_name", $login, $password);
    }catch( Exception $e ){
        echo 'Прозошла ошибка при подключении к базе данных!<br>';
    }
