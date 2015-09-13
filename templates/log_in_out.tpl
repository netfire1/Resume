<div id="content">

    <!-- Если залогиненый пользователь-->
    <?php if (isset($_SESSION['is_registered']) && $_SESSION['is_registered']==1){
    session_unset();
    header("Location: index.php");
    exit();} ?>

    <!-- Если незалогиненый пользователь-->
    <div>
        <form action="login.php" method="post">
            <ul>
                <div>
                    <label>Логин</label>
                    <input type="text" name="login">
                </div>
                <div>
                    <label>Пароль</label>
                    <input type="password" name="password">
                </div>
                <li><button type="submit" name="content" value="login">Войти</button></li>
            </ul>
        </form>
    </div>
    <a class="reg_ref" href="index.php?r=register">Регистрация</a>


    <?php    
    $_SESSION['err_message'] = '';
    $_SESSION['success_message'] = '';
    ?>
</div>