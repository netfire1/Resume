<?php

$name;
$surname;
$login;
$email;
$birthday;
$phone;
$foto;

if (!isset($_SESSION['login']) || $_SESSION['login'] == '')
{
    $_SESSION['err_message'] = 'Пройдите авторизацию';
    $_SESSION['content'] = 'log_in_out';
    header("Location: index.php");
    exit();
}

$login = $_SESSION['login'];

try
{
    include 'dbConnection.php';
    $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $db_name);

    $query = "SELECT * FROM `members` WHERE login = '$login'";
    if ($mysqli->connect_errno)
    {
        throw new Exception("Соединение не удалось");
    }

    $res = $mysqli->query($query);
    $row = $res->fetch_row();

    if (!$row)
    {
        $_SESSION['err_message'] = "Ошибка!";
        $_SESSION['content'] = 'personal';
    } else
    {
        $name = $row[1];
        $surname = $row[2];
        $email = $row[5];
        $birthday = $row[6];
        $phone = $row[7];
        if ($row[8] == NULL || $row[8] == 'NULL')
        {
            $foto = 'images/default.png';
        } else
        {
            $foto = $row[8];
        }
        $_SESSION['avatar'] = $foto;
    }

    $mysqli->close();
} catch (Exception $e)
{
    $_SESSION['err_message'] = $e->getMessage();
    $_SESSION['content'] = 'log_in_out';
    header("Location: index.php");
    exit();
}
?>

