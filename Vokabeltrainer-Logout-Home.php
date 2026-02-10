<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';

if (isset($_POST['confirm_logout'])) {
    $_SESSION = array();

    session_destroy();

    $message = "Du wurdest erfolgreich abgemeldet.";
} elseif (isset($_POST['cancel_logout'])) {
    header("Location: Vokabeltrainer-Home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Logout Bestätigung</title>
    <link rel="stylesheet" href="Eingebundene-CSS-Scripte/Vokabeltrainer-Style.css">
    <script src="Vokabeltrainer-Allgemeine-JSFunktionen.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h1 {
            color: #2d6a4f;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .message {
            color: #333;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #2d6a4f;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #40916c;
        }
        .cancel-button {
            background-color: #cccccc;
            color: #333;
        }
        .cancel-button:hover {
            background-color: #b3b3b3;
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
	
	<script src="Sonstige-Scripte-u.-Vokabeln/TooltipFunktion.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            showInfoBox("Hier geht´s zur Abmeldung. Bis zum nächsten mal!", 4000);

            const frosch = document.querySelector('.froschMaskottchen');
            if (frosch) {
            frosch.addEventListener('click', () => {
                showInfoBox("Hier geht´s zur Abmeldung. Bis zum nächsten mal!", 4000);
            });
            }
        });
        </script>
	
    <div class="container">
        <h1>Logout</h1>
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
            <div class="button-group">
                <form action="Vokabeltrainer-Login-Script.php" method="get">
                    <button type="submit">Zurück zum Login</button>
                </form>
                <form action="Vokabeltrainer-Home.php" method="get">
                    <button type="submit">Zurück zur Startseite</button>
                </form>
            </div>
        <?php else: ?>
            <p class="message">Möchtest du dich wirklich abmelden?</p>
            <form method="post" class="button-group">
                <button type="submit" name="confirm_logout">Ja, abmelden</button>
                <button type="submit" name="cancel_logout" class="cancel-button">Abbrechen</button>
            </form>
        <?php endif; ?>
    </div>
	
	<img src="Eingebundene-Bilder/Vokabeltrainer-Froschmaskottchen.png" alt="Froschmaskottchen" class="froschMaskottchen">
</body>
</html>
