

<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Moje hobby</title>

		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link
			href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;700&family=Montserrat:wght@300;700&family=Nunito:wght@300&family=Raleway:wght@400;800&display=swap"
			rel="stylesheet"
		/>

		<script
			src="https://kit.fontawesome.com/b5129f6c17.js"
			crossorigin="anonymous"
		></script>

		<link rel="stylesheet" href="./css/style.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

		<script
		src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
		crossorigin="anonymous"
		></script>
		
	</head>


	<body>
		<style>
			.admin_btn{
				position: absolute;
				right: -520px;
				top: -90px;
				height: 30px;
				width: 50px;
				background-color: black;
				cursor: pointer;
				color: white;
				border: 1px solid red;
			}
		</style>
		<header>
			
			<div class="header-img">
				<div class="header-text">
				<a href="http://localhost/myProject/Projekt1/admin/admin.php" target="_blank"><button class="admin_btn">admin</button></a>
					<h1>Wędkarstwo</h1>
					<p>czyli to co kocham!</p>
				</div>
				<div class="header-bg">
					<div class="clock">
						<div class="hand hour" data-hour-hand></div>
						<div class="hand minute" data-minute-hand></div>
						<div class="hand second" data-second-hand></div>
						<div class="number number1">1</div>
						<div class="number number2">2</div>
						<div class="number number3">3</div>
						<div class="number number4">4</div>
						<div class="number number5">5</div>
						<div class="number number6">6</div>
						<div class="number number7">7</div>
						<div class="number number8">8</div>
						<div class="number number9">9</div>
						<div class="number number10">10</div>
						<div class="number number11">11</div>
						<div class="number number12">12</div>
					</div>
				</div>
			</div>
		</header>

		<nav>
			<div class="wrapper">
				<button class="burger-icon"><i class="fa-solid fa-bars"></i></button>
				<div class="nav-items">
					<a href="?idp=omnie">o mnie</a>
					<a href="?idp=sprzet">Akcesoria</a>
					<a href="?idp=ryby">ryby</a>
					<a href="?idp=galeria">galeria</a>
					<a href="?idp=filmy">filmy</a>
					<a href="?idp=kontakt">kontakt</a>
				</div>
			</div>
		</nav>
		<?php
			error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
			if($_GET['idp'] == '') $strona = 1;
			if($_GET['idp'] == 'omnie') $strona = 1;
			if($_GET['idp'] == 'galeria') $strona = 4;
			if($_GET['idp'] == 'kontakt') $strona = 6;
			if($_GET['idp'] == 'ryby') $strona = 3;
			if($_GET['idp'] == 'sprzet') $strona = 2;
			if($_GET['idp'] == 'filmy') $strona = 5;

		?>


		<?php
			include('cfg.php');
			include('showpage.php');
			echo PokazPodstrone($strona);
		?>

		

		<footer>
			<p>
				<?php
    				$nr_indeksu = '162430';
    				$nr_grupy = '2';
    				echo "Krystian Kierklo $nr_indeksu, jestem z grupy numer $nr_grupy <br />";
				?>
			</p>
		</footer>
		<script src="./js/skrypty.js"></script>
	</body>
</html>
