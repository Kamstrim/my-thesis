<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start(); // начинаем сессию - вызываем функцию в каждом файле, где работаем с массивом $_SESSION

//    date_default_timezone_set('Europe/Moscow');

    function show_start_form( $errors = [], $input = []) //базовая форма для входа
    {
        if (empty($input['login'])){
            $input['login'] = '';
        }
        if (empty($errors['login'])){
            $errors['login'] = '';
        }
        if (empty($errors['password'])){
            $errors['password'] = '';
        }
        echo <<<_HTML
    <div class="parent">
    <h1>Доступ в Ваш личный дневник</h1>
        <div class="block">
            <form class="start_window" action="" method="post">
                <div>
                    <label for="login">Login:</label>
                    <input class="text_login" type="text" name="login" placeholder="Введите Логин" value="$input[login]" autofocus><br>
                    <span>$errors[login]</span>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input class="text" type="password" name="password" placeholder="Введите Пароль"><br>
                    <span>$errors[password]</span>
                </div>
                <div class="block_button">
                    <input class="button" type="submit" name="action" value="Войти">
                    <input class="button" type="submit" name="action" value="Регистрация">
                </div>
            </form>
<!--                <a href="access.php"><button class="button2">Запросить доступ</button></a>         -->
        </div>
    </div>
</body>
</html>
_HTML;
    }
    function show_reg_form( $errors = [], $input = []) //основная регистрационная форма
    {
        //проверяем поля ввода на наличие данных
        if (empty($input['login'])){
            $input['login'] = '';
        }
        if (empty($input['first_name'])){
            $input['first_name'] = '';
        }
        if (empty($input['last_name'])){
            $input['last_name'] = '';
        }
        if (empty($input['email'])){
            $input['email'] = '';
        }
        //проверяем поля ошибок на наличие данных

        if (empty($errors['login'])){
            $errors['login'] = '';
        }
        if (empty($errors['email'])){
            $errors['email'] = '';
        }
        if (empty($errors['first_name'])){
            $errors['first_name'] = '';
        }
        if (empty($errors['last_name'])){
            $errors['last_name'] = '';
        }
        if (empty($errors['password'])){
            $errors['password'] = '';
        }
        if (empty($errors['password2'])){
             $errors['password2'] = '';
        }
        echo <<<_HTML
    <div class="parent">
    <h1 class="h_reg">Форма регистрации</h1>
        <div class="block block2">
            <form class="reg_window" action="" method="post">
                <label for="first_name">Имя:</label>
                <input class="text_reg text1" type="text" name="first_name" placeholder="Введите Имя" value="$input[first_name]" autofocus><br>
                <span>$errors[first_name]</span><br>
                                
                <label for="last_name">Фамилия:</label>
                <input type="text_reg" name="last_name" placeholder="Введите Фамилию"  value="$input[last_name]"><br>
                <span>$errors[last_name]</span><br>
                                
                <label for="login">Login:</label>
                <input class="text_reg text2" type="text" name="login" placeholder="Введите Логин" value="$input[login]"><br>
                <span>$errors[login]</span><br>
                
                <label for="email">Email:</label>
                <input class="text_reg text2" type="email" name="email" placeholder="Введите Email" value="$input[email]"><br>
                <span>$errors[email]</span><br>
                
                <label for="password">Password:</label>
                <input class="text_reg" type="password" name="password" placeholder="Введите Пароль"><br>
                <span>$errors[password]</span><br>
                
                <label for="password2">Password:</label>
                <input class="text_reg" type="password" name="password2" placeholder="Повторно Пароль"><br>
                <span>$errors[password2]</span><br>
                
                <div class="button_reg">
                    <input class="button" type="submit" name="action" value="Зарегистрироваться">
                    <input class="button" type="submit" name="action" value="Назад">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
_HTML;
    }
    function d($arr) //просмотр содержимого массива
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
    function validate_form_short() //базовая проверка формы (логин, пароль)
    {

        $errors = []; // ошибки
        $input = []; // данные

        $input['login'] = htmlspecialchars(trim($_POST['login']));
        $input['password'] = htmlspecialchars(trim($_POST['password']));

        function validate_login($login)
        {
            // только латинские буквы, цифры. должен начинаться с буквы и быть не короче 2 символов
            $reg_exp = "/^[a-z][a-z0-9]+$/i";

            if (strlen($login) === 0) {
                return '*введите логин!';
            } elseif (strlen($login) < 2) {
                return '*минимум 2 символа!';
            } elseif (!preg_match($reg_exp, $login)) {
                return '*только латинские буквы и цифры';
            }
        }

        // вызывыем функцию для проверки логина
        if (validate_login($input['login'])) {
            $errors['login'] = validate_login($input['login']);
        }// конец блока проверки логина

        function validate_password($password)
        {
            $reg_exp = "/^.{5,}$/";// 5 и более произвольных символов

            if (strlen($password) === 0) {
                return '*введите пароль!';
            } elseif (!preg_match($reg_exp, $password)) {
                return '*не короче пяти символов!';
            }
        }

        // вызывыем функцию для проверки пароля
        if (validate_password($input['password'])) {
            $errors['password'] = validate_password($input['password']);
        }// конец блока проверки пароля

        return [$input, $errors];
    }
    function validate_form_extended()// расширенная проверка данных в форме
    {

        list($input, $errors) = validate_form_short();

        $input['first_name'] = htmlspecialchars(trim($_POST['first_name'])); //trim - удаляем пробелы, htmlspecialchars - не обрабатываем теги
        $input['last_name'] = htmlspecialchars(trim($_POST['last_name']));
        $input['email'] = htmlspecialchars(trim($_POST['email']));
        $input['password'] = htmlspecialchars(trim($_POST['password']));
        $input['password2'] = htmlspecialchars(trim($_POST['password2']));


        function validate_first_name($first_name)
        {
            // только русские буквы, не короче двух символов
            $req_exp = "/^[а-яё]{2,}$/ui";

            if (empty($first_name)) { // если пользователь ничего не ввел в поле имя
                return '*введите имя!';
            } elseif (mb_strlen($first_name) < 2) { // если имя короче 2 символов
                return '*не менее чем 2 буквы!';
            } elseif (!preg_match($req_exp, $first_name)) { // проверка на русские буквы
                return '*только русские буквы!';
            }
        }

        // вызываем функцию проверки имени
        // если функция возвратит какую-то строку
        // значит пользователь ввел не то что нам нужно
        // значит нужно положить возвращенную строку в массив с ошибками
        if (validate_first_name($input['first_name'])) {
            $errors['first_name'] = validate_first_name($input['first_name']);
        }
        //    объявляем функцию
        function validate_last_name($last_name)
        {
            // только русские буквы, не короче двух символов
            $req_exp = "/^[а-яё]{2,}$/ui";

            if (empty($last_name)) { // если пользователь ничего не ввел в поле имя
                return '*введите фамилию!';
            } elseif (mb_strlen($last_name) < 2) { // если фамилия короче 2 символов
                return '*не менее чем 2 буквы!';
            } elseif (!preg_match($req_exp, $last_name)) { // проверка на русские буквы
                return '*только русские буквы!';
            }
        }

        // вызываем функцию проверки фамилии
        if (validate_last_name($input['last_name'])) { // если функция возвратила строку с ошибкой
            $errors['last_name'] = validate_last_name($input['last_name']); // записываем эту строку в массив $errors
        }// конец блока проверки фамилии

        /**
         *
         * функция для проверки email
         *
         */
        // объявляем функцию
        function validate_email($email)
        {
            $reg_exp = "/^.+@.+\..+$/";
            //$reg_exp = "/^[^@ ]+[@][^@ ]+[.][^@ ]{2,}$/";

            if (strlen($email) === 0) {
                return '*введите адрес электронной почты!';
            } elseif (!preg_match($reg_exp, $email)) {
                return '*некорректный формат!';
            }
        }

        // вызывыем функцию для проверки емейла
        if (validate_email($input['email'])) {
            $errors['email'] = validate_email($input['email']);
        }// конец блока проверки емейла


        function validate_duplicate_password($password, $password2)
        {

            if (strlen($password) === 0) {
                return '*введите пароль!';
            } elseif ($password !== $password2) {
                return '*пароли не совпадают!';
            }
        }

        // вызывыем функцию для проверки 2 пароля
        if (validate_duplicate_password($input['password'], $input['password2'] )) {
            $errors['password2'] = validate_duplicate_password($input['password'], $input['password2'] );
        }// конец блока проверки пароля

        return [$input, $errors];
    }
    function check_pass($pdo, $input, $errors = []) //проверка пароля на входе
    {
        $query = "SELECT `login`,`password` FROM `users` WHERE `login` = ?;"; //запрос в БД, если логин и пароль корректные
        $result = $pdo->prepare($query); //получаем информацию
        $result->execute([$input['login']]);
        $user = $result->fetch(PDO::FETCH_ASSOC); //выводим ее в массив
            if ($user['password'] === $input['password']) { //если логин есть проверяем пароль
                return [$input, $errors];
            } else {
                $errors['password'] = '*пароль не верен';
                return [$input, $errors];
            }
    }
    function check_login_in_base($pdo, $input) //наличие логина в базе
    {
        $query = "SELECT `login` FROM `users` WHERE login = '$input[login]'";
        $result = $pdo->query($query); //получаем информацию
        $user = $result->fetch(PDO::FETCH_ASSOC); //выводим ее в массив
        if ($user) { //проверяем на наличие логина в базе
            return True;
        } else {
            return False;
        }
    }
    function info_client($pdo, $login) //вытаскиваем имя и id для дальнейшей обработки
    {
        $query = "SELECT id, `first_name` FROM `users` WHERE login = ?";
        $result = $pdo->prepare($query); //получаем информацию
        $result->execute([$login]);

        $user = $result->fetch(PDO::FETCH_ASSOC); //выводим ее в массив
        return [$user['first_name'], $user['id']];
    }
    function reg_db($pdo, $input) //добавление нового пользователя в Базу
    {
        $insert_query = $pdo->prepare("INSERT INTO users (`login`,`first_name`,`last_name`,`email`,`password`) VALUES(?, ?, ?, ?, ?)");
        $insert_query->execute([$input['login'], $input['first_name'], $input['last_name'], $input['email'], $input['password']]);
    }
    function show_reg_ok($input) //окно вывода Успешная регистрация
    {
                echo <<<_HTML
    <div class="parent">
               <h1>Регистрация успешно выполнена!</h1>
        <div class="block block_reg">
            <div class="block_info">
                <h2>Ваш логин: <span class="info">$input[login]</span></h2>
                <p>Ваше имя: <span class="info">$input[first_name]</span></p>
                <p>Ваша фамилия: <span class="info">$input[last_name]</span></p>
                <p>Ваша электронная почта: <span class="info">$input[email]</span></p>
                <p>Ваш пароль: <span class="info">$input[password]</span></p>
            </div>
                <a class="return" href="index.php"><button class="button_ret">Назад</button></a>

        </div>
    </div>
</body>
</html>
_HTML;
    }
    function menu_show($input) //меню выбора Новая запись / Архив
    {
        echo <<<_HTML
    <div class="parent">
        <div class="block_menu">
            <h2>$input[first_name] - Вам доступно 2 варианта:</h2>
            <a href="new_record.php"><button class="button_menu">Создать новую запись</button></a>
            <span>*вы можете добавить новую запись в Ваш дневник</span>
            <a href="archive.php"><button class="button_menu">Посмотреть архив</button></a>
            <span>*вы можете посмотреть Ваши старые записи</span>
        </div>
    </div>
</body>
</html>
</body>
</html>
_HTML;
    }
    function check_files($file) //Проверка загружаемого файла
    {
        if($file['error'] !== 0 ){
            return 'Произошла ошибка при загрузке файла';
        }elseif($file['type'] !== 'image/jpeg' && $file['type'] !== 'image/jpg' ){
            return 'Вы можете загружать только изображения в формате .jpg/.jpeg';
        }elseif($file['size'] > 3145728){
            return 'Размер загружаемого файла должен быть не более 3 Мб';
        }
    }
    function show_rec_ok() //окно - запись добавлена в Архив успешно
    {
        echo <<<_HTML
    <div class="parent">
               <h1>Ваша запись Добавлена!</h1>
                <a class="return" href="menu.php"><button class="button_ret">Назад</button></a>
    </div>
</body>
</html>
_HTML;
    }
    function show_new_reccord_form( $errors = 'Тут Вы можете загрузить Фотографию, как ассоциацию', $input = ''){
    echo <<<_HTML
     <div class="parent">
        <h1 class="h_new_reg">Добавялем новую запись в Ваш Дневник:</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="new_record">
                <label for="new_record">Расскажите то, что для Вас важно:</label>
                <textarea name="new_record" cols="70" rows="10" wrap="soft" placeholder="     Сюда нужно добавить текст!" autofocus>$input</textarea>
                        
                <label for="file_1">$errors</label>
                <input class="file" type="file" name="file_1">

                <div class="button_new_reg">
                    <input class="button" type="submit" name="action" value="Записать">
                    <input class="button" type="reset" value="Очистить">
                    <input class="button" type="submit" name="action" value="Назад">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
_HTML;
}
    function show_select_record($pdo, $today, $record_in_base, $id)
    {
        if ($record_in_base) {
            $date = check_min_max_date($pdo, $id);
            echo <<<_HTML
                    <h1>Информация из Архива:</h1>
                    <div class="new_record">
                        <form>
                            <p>Выберите дату:
                            <input type="date" name="date" value="$today"
                            max="$date[1]" min="$date[0]">
                            <input class="button" type="submit" name="action" value="Выбрать данную дату"></p>
                        </form>
                        <a class="return" href="menu.php"><button class="button_ret">Назад</button></a>
                    </div>
            _HTML;
        } else {
            echo <<<_HTML
                    <h1>Информация в Архиве отсутствует</h1>
                    <a class="return" href="menu.php"><button class="button_ret">Назад</button></a>
            _HTML;
        }
    } //отображение календаря Архива
    function check_record_in_base($pdo, $id){
        $query = "SELECT id FROM records WHERE author_id = ?";
        $result = $pdo->prepare($query);
        $result->execute([$id]);
        $records = $result->fetch();
        if ($records){
            return True;
        }else{
            return False;
        }
    } //поиск наличия информации в архиве
    function check_min_max_date($pdo, $id){
        $query = "SELECT `add_date` FROM records WHERE `author_id` = ? ORDER BY `add_date` LIMIT 1;";
        $result = $pdo->prepare($query);
        $result->execute([$id]);
        $records = $result->fetch(PDO::FETCH_ASSOC);
        $date_min = substr(($records['add_date']),0, 10);

        $query = "SELECT `add_date` FROM records WHERE `author_id` = ? ORDER BY `add_date` DESC LIMIT 1;";
        $result = $pdo->prepare($query);
        $result->execute([$id]);
        $records = $result->fetch(PDO::FETCH_ASSOC);
        $date_max = substr(($records['add_date']),0, 10);
        return [$date_min, $date_max];
    } //поиск инфо по доступным датам поиска в архиве
    function show_rec_archive($date) //вывод информации из Архива в отдельный фрейм
    {
        echo <<<_HTML
            <div class="new_record">
            <h1>Информация за $date число:</h1>
            <iframe class="window" src="view_record.php" width="500px" height="400px"></iframe>
            <a href="menu.php"><button class="button">Назад</button></a>
            </div>
_HTML;
    }



