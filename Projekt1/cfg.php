<?php
    
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'moja_strona';
    $link = mysqli_connect($dbhost, $dbuser, $dbpass);
    if (!$link) echo '<b>Przerwane połączenie z bazą danych</b>';
    if (!mysqli_select_db($link, $dbname)) echo '<b>Nie wybrano bazy</b>';

    $login = 'admin';
    $pass = 'admin';
    
?>