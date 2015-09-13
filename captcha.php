<?php

require "captcha.class.php"; //Подключаем класс капчи
$captcha = new Captcha(); //Инициализируем капчу
$_SESSION['keystring'] = $captcha->getKeyString();
echo $captcha->draw();
?>