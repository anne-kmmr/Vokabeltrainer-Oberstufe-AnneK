<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impressum</title>
    <script src="Vokabeltrainer-Allgemeine-JSFunktionen.js"></script>
    <link rel="stylesheet" href="Eingebundene-CSS-Scripte/Vokabeltrainer-Style.css">
    <style>
    .impressum-container {
        background-color: #f0f5f0;
        color: #333;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
    }

    .impressum-container h1, .impressum-container h2, .impressum-container h3 {
        color: #006400;
    }

    .impressum-container a {
        color: #008000;
        text-decoration: underline;
    }

    .impressum-container ul {
        margin-left: 20px;
        list-style-type: disc;
    }

    .impressum-container p {
        line-height: 1.6;
        margin-bottom: 1em;
    }

    .copyright-satz {
        color: #000000;
        font-size: 18px;
    }
		.froschMaskottchen {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 80px;
            height: auto;
            z-index: 9999;
            cursor: pointer;
            border: none;
            background: none;
        }

        .info-box {
            position: fixed;
            bottom: 35px;
            right: 110px;
            background: white;
            color: #000;
            padding: 15px 20px;
            border: 2px solid #2d6a4f;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            opacity: 0;
            transition: opacity 0.5s;
            cursor: pointer;
            z-index: 1000;
            max-width: 300px;
        }

        .info-box.show {
            opacity: 1;
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
	
	<script src="Sonstige-Scripte-u.-Vokabeln/TooltipFunktion.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            showInfoBox("Ein bisschen zu viel Jura hier, oder? Schnell wieder weg...", 4000);

            const frosch = document.querySelector('.froschMaskottchen');
            if (frosch) {
            frosch.addEventListener('click', () => {
                showInfoBox("Ein bisschen zu viel Jura hier, oder? Schnell wieder weg...", 4000);
            });
            }
        });
        </script>

<div class="impressum-container">
    <h1>Impressum</h1>
    <br>

    <h2>Dieses Internetangebot wird herausgegeben von:</h2>
    <p>
        Anne Kämmerer<br>
        76829 Landau<br>
        <a href="mailto:annekaemmerer@gmx.de">annekaemmerer@gmx.de</a>
    </p>

    <br>
    <h3>Verantwortlich für den Inhalt dieser Webseite (Vertretungsberechtigt):</h3>
    <p>Anne Kämmerer</p>

    <br>
    <h3>Redaktion:</h3>
    <p>
        Anne Kämmerer<br>
        76829 Landau<br>
        <a href="mailto:annekaemmerer@gmx.de">annekaemmerer@gmx.de</a>
    </p>

    <br>
    <h3>Technische Umsetzung:</h3>
    <p>
        Anne Kämmerer<br>
        76829 Landau<br>
        <a href="mailto:annekaemmerer@gmx.de">annekaemmerer@gmx.de</a>
    </p>

    <br>
    <h3>Design:</h3>
    <p>
        Anne Kämmerer<br>
        76829 Landau<br>
        <a href="mailto:annekaemmerer@gmx.de">annekaemmerer@gmx.de</a>
    </p>
</div>
	<img src="Eingebundene-Bilder/Vokabeltrainer-Froschmaskottchen.png" alt="Froschmaskottchen" class="froschMaskottchen">
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