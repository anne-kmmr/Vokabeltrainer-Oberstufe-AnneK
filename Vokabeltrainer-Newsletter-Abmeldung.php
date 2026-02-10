<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';
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
            height: 400px;
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

        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

        button {
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

        button:hover {
            background-color: #40916c;
        }

        a {
            color: #2d6a4f;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
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

    <br>
    <br>
	
	<script src="Sonstige-Scripte-u.-Vokabeln/TooltipFunktion.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            showInfoBox("Hier kannst du den Newsletter abbbestellen. Schade...! Gerne kannst du Feedback hinterlassen, warum du ihn abbestellt hast!", 4000);

            const frosch = document.querySelector('.froschMaskottchen');
            if (frosch) {
            frosch.addEventListener('click', () => {
                showInfoBox("Hier kannst du den Newsletter abbbestellen. Schade...! Gerne kannst du Feedback hinterlassen, warum du ihn abbestellt hast!", 4000);
            });
            }
        });
        </script>

    <div class="container">
        <h1>Abmeldung vom Newsletter</h1>
        <p>Gib für die Abmeldung bitte die E-Mail-Adresse ein, mit welcher du dich angemeldet hast.</p>

        <form action="Vokabeltrainer-Newsletter-Abmeldung-Script.php" method="post">
            <input type="email" id="email" name="email" placeholder="E-Mail-Adresse" required>
            <button type="submit">Abmelden</button>
        </form>

        <p>Wenn du dich nicht mehr abmelden möchtest, kannst du jederzeit <a href="Vokabeltrainer-Newsletter-Anmeldung.php">zurück zur Anmeldung</a>.</p>
    </div>
    <br>
    <br>

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