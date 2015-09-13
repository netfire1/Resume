<div id="header">
    <div id="menu">
        <a class="header_ref" href="index.php">Главная</a>
        <a class="header_ref" href="index.php?r=contacts">Контакты</a>
        <!-- Личный кабинет виден только зарегистрированным пользователям-->
        <?php 
        if (in_array('personal', $this->menu)){
        echo '<a class="header_ref" href="index.php?r=personal">Личный кабинет</a>';}?>
        <a class="header_ref" href="index.php?r=log_in_out">Войти/Выйти</a>
        <!-- Отображение аватара и имени-->

    </div>

    <div id="avatar">
        <!-- Отображение аватара и имени-->
        <?php
        if (array_key_exists('avatar', $this->menu)){            
        echo '<img class= "avatar" src="';
        echo $this->data['menu']['avatar'];
        echo'" alt="аватар">';
        echo '<p>';            
        echo $this->data['menu']['name_surname'];
        echo '</p>';            
        }?>
    </div>
</div>
