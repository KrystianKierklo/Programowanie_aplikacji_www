<h1 style="text-align: center; text-decoration: underline"> PANEL CMS W KTÓRYM UMIESZCZAM WSZYSTKIE METODY ZWIĄZANE Z ADMINEM </h1>
<?php
// WYWOŁANIA METOD ZWIĄZANYCH Z PODSTRONAMI, OD POCZĄTKU TJ.: WYŚWIETLENIE LISTY PODSTRON, DODANIE PODSTRONY, USUNIĘCIE PODSTRONY
// I EDYCJA WYBRANEJ PODSTRONY


   session_start();
echo ListaPodstron();

if (isset($_GET['edytuj'])){
    echo EdytujPodstrone($_GET['edytuj']);
};

if (isset($_GET['usun'])){
    echo UsunPodstrone($_GET['usun']);
}
if (isset($_GET['dodaj'])) {
    echo DodajPodstrone($_GET['dodaj']);
}


echo "</br></br></br></br></br></br></br></br>------------------------------------------------------------------";


// WYWOŁANIA METOD ZWIĄZANYCH Z KATEGORIAMI, OD POCZĄTKU TJ.: WYŚWIETLENIE LISTY KATEGORII, DODANIE KATEGORII, USUNIĘCIE KATEGORII
// I EDYCJA WYBRANEJ KATEGORI

echo ListaKategori();

if (isset($_GET['dodajkategorie'])){
    echo DodajKategorie($_GET['dodajkategorie']);
};

if (isset($_GET['usunkategorie'])){
    echo UsunKategorie($_GET['usunkategorie']);
};

if (isset($_GET['edytujkategorie'])){
    echo EdytujKategorie($_GET['edytujkategorie']);
};

echo "</br></br></br></br></br></br></br></br>------------------------------------------------------------------";

echo PokazProdukty();
if (isset($_GET['dodajprodukt'])){
    echo DodajProdukt($_GET['dodajprodukt']);
};

if (isset($_GET['usunprodukt'])){
    echo UsunProdukt($_GET['usunprodukt']);
};

if (isset($_GET['edytujprodukt'])){
    echo EdytujProdukt($_GET['edytujprodukt']);

};

echo "</br></br></br></br></br>";

echo showCart();
if(isset($_GET['usunzkoszyka'])){
    echo removeFromCart($_GET['usunzkoszyka']);
};

if (isset($_GET['dodajdokoszyka'])){
    echo addToCart($_GET['dodajdokoszyka']);

};



//-----------------------------------------------------------------------------



function ListaPodstron() // FUNKCJA KTORA WYSWIETLA LISTĘ WSZYSTKICH PODSTRON
{
    include('../cfg.php');  // IMPORT PLIKU CFG.PHP

    $query="Select * FROM page_list";  // ZAPYTANIE Z BAZY DANYCH 
    $result = mysqli_query($link, $query);
    $wynik = '<h1>Lista Podstron: </h1></br>'; // DEKLARACJA ZMIENNEJ WYNIK DO KTÓREJ POTEM DOPISUJE


    while($row = mysqli_fetch_array($result)) // PĘTLA PRZECHODZĄCA PO KAŻDYM WIERSZY TABELI BAZY DANYCH
    {
        $wynik .= '
        <h2>' . $row['id'] . '
        ' . $row['page_title'].'
        ' . $row['status'].'
            <a href="panel.php?edytuj=' . $row['id'] . '"><button class="btn" style="background-color: rgb(238, 177, 56)">Edytuj</button></a> 
            <a href="panel.php?usun=' . $row['id'] . '"><button class="btn" style="background-color: rgb(255, 98, 98)">Usuń</button></a> <br /></h2>
        ';
    }

    $wynik .= '<a href="panel.php?dodaj"><button class="btn" style="background-color: rgb(31, 231, 0)">dodaj podstronę</button></a>'; // PRZYCISK DO DODANIA NOWEJ PODSTRONY

    return $wynik; 
}


function EdytujPodstrone($id){      // FUNCKCJA UMOŻLIWIAJĄCA EDYCJE WYBRANEJ KATEGORII
    if ($_GET['edytuj'] == $id){
        include('../cfg.php');
        $wynik = '';
        $query = "SELECT * FROM page_list WHERE id = $id LIMIT 1"; // ZAPYTANIE DO BAZY DANYH Z LIMITEM 1
        $result = mysqli_query($link, $query);
        
        $row = mysqli_fetch_array($result);

        $wynik .= '
                <form method="post" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
                <input type="text" name="tytul" value="' . $row['page_title'] . '">
                <textarea style="width:60%; height: 30%" name="tresc"> ' . $row['page_content'] . '</textarea>
                <input type="checkbox" name="status" value=""/>
                <input type="submit" name="save" value="zapisz" style="background-color: rgb(31, 231, 0)"/>
        ';

        if (isset($_POST['save'])) { // ISSET SPRAWDZA CZY PODANY PARAETR JEST ZADEKLAROWANY
            $nazwa = $_POST['tytul']; // ZMIENNA DO KTOREJ PRZYPISUJE TYTUŁ
            $tresc = $_POST['tresc']; // ZMIENNA DO KTOREJ PRZYPISUJE TRESC
            $status = isset($_POST['status']) ? 1 : 0; // SPRAWDZANIE CZY STATUS JEST 1 
            $query = "UPDATE page_list SET page_title = '$nazwa', page_content = '$tresc', status = '$status' WHERE id = $id LIMIT 1";
            // WPROWADZENIE UPDATE'A DO BAZY DANYCH PAGE_LIST
            if (mysqli_query($link, $query)) {
                echo "<script>";
                echo "alert('Podstrona została zaktualizowana');";
                echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
                echo "</script>";
            } else {
                echo "<script>";
                echo "alert('Podstrona nie została zaktualizowana');";
                echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
                echo "</script>";
            }
            // WARUNEK KTÓRY WYŚWIETLA POTWIERDZENIE ALBO ODRZUCENIE AKTUALIZACJI BAZY DANYCH
        }
        return $wynik;
    }
}

function UsunPodstrone($id){    // METODA KTÓRA USUWA PODSTRONĘ
    if ($_GET['usun'] == $id) {
        include('../cfg.php');
        $query = "DELETE FROM page_list WHERE id = $id LIMIT 1";  // ZAPYTANIE KTÓRE USUWA WYBRANY WERS W BAZIE DANYCH 
        mysqli_query($link, $query);
        echo "<script>";
        echo "alert('Podstrona została usunięta');";
        echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
        echo "</script>";
    }
}


function DodajPodstrone(){    // METODA KTÓRA DODAJE PODSTRONĘ
if (empty($_GET['dodaj'])) {
    include('../cfg.php');
    $tytul = '';   // DEKLARACJA ZMIENNEJ
    $tresc = '';   // DEKLARACJA ZMIENNEJ
    $wynik = '
            <form method="post" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
                <input type="text" name="tytul" value="' . $tytul . '" />
                <textarea style="width:60%; height: 30%" name="tresc" value="' . $tresc . '"></textarea>
                <input type="checkbox" name="status" value=""/>
                <input type="submit" name="add" value="Dodaj" style="background-color: rgb(31, 231, 0)"/>
        ';
    if (isset($_POST['add'])) {   // PODOBNIE JAK W METODZIE EDYTUJ PODSTRONĘ
        $tytul = $_POST['tytul'];
        $tresc = $_POST['tresc'];
        $status = isset($_POST['status']) ? 1 : 0;
        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$tytul', '$tresc', '$status') LIMIT 1";
        if (mysqli_query($link, $query)) {
            echo "<script>";
            echo "alert('Podstrona została dodana');";
            echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert('Podstrona nie została dodana');";
            echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
            echo "</script>";
        }
        }
        return $wynik;
        }
    }




//-------------------------------------- SEKCJA Z METODAMI DO ZARZĄDZANIA KATEGORIAMI------------------------------------//
function DodajKategorie(){  
    if (empty($_GET['dodajkategorie'])) {  // METODA DO DODAWANIA KATEGORII
        include('../cfg.php');
        $matka = '';
        $nazwa = '';
        $wynik = '
                <form method="post" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
                    <input type="text" name="matka" value="' . $matka . '" />
                    <textarea name="nazwa" value="' . $nazwa . '"></textarea>
                    <input type="submit" style="background-color: rgb(31, 231, 0)" name="addkat" value="Dodaj kategorie"/>
            ';
        if (isset($_POST['addkat'])) {
            $matka = $_POST['matka'];
            $nazwa = $_POST['nazwa'];
            $query = "INSERT INTO kategorie (matka, nazwa) VALUES ('$matka', '$nazwa') LIMIT 1"; // WSTAWIENIE DO BAZY DANYCH REKORDU
            if (mysqli_query($link, $query)) {
                echo "<script>";
                echo "alert('Kategoria została dodana');";
                echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
                echo "</script>";
            } else {
                echo "<script>";
                echo "alert('Kategoria nie została dodana');";
                echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
                echo "</script>";
            }
            }
            // POTWIERDZENIE WYKONANIA OPERACJI
            return $wynik;
            }
        };

function ListaKategori() // METODA DO WYŚWIETLENIE LISTY KATEGORII
{
    include('../cfg.php');

    $query="Select * FROM kategorie WHERE matka=0";  // ZAPYTANIE DO BAZY DANYCH
    $result = mysqli_query($link, $query);
    $wynik = '<h1>Lista Kategori: </h1></br>';


    while($row = mysqli_fetch_array($result)){

        $id = $row['id'];

        $child_query="Select * FROM kategorie WHERE matka=$id";
        $child_category = mysqli_query($link, $child_query);


        $wynik .= '
        <h2>' . $row['id'] . '
        ' . $row['nazwa'].'
            <a href="panel.php?edytujkategorie=' . $row['id'] . '"><button class="btn" style="background-color: rgb(238, 177, 56)">Edytuj</button></a>
            <a href="panel.php?usunkategorie=' . $row['id'] . '"><button class="btn" style="background-color: rgb(255, 98, 98)">Usuń</button></a> <br /></h2>
        ';

        while($child_row = mysqli_fetch_array($child_category)){
            $child_id = $child_row['id'];
            $child_parent = $child_row['matka'];
            $child_name = $child_row['nazwa'];
            $wynik .= '
            <h4 style="margin-left: 30px">'. $child_id . '
            ' .$child_name.'

            <a href="panel.php?edytujkategorie=' . $child_id . '"><button class="btn" style="background-color: rgb(238, 177, 56)">Edytuj</button></a>
            <a href="panel.php?usunkategorie=' . $child_id . '"><button class="btn" style="background-color: rgb(255, 98, 98)">Usuń</button></a> <br /></h4>';
        }
    }

    $wynik .= '<a href="panel.php?dodajkategorie"><button class="btn" style="background-color: rgb(31, 231, 0)">Dodaj kategorie</button></a>';

    return $wynik;

}

function UsunKategorie($id){   // METODA DO USUWANIA WYBRANEJ KATEGORII
    if ($_GET['usunkategorie'] == $id) {
        include('../cfg.php');
        $query = "DELETE FROM kategorie WHERE id = $id LIMIT 1";
        mysqli_query($link, $query);
        echo "<script>";
        echo "alert('Kategoria została usunięta');";
        echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
        echo "</script>";
    }


}


function EdytujKategorie($id){  // METODA DO EDYCJI KATEGORII
    if ($_GET['edytujkategorie'] == $id){
        include('../cfg.php');
        $wynik = '';
        $query = "SELECT * FROM kategorie WHERE id = $id LIMIT 1";
        $result = mysqli_query($link, $query);
        
        $row = mysqli_fetch_array($result);

        $wynik .= '
                <form method="post" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
                <input type="text" name="matka" value="' . $row['matka'] . '">
                <textarea name="nazwa"> ' . $row['nazwa'] . '</textarea>
                <input type="submit" name="savekat" value="Zapisz" style="background-color: rgb(31, 231, 0)"/>
        ';

        if (isset($_POST['savekat'])) {
            $matka = $_POST['matka'];
            $nazwa = $_POST['nazwa'];
            $query = "UPDATE kategorie SET matka = '$matka', nazwa = '$nazwa' WHERE id = $id LIMIT 1";
            if (mysqli_query($link, $query)) {
                echo "<script>";
                echo "alert('Kategoria została zaktualizowana');";
                echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
                echo "</script>";
            } else {
                echo "<script>";
                echo "alert('Kategoria nie została zaktualizowana');";
                echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
                echo "</script>";
            }
        }
        return $wynik;
    }
}

//--------------------------------------------------------------------------------------------------------

function PokazProdukty() // METODA DO WYŚWIETLENIE LISTY PRODUKTÓW
{
    include('../cfg.php');

    $query="Select * FROM produkty";  // ZAPYTANIE DO BAZY DANYCH
    $result = mysqli_query($link, $query);

    $wynik = '<h1>Lista Produktów: </h1></br>
    <table>
    <style>
        th, tr, td{
            width: 100vw;
            text-align: center;
            margin: 10px;
            border: 2px dashed;
        }
        img{
            height: 100px;
            width: 100px;
        }
        th{
            background-color: lightgreen;
        }
        button{
            cursor: pointer;
        }
    </style>
        <thead>
            <tr>
                <th><h2>id</h2></th>
                <th><h2>tytuł</h2></th>
                <th><h2>opis</h2></th>
                <th><h2>data utworzenia</h2></th>
                <th><h2>data modyfikacji</h2></th>
                <th><h2>data wygaśnięcia</h2></th>
                <th><h2>cena netto</h2></th>
                <th><h2>podatek vat</h2></th>
                <th><h2>ilość</h2></th>
                <th><h2>status</h2></th>
                <th><h2>kategoria</h2></th>
                <th><h2>gabaryt</h2></th>
                <th><h2>zdjęcie</h2></td>
                <th><h2>akcje</h2></td>
            </tr>
        </thead>
        <tbody>
        
 ';

    while($row = mysqli_fetch_array($result))
    {
        $wynik .= '<tr>
        <td>' . $row['id'] . '</td>
        <td>' . $row['tytuł'].'</td>
        <td>' . $row['opis'].'</td>
        <td>' . $row['data_utworzenia'].'</td>
        <td>' . $row['data_modyfikacji'].'</td>
        <td>' . $row['data_wygaśnięcia'].'</td>
        <td>' . $row['cena_netto'].'</td>
        <td>' . $row['podatek_vat'].'</td>
        <td>' . $row['ilość'].'</td>
        <td>' . $row['status'].'</td>
        <td>' . $row['kategoria'].'</td>
        <td>' . $row['gabaryt'].'</td>
        <td><img src="' . $row['zdjęcie']. '"></td>

        <td><a href="panel.php?edytujprodukt=' . $row['id'] . '"><button class="btn" style="background-color: rgb(238, 177, 56); margin-bottom: 5px">Edytuj</button></a> 
        <a href="panel.php?usunprodukt=' . $row['id'] . '"><button class="btn" style="background-color: rgb(255, 98, 98); margin-bottom: 5px">Usuń</button></a> <br />
        <a href="panel.php?dodajdokoszyka=' .$row['id'] . '"><button class="btn" style="background-color: yellow; margin-bottom: 5px">Dodaj do koszyka</button></a>
        </h2></td></tr>
        ';
    }

    $wynik .= '</tbody></table><a href="panel.php?dodajprodukt"><button class="btn" style="background-color: rgb(31, 231, 0); margin-bottom: 60px; margin-left: 50%; transform: translateX(-50%); margin-top: 30px; font-size: 15px">Dodaj nowy produkt</button></a>';

    return $wynik;
}


function DodajProdukt(){      // METODA DO DODAWANIA KATEGORII
    if (empty($_GET['dodajprodukt'])) {  
        include('../cfg.php');
        $tytuł = '';
        $opis = '';
        $data_utworzenia = '';
        $data_modyfikacji = '';
        $data_wygaśnięcia = '';
        $cena_netto = '';
        $podatek_vat = '';
        $ilość = '';
        $status = '';
        $kategoria = '';
        $gabaryt = '';
        $zdjęcie = '';

        $wynik = '
        <style>
            input{
                width: 100px;
                height: 30px;
            }
            .title{
                text-align: center;
            }
            .space{
                margin-bottom: 300px;
            }
        </style>
            <p><h2 class="title">Dodawanie produktu</h2></p>
        <table>

            <thead>
                <tr>
                    <th>tytuł</th>
                    <th>opis</th>
                    <th>data utworzenia</th>
                    <th>data modyfikacji</th>
                    <th>data wygaśnięcia</th>
                    <th>cena netto</th>
                    <th>podatek vat</th>
                    <th>ilość</th>
                    <th>status</th>
                    <th>kategoria</th>
                    <th>gabaryt</th>
                    <th>zdjęcie</td>
                    <th>akcje</td>
                </tr>
            </thead>
            <tbody>';

        
        
        $wynik .= '
                <form method="post" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
                    <tr><td><input type="text" name="tytuł" value="' . $tytuł . '" /></td>
                    <td><textarea name="opis" value="' . $opis . '"></textarea></td>
                    <td><input type="date" name="data_utworzenia" value="' . $data_utworzenia . '" /></td>
                    <td><input type="date" name="data_modyfikacji" value="' . $data_modyfikacji . '" /></td>
                    <td><input type="date" name="data_wygaśnięcia" value="' . $data_wygaśnięcia . '" /></td>
                    <td><input type="text" name="cena_netto" value="' . $cena_netto . '" /></td>
                    <td><input type="text" name="podatek_vat" value="' . $podatek_vat . '" /></td>
                    <td><input type="text" name="ilość" value="' . $ilość . '" /></td>
                    <td><input type="text" name="status" value="' . $status . '" /></td>
                    <td><input type="text" name="kategoria" value="' . $kategoria . '" /></td>
                    <td><input type="text" name="gabaryt" value="' . $gabaryt . '" /></td>
                    <td><input type="text" name="zdjęcie" value="' . $zdjęcie . '" /></td>

                    <td><input type="submit" style="background-color: rgb(31, 231, 0)" name="addprodukt" value="DodajProdukt"/></td></tr></table><p class="space"></p>
            ';
        if (isset($_POST['addprodukt'])) {
            $tytuł = $_POST['tytuł'];
            $opis = $_POST['opis'];
            $data_utworzenia = $_POST['data_utworzenia'];
            $data_modyfikacji = $_POST['data_modyfikacji'];
            $data_wygaśnięcia = $_POST['data_wygaśnięcia'];
            $cena_netto = $_POST['cena_netto'];
            $podatek_vat = $_POST['podatek_vat'];
            $ilość = $_POST['ilość'];
            $status = $_POST['status'];
            $kategoria = $_POST['kategoria'];
            $gabaryt = $_POST['gabaryt'];
            $zdjęcie = $_POST['zdjęcie'];


            $query = "INSERT INTO produkty (tytuł, opis, data_utworzenia, data_modyfikacji, data_wygaśnięcia, cena_netto, podatek_vat, ilość, status, kategoria, gabaryt, zdjęcie) VALUES ('$tytuł', '$opis', '$data_utworzenia', '$data_modyfikacji', '$data_wygaśnięcia', '$cena_netto', '$podatek_vat', '$ilość', '$status', '$kategoria', '$gabaryt', '$zdjęcie') LIMIT 1"; 
            // WSTAWIENIE DO BAZY DANYCH REKORDU
            
            
            if (mysqli_query($link, $query)) {
                echo "<script>";
                echo "alert('Produkt został dodany');";
                echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
                echo "</script>" ;
            } else {
                echo "<script>";
                echo "alert('Produkt nie został dodany');";
                echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
                echo "</script>" ;
            }
            // POTWIERDZENIE WYKONANIA OPERACJI
            }
            return $wynik;
        };
    }

function UsunProdukt($id){   // METODA DO USUWANIA WYBRANEJ KATEGORII
    if ($_GET['usunprodukt'] == $id) {
        include('../cfg.php');
        $query = "DELETE FROM produkty WHERE id = $id LIMIT 1";
        mysqli_query($link, $query);
        echo "<script>";
        echo "alert('Produkt został usunięty');";
        echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
        echo "</script>" ;
    }
}

function EdytujProdukt($id){  // METODA DO EDYCJI KATEGORII
    if ($_GET['edytujprodukt'] == $id){
        include('../cfg.php');
        $query = "SELECT * FROM produkty WHERE id = $id LIMIT 1";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

        $wynik = '
        <p class="space2"><h2>Aktualizauj produkt</h2></p>
        <table>
        <style>
            input{
                width: 100px;
                height: 30px;
            }  
            .title{
                text-align: center;
            }
            .space2{
                margin-top:200px;
            }
            textarea{
                height: 60px;
            }
        </style>

            <thead>
                <tr>
                    <th>tytuł</th>
                    <th>opis</th>
                    <th>data utworzenia</th>
                    <th>data modyfikacji</th>
                    <th>data wygaśnięcia</th>
                    <th>cena netto</th>
                    <th>podatek vat</th>
                    <th>ilość</th>
                    <th>status></th>
                    <th>kategoria</th>
                    <th>gabaryt</th>
                    <th>zdjęcie</td>
                    <th>akcje</td>
                </tr>
            </thead>
            <tbody>';

        $wynik .= '
                <form method="post" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
                <tr><td><input type="text" name="tytuł" value="' . $row['tytuł'] . '" /></td>
                    <td><textarea name="opis">' . $row['opis'] . '</textarea></td>
                    <td><input type="date" name="data_utworzenia" value="' . $row['data_utworzenia'] . '" /></td>
                    <td><input type="date" name="data_modyfikacji" value="' . $row['data_modyfikacji'] . '" /></td>
                    <td><input type="date" name="data_wygaśnięcia" value="' . $row['data_wygaśnięcia'] . '" /></td>
                    <td><input type="text" name="cena_netto" value="' . $row['cena_netto'] . '" /></td>
                    <td><input type="text" name="podatek_vat" value="' . $row['podatek_vat'] . '" /></td>
                    <td><input type="text" name="ilość" value="' . $row['ilość'] . '" /></td>
                    <td><input type="text" name="status" value="' . $row['status'] . '" /></td>
                    <td><input type="text" name="kategoria" value="' . $row['kategoria'] . '" /></td>
                    <td><input type="text" name="gabaryt" value="' . $row['gabaryt'] . '" /></td>
                    <td><input type="text" name="zdjęcie" value="' . $row['zdjęcie'] . '" /></td>

                    <td><input type="submit" name="saveprodukt" value="Zapisz" style="background-color: rgb(31, 231, 0)"/></td></tr></table><p class="space2"></p>
        ';

        if (isset($_POST['saveprodukt'])) {
            $tytuł = $_POST['tytuł'];
            $opis = $_POST['opis'];
            $data_utworzenia = $_POST['data_utworzenia'];
            $data_modyfikacji = $_POST['data_modyfikacji'];
            $data_wygaśnięcia = $_POST['data_wygaśnięcia'];
            $cena_netto = $_POST['cena_netto'];
            $podatek_vat = $_POST['podatek_vat'];
            $ilość = $_POST['ilość'];
            $status = $_POST['status'];
            $kategoria = $_POST['kategoria'];
            $gabaryt = $_POST['gabaryt'];
            $zdjęcie = $_POST['zdjęcie'];


            $query = "UPDATE produkty SET tytuł = '$tytuł', opis = '$opis', data_utworzenia = '$data_utworzenia', data_modyfikacji = '$data_modyfikacji', data_wygaśnięcia = '$data_wygaśnięcia', cena_netto = '$cena_netto', podatek_vat = '$podatek_vat', ilość = '$ilość', status = '$status', kategoria = '$kategoria', gabaryt = '$gabaryt', zdjęcie = '$zdjęcie' 
            WHERE id = $id LIMIT 1";


            if (mysqli_query($link, $query)) {
                echo "<script>";
                echo "alert('Produkt został zaktualizowany ');";
                echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
                echo "</script>";
            } else {
                echo "<script>";
                echo "alert('Produkt nie został zaktualizowany ');";
                echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
                echo "</script>";
            }
        }
        return $wynik;
    }
}

//-----------------------KOSZYK--------------------------------------------------------------------


function addToCart($id){
    include('../cfg.php');
    if ($_GET['dodajdokoszyka'] == $id){

        if(!isset($_SESSION['count'])){
            $_SESSION['count'] = 1;
        }
        else {
            $_SESSION['count'] ++;
        }

        $query = "SELECT tytuł, cena_netto, podatek_vat, zdjęcie FROM produkty WHERE id=$id";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

        $cena = ($row['cena_netto'] + $row['cena_netto'] * $row['podatek_vat'] / 100);

        $nr = $_SESSION['count'];

        $prod[$nr]['tytuł'] = $row['tytuł'];
        $prod[$nr]['cena'] = $cena;
        $prod[$nr]['zdjęcie'] = $row['zdjęcie'];

        $nr_1 = $nr.'_1';
        $nr_2 = $nr.'_2';
        $nr_3 = $nr.'_3';
        $nr_4 = $nr.'_4';

        $_SESSION[$nr_1] = $nr;
        $_SESSION[$nr_2] = $prod[$nr]['tytuł'];
        $_SESSION[$nr_3] = $prod[$nr]['cena'];
        $_SESSION[$nr_4] = $prod[$nr]['zdjęcie'];

        echo "<script>";
        echo "alert('Produkt został dodany do koszyka');";
        echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
        echo "</script>" ; 
    }
}

function showCart(){
    if (isset($_SESSION['count'])){
        $suma = 0;
        $wynik = "
        <style>
            .cartimg{
                width: 50px; 
                height: 50px;
            }
            .cart{
                width: 40%;
                margin-left: 50%;
                transform: translateX(-50%);
            }
        </style>
        <table class='cart'><thead>
            <th>id</th>
            <th>zdjęcie</th>
            <th>Nazwa</th>
            <th>cena</th>
            <th></th>
        </thead>";

        for($i=1; $i <= $_SESSION['count']; $i++){
            $nr_1 = '_1';
            $nr_4 = '_4';
            $nr_2 = '_2';
            $nr_3 = '_3';
            
            $suma = $suma + $_SESSION[$i . $nr_3];
            $_SESSION['suma'] = $suma;
            

            $wynik .='
            <form method="post" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
            <tr>
                <td>'.$_SESSION[$i . $nr_1].'</td>
                <td><img class="cartimg" src="'.$_SESSION[$i . $nr_4].'"></td>
                <td>'.$_SESSION[$i . $nr_2].'</td>
                <td>'.$_SESSION[$i . $nr_3].'</td>
                <td><a href="panel.php?usunzkoszyka='.$_SESSION[$i . $nr_1].'">Usuń</a></td>
            </tr>
            ';
        }

        $wynik .='</table><h2 style="text-align: center">Razem do zapłaty: '.$suma.' zł</h2>';

        return $wynik;
    }
    else {
        echo "
        <style>
            .cartheader{
                margin-left: 50%;
                transform: translateX(-20%);
            }
        </style>
        <h1 class='cartheader'>Koszyk jest pusty<h1>";
    }
}


    function removeFromCart($id){
        if ($_GET['usunzkoszyka'] == $id){
            $_SESSION['suma'] -= $_SESSION[$id . '_3'];
            unset($_SESSION[$id]);
            $_SESSION['count']--;
            
            echo "<script>";
            echo "alert('Usunięto przedmiot z koszyka');";
            echo "window.location = 'http://localhost/myProject/Projekt1/admin/panel.php';";
            echo "</script>" ; 
        }
    }
                
?>