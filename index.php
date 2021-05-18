<?php
session_start();
if (isset($_SESSION['loggedin'])) {
	header('Location: main.php');
	exit;
}
?>

<!DOCTYPE html>
<html lang="lv" dir="ltr">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/style/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
		<script type="text/javascript" src="/js/checkCaps.js"></script>
    <title>PRČ</title>
</head>

<body>
	<!-- Satura apvalks -->
    <div class="content-wrapper">
			<!-- Autentifikācijas apvalks -->
        <div class="authentication">

            <form class="authentication-form" action="/Functionality/authentication.php" method="post">
								<!-- Sadālas nosaukum -->
								  <h2>SELINUX</h2>
                <h2>AUTENTIFIKĀCIJA</h2>
								<!-- Lietotājvārds -->
                <input type="text" name="username" placeholder="Lietotājvārds" required>
								<!-- Parole -->
                <input type="password" name="password" id="myInput" placeholder="Parole" required>
								<!-- URL konteineris priekš reģistrācijas un paroles atgriešanas -->

                <button type="submit" name="button">IENĀKT</button>

        </div>
        </form>
    </div>
</body>

</html>
