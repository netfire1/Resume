
<div id="content">

    <form action="registerValidation.php" method="post">
        <div >
            <label>Имя</label>
            <input type="text" name="name" value="<?=$_SESSION['form']['name'];?>" required/>
        </div>

        <div>
            <label>Фамилия</label>
            <input type="text" name="surname" value="<?=$_SESSION['form']['surname'];?>" required/>
        </div>

        <div>
            <label>Логин</label>
            <input type="text" name="login" value="<?=$_SESSION['form']['login'];?>" required>
        </div>

        <div>
            <label>Пароль</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Повторите пароль</label>
            <input type="password" name="password2" required>
        </div>

        <div>
            <label>email</label>
            <input type="email" name="email" value="<?=$_SESSION['form']['email'];?>" required>
        </div>

        <script>
            $(function () {
                $("#datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '1900:' + new Date().getFullYear(),
                    maxDate: "-18y",
                    dateFormat: "yy-mm-dd"
                });
            });
        </script>
        <div>
            <label>Дата рождения (гггг-мм-дд)</label>
            <input type="text" id="datepicker" name="birthday" value="<?=$_SESSION['form']['birthday'];?>" required>
        </div>


        <div>
            <label>Телефон «***-*******»</label>
            <input type="text" name="phone" value="<?=$_SESSION['form']['phone'];?>" required>
        </div>

        <div>
            <label class="captcha">Введите цифры изображенные на картинке:</label>
            <div ><?php require 'captcha.php';?></div>
            <input type="text" class = "text" name="keystring" value="" required/>
        </div> 

        <?php unset($_SESSION['form']);             
        $_SESSION['err_message'] = '';
        $_SESSION['success_message'] = '';
        ?>
        <div>

            <label>&nbsp;</label>
            <input type="submit" class="btn" name="content" value="Регистрация" />
        </div>

    </form>
</div>