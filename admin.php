<?php
//abychom mohli v administraci vyuzivat seznam stranek - tj. $pageList, musime si zde nacist php skript "pages.php"
require "pages.php";

//ulozeni informace, ze je uzivatel prihlasen
session_start();

$error = "";

//zpracovani prihlasovacio formulare
if (array_key_exists("sign-up", $_POST)) {
	$username = $_POST["username"];
	$password = $_POST["password"];

	if ($username == "admin" && $password == "1234") {
		//uzivatel zadal platne prihl. udaje
		$_SESSION["signedUsername"] = $username;
	} else {
		//spatne prihl. udaje
		$error = "Wrong username or password";
	}
}

//zpracovani odhlasovaciho formulare
if (array_key_exists("sign-out", $_POST)) {
	unset($_SESSION["signedUsername"]);
	//presmerovani stranky, aby se po refresh neodeslal formular znovu
	header("Location:?");
}

// zpracovani akci v administraci je pouze pro prihlasene uzivatele
if (array_key_exists("signedUsername", $_SESSION)) {
	// promenna predstavujici stranku s kterou zrovna editujeme
	$actualPageInstant = null;

	// zpracovani vyberu aktualni stranky
	if (array_key_exists("page", $_GET)) {
		$pageId = $_GET["page"];
		$actualPageInstant = $pageList[$pageId];
	}

	// zpracovani formulare pro ulozeni do rootu html pomoci funkce setContent, vytvořené ve skriptu pages.php
	if (array_key_exists("save", $_POST)) {
		$content = $_POST["content"];
		$actualPageInstant->setContent($content);
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin</title>
	<link rel="stylesheet" href="font-awsome/css/all.min.css">

	<!-- 	bootstrap knihovna pro css vizualizace nastylovani administrace -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<link rel="stylesheet" href="css/admin.css">
</head>

<body>
	<div class="admin-body">
		<?php
		//podminka pro zobrazeni formulare jen v pripade, ze neni uzivatel prihlsen (v promenne $_SESSION neni klic "signedUsername)
		//to znamena, ze po uspesnem prihlaseni se nam formular uz znovu neobevi
		if (array_key_exists("signedUsername", $_SESSION) == false) {
			//sekce pro neprihlasene uzivatele
		?>
			<main class="form-signin w-100 m-auto">
				<form method="post">
					<h1 style="color: white; font-size: 23px;" class="h3 mb-3 fw-normal">Please sign in</h1>

					<div class="form-floating">
						<input name="username" type="text" class="form-control" id="floatingInput" placeholder="login">
						<label for="floatingInput">Username</label>
					</div>
					<div class="form-floating">
						<input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
						<label for="floatingPassword">Password</label>
					</div>

					<button name="sign-up" class="btn btn-primary w-100 py-2" type="submit">Sign in</button>

					<?php if ($error != "") { ?>
						<div class="alert-alert">
							<div class="alert alert-danger" role="alert">
								<?php echo $error; ?>
							</div>
						<?php } ?>
				</form>
			</main>
		<?php

		} else {

			//sekce pro prihlasene uzivatele

			echo "<main class='admin'>";

		?>

			<div class="container">
				<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
					<div style="color: white;">W E L C O M E _ B A C K _ <?php echo $_SESSION["signedUsername"] ?></div>

					<div class="col-md-3 mb-2 mb-md-0"></div>
					<div class="col-md-3 text-end">
						<form method='post'><button class="btn btn-outline-primary me-2" name='sign-out'>Sign out</button></form>
					</div>
				</header>
			</div>

			<?php

			//vypiseme seznam stranek, ktere lze editovat
			echo "<ul class='list-group list-group-flush'>";
			foreach ($pageList as $pageId => $pageInstant) {
				echo
				"<li style='background-color: black;' class='list-group-item'>
					<a class='btn btn-outline-warning' href='?page=$pageInstant->id'>Edit page</a>
			
					<a class='btn btn-outline-warning' href='$pageInstant->id' target='_blank'>Open in browser</a>

					<span style='color: white;'>$pageInstant->id</span>
				</li>";
			}
			echo "</ul>";


			// editacni formular
			// zobbrazit pokud je nejaka stranka vybrana k editaci
			if ($actualPageInstant != null) {
				echo "<h1 style='color: white;'>Editing Page: $actualPageInstant->id</h1>";
			?>
				<form method="post">
					<textarea id="content" name="content" cols="80" rows="60">
					<?php
					//zde otevirame php pro automaticke vyplneni obsahu pomoci funkce "getContent" vytvořené ve skriptu pages.php
					//navic to obalime do funkce "hmtlspecialchars", aby se nam vsechen text objevil jako html
					echo htmlspecialchars($actualPageInstant->getContent());
					?>
				 </textarea>
					<br>
					<button style='width: 130px;' class='btn btn-outline-warning' name="save">Save</button>
				</form>

				<!-- 		nalinkovani tinymce(WYSIWYG), tak aby se vse v textarea v administraci neobjevilo jako html kod, ale jako originalni web. stranka -->
				<script src="vendor/tinymce/tinymce/tinymce.min.js"></script>
				<script type="text/javascript">
					tinymce.init({
						/* 			musime se odkazat pomoci id textarey */
						selector: '#content',
						verify_html: false,
						/* aby se v administraci objevil vzhled stranky jak ma byt, musime zde nalinkovat css soubory */
						content_css: [
							'css/reset.css',
							'css/section.css',
							'css/style.css',
							'font-awsome/css/all.min.css',
							'https://fonts.googleapis.com/css2?family=VT323&display=swap',
							'https://fonts.gstatic.com',
							'https://fonts.googleapis.com',
						],
						body_id: "sect",
						/* rozsireni moznosti editace v administraci */
						plugins: 'advlist anchor autolink charmap code colorpicker contextmenu directionality emoticons fullscreen hr image imagetools insertdatetime link lists nonbreaking noneditable pagebreak paste preview print save searchreplace tabfocus table textcolor textpattern visualchars',
						toolbar1: "insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor",
						toolbar2: "link unlink anchor | fontawesome | image media | responsivefilemanager | preview code",
						/* 					tlacitko na nahravani souboru bez pouziti url a jinych slozitosti tzn. velmi uzivatelsky privetive */
						external_plugins: {
							'responsivefilemanager': '<?php echo dirname($_SERVER['PHP_SELF']); ?>/vendor/primakurzy/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
						},
						external_filemanager_path: "<?php echo dirname($_SERVER['PHP_SELF']); ?>/vendor/primakurzy/responsivefilemanager/filemanager/",
						filemanager_title: "File manager",
					});
				</script>

		<?php
			}

			echo "</main>";
		}
		?>

		<!-- 	bootstrap knihovna pro javascript vizualizace nastylovani administrace -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	</div>
</body>

</html>