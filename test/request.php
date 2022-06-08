
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<?php
//register_globals=Off;//для безопасности, при ОН можно обращаться к переменным напрямую
$str = "Здравствуйте, 
    ".$_REQUEST["first_name"]. " 
    ".$_REQUEST["last_name"]."! <br>";
$str .="Вы выбрали для изучения курс по 
    ".$_REQUEST["kurs"];
echo $str;
echo getenv('HTTP_REFERER'); //откуда пришёл запрос, вдруг не наша - хакер)
echo getenv('REQUEST_METHOD')."<br>"; 
    // возвратит использованный метод
echo getenv ('REMOTE_ADDR');    
    // выведет IP-адрес пользователя, 
    // пославшего запрос
?>
