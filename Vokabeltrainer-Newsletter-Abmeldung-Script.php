<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';

$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if (empty($email)) {
    echo "Bitte fülle das Email-Feld aus.";
    exit;
}

$con = mysqli_connect("10.35.233.7:3306", "k218479_anne_newsletter", "anne_newsletter_PW!", "k218479_vokabeltrainer_anne_newsletter");
if (!$con) {
    die("Verbindung fehlgeschlagen: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8");

$sql_check = "SELECT email FROM newsletter_sprachtacular_anmeldungen WHERE email = ?";
$stmt_check = mysqli_prepare($con, $sql_check);
mysqli_stmt_bind_param($stmt_check, 's', $email);
mysqli_stmt_execute($stmt_check);
mysqli_stmt_store_result($stmt_check);

if (mysqli_stmt_num_rows($stmt_check) === 0) {
    mysqli_stmt_close($stmt_check);
    mysqli_close($con);
    ?>
    <!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Newsletter Abmeldung</title>
        <link rel="stylesheet" href="Eingebundene-CSS-Scripte/Vokabeltrainer-Style.css">
        <script src="Vokabeltrainer-Allgemeine-JSFunktionen.js"></script>
        <style>
            body {
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            .container {
                width: 100%;
                max-width: 600px;
                background-color: #ffffff;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                text-align: center;
                margin: auto;
                display: flex;
                flex-direction: column;
                justify-content: center;
                height: 400px;
            }

            h1 {
                color: #f44336;
                font-size: 28px;
                margin-bottom: 20px;
            }

            p {
                color: #000000;
                font-size: 18px;
                line-height: 1.6;
                margin-bottom: 30px;
            }

            .button {
                background-color: #f44336;
                color: #ffffff;
                border: none;
                padding: 15px 25px;
                text-align: center;
                display: inline-block;
                font-size: 18px;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .button:hover {
                background-color: #e53935;
            }

            .footer p {
                color: #666666;
                font-size: 18px;
                line-height: 1.6;
                margin-bottom: 30px;
            }

            .copyright-satz {
                color: #000000;
                font-size: 18px;
            }
        </style>
    </head>
    <body>
        <div class="navbar">
            <a href="Vokabeltrainer-Home.php" class="logo">
                <img src="Eingebundene-Bilder/Vokabeltrainer-Logo.png" alt="Vokabeltrainer Logo">
            </a>

            <div class="links">
                <a href="Vokabeltrainer-Home.php">Home</a>
				<a href="Vokabeltrainer-Vokabeln-Abfragemodus.php">Vokabeln üben</a>
				<a href="Vokabeltrainer-Tests.php">Tests</a>
				<a href="Vokabeltrainer-FAQ.php">FAQ</a>
            </div>
            
            <div class="auth">
                <div id="login-logout-link"></div>
            </div>
        </div>

        <br>
        <br>
        <div class="container">
            <h1>Fehler</h1>
            <p>Diese E-Mail-Adresse ist nicht in unserer Datenbank registriert.</p>
            <a href="Vokabeltrainer-Newsletter-Anmeldung.php" class="button">Zurück zur Anmeldung</a>
        </div>
        <br>
        <br>

        <div class="footer">
            <p class="copyright-satz">&copy Alle Rechte vorbehalten | Anne Kämmerer | Version: <?php echo $version; ?></p>

            <div class="footerlinks">
                <a href="Vokabeltrainer-Datenschutz.php">Datenschutz |</a>
                <a href="Vokabeltrainer-Impressum.php"> Impressum |</a>
                <a href="Vokabeltrainer-FAQ.php"> FAQ</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

mysqli_stmt_close($stmt_check);
$sql_delete = "DELETE FROM newsletter_sprachtacular_anmeldungen WHERE email = ?";
$stmt_delete = mysqli_prepare($con, $sql_delete);
mysqli_stmt_bind_param($stmt_delete, 's', $email);

if (mysqli_stmt_execute($stmt_delete)) {
    ?>
    <!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Erfolgreiche Abmeldung</title>
        <link rel="stylesheet" href="Eingebundene-CSS-Scripte/Vokabeltrainer-Style.css">
        <style>
            body {
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            .container {
                width: 100%;
                max-width: 600px;
                background-color: #ffffff;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                text-align: center;
                margin: auto;
                display: flex;
                flex-direction: column;
                justify-content: center;
                height: 400px; /* Feste Höhe */
            }

            h1 {
                color: #2d6a4f;
                font-size: 28px;
                margin-bottom: 20px;
            }

            p {
                color: #666666;
                font-size: 18px;
                line-height: 1.6;
                margin-bottom: 30px;
            }

            .button {
                background-color: #2d6a4f;
                color: #ffffff;
                border: none;
                padding: 15px 25px;
                text-align: center;
                display: inline-block;
                font-size: 18px;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .button:hover {
                background-color: #40916c;
            }

            .copyright-satz {
                color: #000000;
                font-size: 18px;
            }
        </style>
    </head>
    <body>
        <div class="navbar">
            <a href="Vokabeltrainer-Home.php" class="logo">
                <img src="Eingebundene-Bilder/Vokabeltrainer-Logo.png" alt="Vokabeltrainer Logo">
            </a>
            
            <div class="links">
                <a href="Vokabeltrainer-Home.php">Home</a>
                <a href="Vokabeltrainer-Vokabeln-Lernmodus.php">Vokabeln üben</a>
                <a href="Vokabeltrainer-Tests.php">Tests</a>
                <a href="Vokabeltrainer-FAQ.php">FAQ</a>
            </div>
            
            <div class="auth">
                <div id="login-logout-link"></div>
            </div>
        </div>

        <div class="container">
            <h1>Du hast dich erfolgreich abgemeldet!</h1>
            <p>Du erhältst nun keine Benachrichtigungen mehr von uns.</p>
            <p>Wenn du es dir anders überlegst, kannst du dich jederzeit erneut anmelden.</p>
            <a href="Vokabeltrainer-Newsletter-Anmeldung.php" class="button">Zurück zur Anmeldung</a>
        </div>

        <div class="footer">
            <p class="copyright-satz">&copy Alle Rechte vorbehalten | Anne Kämmerer | Version: <?php echo $version; ?></p>

            <div class="footerlinks">
				<a href="Vokabeltrainer-Datenschutz.php">Datenschutz |</a>
				<a href="Vokabeltrainer-Impressum.php"> Impressum |</a>
				<a href="Vokabeltrainer-FAQ.php"> FAQ |</a>
				<a href="Vokabeltrainer-Feedback.php"> Feedback</a>
        </div>
        </div>


    </body>
    </html>
    <?php
} else {
    echo "Es gab ein Problem bei der Abmeldung. Bitte versuche es später erneut.";
}

mysqli_stmt_close($stmt_delete);
mysqli_close($con);
?>