<?php

session_start();
$foto;

if (isset($_SESSION['login']) && $_SESSION['login'] != '')
{
    $login = $_SESSION['login'];
    try
    {
        include 'dbConnection.php';
        $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $db_name);

        $query = "SELECT `foto` FROM `members` WHERE login = '$login'";
        if ($mysqli->connect_errno)
        {
            throw new Exception("Соединение не удалось");
        }
        if ($result = $mysqli->query($query))
        {
            $foto = $result->fetch_assoc()['foto'];
            //var_dump($foto); exit();            
        }


        $query = "DELETE FROM `members` WHERE login = '$login'";
        if ($mysqli->connect_errno)
        {
            throw new Exception("Соединение не удалось");
        }

        if (!$mysqli->query($query))
        {
            throw new Exception("Ошибка удаления");
            $_SESSION['content'] = 'personal';
        } else
        {
            session_unset();
            $_SESSION['success_message'] = 'Удалено';
        }

        $mysqli->close();

        if ($foto)
        {
            unlink($foto);
        }
    } catch (Exception $e)
    {
        $_SESSION['err_message'] = $e->getMessage();
        $_SESSION['content'] = 'personal';
    }

    header("Location: index.php");
    exit();
}
?>
