<?php include('personalContent.php');
$_SESSION['random_key'] = "";
$_SESSION['user_file_ext'] = ""
;?>

<div id="content">

    <form enctype="multipart/form-data" action="personal.php" method="post">
        <div >
            <label>Имя</label>
            <input  type="text" minlenth="2" name="name" value="<?=$name;?>" required>
        </div>

        <div>
            <label>Фамилия</label>
            <input type="text" name="surname" value="<?=$surname;?>" required/>
        </div>

        <input type="hidden" name="login" value="<?=$login;?>">               

        <div>
            <label>email</label>
            <input type="email" name="email" value="<?=$email;?>" required>
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
            <input type="text" id="datepicker" name="birthday" value="<?=$birthday;?>" required>
        </div>


        <div>
            <label>Телефон «***-*******»</label>
            <input type="text" name="phone" value="<?=$phone;?>" required>
        </div>

        <div>

            <label>&nbsp;</label>
            <input type="submit" class="btn" name="content" value="Сохранить" />
        </div>

    </form>


    <img id="photo" src="<?=$foto?>" alt="" title=""  />


    <form  action="fotoCrop.php" method="post">
        <div >            
            <input type="submit" name="content" value="Загрузить фото" />
        </div>
    </form>




    <div style="text-align: center;">            
        <input type="submit" class="btn-del" name="content" value="Полное удаление профиля" onclick="if (confirm('Уверены, что хотите удалить?'))
                    location.href = 'delete.php';"/>
    </div>
    <form  action="delete.php" method="post">
    </form>

</div>
