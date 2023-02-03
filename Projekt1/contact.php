<?php

//Funckaj pokazująca kontakt//
    function PokazKontakt()
    {
        echo
        "
        <style>
            .contact-form {margin-left: 50%;  font-size: 30px;
                transform: translateX(-50%); height: 50%; width: 80%; margin-top: 30px; text-align: center; position: relative; border: 5px dotted red; background-color: rgba(86, 255, 8, 0.5)}
            .formularz {font-size: 35px; text-align: center;}
            .formm {text-align: center; font-size: 30px; padding: 0px; margin-bottom: 5px}
            .inputcontact{
                height: 12%; width: 30%; margin-bottom: 10px
            }
            .topic{
                width: 30%; height: 18%
            }
            .formularz_button{
                font-size: 20px; margin-bottom: 10px; margin-top: 8px;
            }
        </style>
        
        
        <div class='contact-form'>
        <h1 class='formularz'>Skontaktuj się ze mną:</h1>
            <form method='post' class='formm'> 
                <label for='email'>Email</label>
                <input class='inputcontact' type='text' id='email' name='email'>
                </br
                <label for='subject'>Temat</label>
                <input class='inputcontact' type='text' id='temat' name='temat'>
                </br>
                <label for='body'>Treść</label>
                <input class='topic' type='text' id='body' name='tresc'></br></input>
                <button class='formularz_button' type='submit'>Wyślij</button>
            </form>
            
        </div>";
        
    }


//Funckaj która wysyła emaila//
    function wyslijMailKontakt($odbiorca)
    {

        if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email']))
        {
            echo "<script>";
            echo "alert('Nie wypełniłes pola');";
            echo "window.location = 'http://localhost/myProject/Projekt1/admin/admin.php';";
            echo "</script>" ;
        }
        else
        {
            $mail['subject'] = $_POST['temat'];
            $mail['body'] = $_POST['tresc'];
            $mail['sender'] = $_POST['email'];
            $mail['reciptient'] = $odbiorca;

            $header = "From: Formularz kontaktowy <".$mail['sender'].">\n";
            $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit\n";
            $header .= "X-Sender: <".$mail['sender'].">\n";
            $header .= "X-Mailer: PRapWWW mail 1.2\n";
            $header .= "X-Priority: 3\n";
            $header .= "Return-Path: <".$mail['sender']."\n";
            
            mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);
            echo "<script>";
            echo "alert('Wiadomość została wysłana');";
            echo "window.location = 'http://localhost/myProject/Projekt1/admin/admin.php';";
            echo "</script>" ;
        }
    }


//Funkcja przypominająca hasło użytkownikowi
    function PrzypomnijHaslo()
    {
        include('cfg.php');

        if (empty($_POST['emailPass']))
        {
            echo("Nie wypełniłeś pola");
        }
        else
        {
            $mail['subject'] = "Przypomnienie hasla";
            $mail['body'] = "Haslo do konta adminisratora: ".$pass."";
            $mail['sender'] = $admin_mail;
            $mail['reciptient'] = $_POST['emailPass'];

            $header = "From: Formularz kontaktowy <".$mail['sender'].">\n";
            $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit\n";
            $header .= "X-Sender: <".$mail['sender'].">\n";
            $header .= "X-Mailer: PRapWWW mail 1.2\n";
            $header .= "X-Priority: 3\n";
            $header .= "Return-Path: <".$mail['sender']."\n";

            mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);
            echo("Wiadomość wysłana");
        }
    }



?>