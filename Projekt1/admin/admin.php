<?php
//Prosty formularz logowania do strony
include '../contact.php';  // IMPORT PLIKU CONTACT.PHP


echo FormularzLogowania();
echo PokazKontakt();
echo CzyZalogowany();




function FormularzLogowania() // FORMULARZ DO ZALOGOWANIA SIĘ TAK JAK W LABIE7
{
    

    $wynik = '

    <style>
        .logowanie {
             font-size: 30px; text-align: center; margin-top: 40px; margin-left: 50%; transform: translateX(-50%); border: 5px dotted green; width: 80%; height: 35%; background-color: rgba(255, 8, 8, 0.7)
        }
        input{
            font-size: 25px; margin-top: 10px; margin-left: 10px; margin-bottom: 5px;
        }
        .heading{
            font-size: 35px;
        }
        .przypomnij{
            font-size: 15px;
            text-decoration: none;
            color: black;
        }

    </style>

    <div class = "logowanie">
        <h1 class = "heading">Panel administracyjny CMS:</h1>
        <form method="post" name="LoginForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
                login<input type="text" name="login_email"/></br>
                hasło<input type="password" name="login_pass" /></br>
                <input type="submit" name="login" value="Zaloguj się"/></br>
                <a class="przypomnij" href="">Przypomnij hasło</a>
        </form>            
    </div>
    
    ';
    
    return $wynik;        
}


function CzyZalogowany() // SPRAWDZANIE CZY SIĘ JEST ZALOGOWANYM
{
    include('../cfg.php');

    if (isset($_POST['login'])){
        if (($_POST['login_email'] == $login) && ($_POST['login_pass'] == $pass)){
            $_SESSION['zalogowany'] = 1;
            header('Location: panel.php');
        } else {
            echo "<script>";
                echo "alert('Wprowadzone dane nie są poprawne.');";
                echo "window.location = 'http://localhost/myProject/Projekt1/admin/admin.php';";
                echo "</script>" ;
        }
    }
}


?>