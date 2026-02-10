<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';

$vorname = isset($_POST['vorname']) ? trim($_POST['vorname']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$geschlecht = isset($_POST['geschlecht']) ? trim($_POST['geschlecht']) : '';

if (empty($vorname) || empty($email)) {
    echo "Bitte fülle alle erforderlichen Felder aus.";
    exit;
}

$con = mysqli_connect("10.35.233.7:3306", "k218479_anne_newsletter", "anne_newsletter_PW!", "k218479_vokabeltrainer_anne_newsletter");
if (!$con) {
    die("Verbindung fehlgeschlagen: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8");

$sql = "INSERT INTO newsletter_sprachtacular_anmeldungen (vorname, email, geschlecht) 
        VALUES ('$vorname', '$email', '$geschlecht')";
mysqli_query($con, $sql);

if (mysqli_affected_rows($con) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Anmeldung Newsletter</title>
        <link rel="stylesheet" href="Eingebundene-CSS-Scripte/Vokabeltrainer-Style.css">
        <script src="Vokabeltrainer-Allgemeine-JSFunktionen.js"></script>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                margin: 0;
                padding: 0;
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
            }

            h1 {
                color: #2d6a4f;
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
                text-decoration: none;
            }

            .button:hover {
                background-color: #40916c;
            }

            .footer2 {
                font-size: 14px;
                color: #999999;
                margin-top: 20px;
            }

            .footer2 a {
                color: #2d6a4f;
                text-decoration: none;
            }

            .footer2 a:hover {
                text-decoration: underline;
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
            <h1>Danke für deine Anmeldung, <?php echo htmlspecialchars($vorname); ?>!</h1>
            <p>Du hast dich erfolgreich für den Sprachtacular-Newsletter angemeldet.</p>
            <p>Erhalte die neuesten Updates und spannende Informationen zu Sprachtacular direkt in dein Postfach.</p>
            <a href="Vokabeltrainer-Home.php" class="button">Zurück zur Startseite</a>
            <div class="footer2">
                Du hast dich erfolgreich angemeldet! Wenn du keine weiteren E-Mails mehr erhalten möchtest, kannst du dich jederzeit <a href="Vokabeltrainer-Newsletter-Abmeldung.php">hier abmelden</a>.
            </div>
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
    
} else {
    echo "Es gab ein Problem bei der Anmeldung. Bitte versuche es später erneut.";
}

mysqli_close($con);
?>