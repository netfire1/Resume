<?php

session_start();
$_SESSION['content'] = '';
$_SESSION['err_message'] = '';
$_SESSION['success_message'] = '';
$login;
$password;
$location = 'index.php';
$flag = TRUE;

if (isset($_POST['login']) && $_POST['login'] != '')
{
    $login = mysql_escape_string($_POST['login']);
} else
{
    $flag = FALSE;
    $_SESSION['err_message'].='Введите логин!</br>';
    $location = 'index.php?r=log_in_out';
}

if (isset($_POST['password']) && $_POST['password'] != '')
{
    $password = crypt($_POST['password'], substr($_POST['password'], 0, 6));
} else
{
    $flag = FALSE;
    $_SESSION['err_message'].='Введите пароль!</br>';
    $location = 'index.php?r=log_in_out';
}

if ($flag)
{
    try
    {
        include 'dbConnection.php';
        $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $db_name);

        $query = "SELECT * FROM `members` WHERE login = '$login' AND password = '$password'";
        if ($mysqli->connect_errno)
        {
            $_SESSION['err_message'] = "Соединение не удалось";
            $location = 'index.php?r=log_in_out';
        }

        $mysqli->query($query);
        if ($mysqli->affected_rows != 1)
        {
            $_SESSION['err_message'] = "Неверный логин или пароль";
            $location = 'index.php?r=log_in_out';
        } else
        {
            $_SESSION['is_registered'] = 1;
            $_SESSION['login'] = $login;


            //Загрузка аватара
            $query = "SELECT `name`, `surname`, `foto` FROM `members` WHERE login = '$login'";
            $res = $mysqli->query($query);
            $row = $res->fetch_row();
            if ($row[2] == NULL || $row[2] == 'NULL')
            {
                $foto = 'images/default.png';
            } else
            {
                $foto = $row[2];
            }
            $_SESSION['avatar'] = $foto;
            $_SESSION['name_surname'] = $row[0] . ' ' . substr($row[1], 0, 1) . '.';
        }

        $mysqli->close();
    } catch (Exception $e)
    {
        $_SESSION['err_message'] = $e->getMessage();
        $location = 'index.php?r=log_in_out';
    }
}

header("Location: $location");
exit();
?>