<?php

session_start();
$flag = TRUE;
$name;
$surname;
$login;
$password;
$email;
$birthday;
$phone;
$content;
include 'dbConnection.php';

$_SESSION['err_message'] = '';
$_SESSION['success_message'] = '';

$form = ['name' => $_POST['name'], 'surname' => $_POST['surname'], 'login' => $_POST['login'], 'email' => $_POST['email'],
    'birthday' => $_POST['birthday'], 'phone' => $_POST['phone']];

$_SESSION['form'] = $form;


if (isset($_POST['name']) && $_POST['name'] != '')
{
    $name = mysql_escape_string($_POST['name']);
} else
{
    $flag = FALSE;
    $_SESSION['err_message'].='Имя обязательно для ввода!</br>';
}


if (isset($_POST['surname']) && $_POST['surname'] != '')
{
    $surname = mysql_escape_string($_POST['surname']);
} else
{
    $flag = FALSE;
    $_SESSION['err_message'].='Фамилия обязательна для ввода!</br>';
}


if (isset($_POST['login']) && $_POST['login'] != '')
{
    $login = mysql_escape_string($_POST['login']);
    try
    {

        $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $db_name);
        $query = "SELECT * FROM `members` WHERE login = '$login'";
        if ($mysqli->connect_errno)
        {
            throw new Exception("Соединение не удалось");
        }
        $result = $mysqli->query($query);
        if ($mysqli->affected_rows != 0)
        {
            $_SESSION['err_message'] .= "Такой логин уже есть!</br>";
            $content = 'index.php?r=personal';
        }
        $mysqli->close();
    } catch (Exception $e)
    {
        $_SESSION['err_message'].= $e->getMessage();
        $content = 'index.php?r=register';
    }
} else
{
    $flag = FALSE;
    $_SESSION['err_message'].='Введите логин!</br>';
}


if (isset($_POST['password']) && $_POST['password'] != '')
{
    if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 16)
    {
        $flag = FALSE;
        $_SESSION['err_message'].='Пароль должен быть не менее 6 и не более 16 символов!</br>';
    }
    $password = crypt($_POST['password'], substr($_POST['password'], 0, 6));
} else
{
    $flag = FALSE;
    $_SESSION['err_message'].='Введите пароль!</br>';
}


if (isset($_POST['password2']) && $_POST['password2'] != '')
{
    if ($_POST['password2'] !== $_POST['password'])
    {
        $flag = FALSE;
        $_SESSION['err_message'].='Введенные пароли не совпадают!</br>';
    }
} else
{
    $flag = FALSE;
    $_SESSION['err_message'].='Введите пароль повторно!</br>';
}


if (isset($_POST['email']) && $_POST['email'] != '')
{
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        $flag = FALSE;
        $_SESSION['err_message'].='Введите корректный email!</br>';
    }
    $email = mysql_escape_string($_POST['email']);
} else
{
    $flag = FALSE;
    $_SESSION['err_message'].='Введите email!</br>';
}


if (isset($_POST['birthday']) && $_POST['birthday'] != '')
{
    $birthday = DateTime::createFromFormat('Y-m-d', mysql_escape_string($_POST['birthday']));
    if (!$birthday)
    {
        $flag = FALSE;
        $_SESSION['err_message'].='Введите корректную дату рождения в формате гггг-мм-дд!</br>';
    }
    $birthday = $birthday->format('Y-m-d');
} else
{
    $flag = FALSE;
    $_SESSION['err_message'].='Введите дату рождения!</br>';
}


if (isset($_POST['phone']) && $_POST['phone'] != '')
{
    if (!preg_match("/^[0-9]{3,3}\-[0-9]{7,7}$/", $_POST['phone']))
    {
        $flag = FALSE;
        $_SESSION['err_message'].='Введите телефон в формате «***-*******»</br>';
    }
    $phone = mysql_escape_string($_POST['phone']);
} else
{
    $flag = FALSE;
    $_SESSION['err_message'].='Введите телефон!</br>';
}


if (isset($_POST['keystring']) && $_POST['keystring'] != '')
{
    if ($_SESSION['keystring'] !== $_POST['keystring'])
    {
        $flag = FALSE;
        $_SESSION['err_message'].='Правильно введите цифры, изображенные на картинке!</br>';
    }
    $captcha = $_POST['keystring'];
} else
{
    $flag = FALSE;
    $_SESSION['err_message'].='Введите цифры, изображенные на картинке!</br>';
}



if (!$flag)
{
    $content = 'index.php?r=register';
} else
{
    try
    {

        $query = "INSERT INTO `$tbl_name` "
                . "(`name`, `surname`, `login`, `password`, `mail`, `birthday`, `phone`) "
                . "VALUES "
                . "('$name', '$surname', '$login', '$password', '$email', '$birthday', '$phone')";


        $link = mysql_connect($mysql_host, $mysql_user, $mysql_password);
        mysql_select_db($db_name);

        if (!mysql_query($query))
        {
            throw new Exception('Ошибка регистрации!');
        }
        $_SESSION['success_message'] = 'Регистрация прошла успешно';

        mysql_close($link);
        $content = 'index.php';

        unset($_SESSION['form']);
        $message = "Вы успешно зерегистрированы на Test.</br>Ваш логин: $login</br>пароль: $password";
        $message = wordwrap($message, 70, "\r\n");
        mail($email, 'Test registration', $message);
    } catch (Exception $e)
    {
        $_SESSION['err_message'].= $e->getMessage();
        $content = 'index.php?r=register';
    }
}
//var_dump($_POST);exit();
//var_dump($_SESSION['err_message']);exit();
header("Location: $content");
exit();
?>