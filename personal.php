<?php

session_start();
$_SESSION['content'] = '';
$flag = TRUE;
$name;
$surname;
$login;
$email;
$birthday;
$phone;
$content;


$_SESSION['err_message'] = '';
$_SESSION['success_message'] = '';

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

if (isset($_SESSION['login']) && $_SESSION['login'] != '')
{
    $login = $_SESSION['login'];
} else
{
    $flag = FALSE;
    $_SESSION['err_message'].='Ошибка авторизации!</br>';
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

$content = 'index.php?r=personal';

if ($flag)
{
    try
    {
        include 'dbConnection.php';

        $query = "UPDATE `$tbl_name` SET"
                . "`name`='$name', `surname`='$surname', `mail`='$email', `birthday`='$birthday', `phone`='$phone'"
                . "WHERE login = '$login'";

        $link = mysql_connect($mysql_host, $mysql_user, $mysql_password);
        mysql_select_db($db_name);

        if (!mysql_query($query))
        {
            throw new Exception('Ошибка сохранения данных!');
        }
        $_SESSION['success_message'] = 'Сохранено успешно';

        mysql_close($link);

        $_SESSION['name_surname'] = $name . ' ' . substr($surname, 0, 1) . '.';
    } catch (Exception $e)
    {
        $_SESSION['err_message'] = $e->getMessage();
    }
}

header("Location: $content");
exit();
?>