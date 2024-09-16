<?php
//timto nacteme soubor pages.php
require "pages.php";
//pokud stranka po kliknuti existuje, zobrazi se zvolena stranka
if (array_key_exists("page", $_GET)) {
	$page = $_GET["page"];

	//tady vznika zaklad pro 404 (stranka neexistuje)
	//kontrola, zda stranka existuje
	if (array_key_exists($page, $pageList) == false) {
		//stranka neexistuje
		$page = "404";

		//odeslat informaci i vyhledavaci (napr googlu) ze url neexistuje
		//aby ji prohlizec uz nenabizel k vyhledavani
		http_response_code(404);
	}
	//pokud otevreme stranky a jeste jsme nic nevybrali, automaticky se nacte stranka "home"
} else {
	$page = "home";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- 	v poli $pageList se zorientujeme podle vybrani $page a zeptame se na vlastnost title (titulke, co se objevi v paticce stranky vedle faviconu) -->
	<title><?php echo $pageList[$page]->title ?></title>

	<link rel="icon" type="image/x-icon" href="img/favicon.png">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="font-awsome/css/all.min.css">

	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/header.css">
	<link rel="stylesheet" href="css/section.css">
	<link rel="stylesheet" href="css/footer.css">
</head>

<body>
	<header>
		<menu>
			<!-- parametry "container" se budou vztahovat na cely web, proto se budou stylovat v "style.css" -->
			<div class="container">

				<a href="./arcade.html" class="logo">
					<img class="sunTrans" src="img/sun-trans.png" alt="Logo The_Darkades" width="150px">
					<div class="arcade">>> P L A Y</div>
				</a>


				<!-- 		neoteviram zalozky pomoi html, ale php (?page=zalozka) -->
				<nav>
					<ul>
						<?php
						//chceme prochat pole $pageList as $pageId ("home") => $pageInstant (instance stranky neboli objekt = new Page("home", "The_Darkades", "H O M E"),)
						foreach ($pageList as $pageId => $pageInstant) {
							/*a tohle nam zpusobi, ze polozka v menu se zobrazi pouze pokud existuje (jinak bychom mohli kliknout i na 404)*/
							if ($pageInstant->menu != "") {
								echo "<li><a href='$pageInstant->id'> $pageInstant->menu <img class='triangleForNav' src='img/triangle-neon.png'></a></li>";
							}
						}
						?>
					</ul>
				</nav>

			</div>
		</menu>

		<div class="header-video">
			<video autoplay muted loop src="video/synthwave_video.mp4"></video>
		</div>

		<div class="title">
			<a href="./arcade.html">
				<h2>T H E _ D A R K A D E S</h2>
			</a>
			<h3>T H E _ L O V E , T H E _ T A P E</h3>
			<div class="social">
				<a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook"></i></a>
				<a href="https://www.instagram.com/the_darkades/?igsh=ZG9henMza3Nhdm13&utm_source=qr" target="_blank"><i class="fa-brands fa-instagram"></i></a>
				<a href="https://www.youtube.com/" target="_blank"><i class="fa-brands fa-youtube"></i></a>
				<a href="https://open.spotify.com/artist/6GlCpduoIxanI5KFSfo6GF?si=bawS8TpIRqyrMBE7Jx-2RQ" target="_blank"><i class="fa-brands fa-spotify"></i></a>
				<a href="https://music.apple.com/us/album/i-n-t-i-c-o-1-9-8-2/1755750125?i=1755750127" target="_blank"><i class="fa-brands fa-apple"></i></a>
				<a href="contact" target="_blank"><i class="fa-solid fa-envelope"></i></a>
			</div>
		</div>
	</header>

	<section id="sect">
		<?php
		//toto echo slouzi k tomu, pokud chceme vypsat napr gallery, nebo cokoli jineho na co klikneme, tak se to vybere
		echo $pageList[$page]->getContent();
		?>
	</section>

	<footer>

		<div class="container">
			<nav>
				<h3>M E N U</h3>
				<ul>
					<?php
					//chceme prochat pole $pageList as $pageId ("home") => $pageInstant (instance stranky neboli objekt = new Page("home", "The_Darkades", "H O M E"),)
					foreach ($pageList as $pageId => $pageInstant) {
						/*a tohle nam zpusobi, ze polozka v menu se zobrazi pouze pokud existuje (jinak bychom mohli kliknout i na 404)*/
						if ($pageInstant->menu != "") {
							echo "<li><a href='$pageInstant->id'>$pageInstant->menu</a></li>";
						}
					}
					?>
				</ul>
			</nav>

			<div class="contact">
				<h3>C O N T A C T</h3>
				<address>
					<a href="https://g.co/kgs/LHUuRjH" target="_blank">
						1111 S. Figueroa Street,<br>
						Los Angeles,<br>
						California,<br>
						90015
					</a>
				</address>

			</div>


		</div>

	</footer>
	<!-- kurzor sipky, ktera nas vzdy dostane nahoru stranky -->
	<div id="up"><i class="fa-solid fa-angles-up"></i></i></div>

	<!-- 	nalinkovani js scriptu -->
	<script src="index.js"></script>

</body>

</html>