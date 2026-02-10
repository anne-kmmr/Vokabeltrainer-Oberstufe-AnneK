<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $nachricht = htmlspecialchars($_POST["nachricht"]);
    
    $empfaenger = "annekaemmerer@gmx.de";
    $betreff = "Feedback von " . $name;
    $inhalt = "Name: $name\nE-Mail: $email\n\nNachricht:\n$nachricht";
    $header = "From: $email";

    if (mail($empfaenger, $betreff, $inhalt, $header)) {
        $erfolg = "Danke für dein Feedback! Wir haben deine Nachricht erhalten.";
    } else {
        $fehler = "Leider konnte deine Nachricht nicht gesendet werden. Bitte versuche es erneut.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feedback</title>
<script src="Vokabeltrainer-Allgemeine-JSFunktionen.js"></script>
<link rel="stylesheet" href="Eingebundene-CSS-Scripte/Vokabeltrainer-Style.css">
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }

    .feedback-section {
        max-width: 90%;
        margin: 20px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .feedback-header {
        background-color: #2d6a4f;
        color: white;
        padding: 15px;
        border-radius: 8px 8px 0 0;
        text-align: center;
        font-size: 24px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 15px;
    }

    input[type="text"],
    input[type="email"],
    textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    button {
        background-color: #2d6a4f;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #1b4332;
    }

    .feedback-message {
        margin: 10px 0;
        font-size: 16px;
        color: green;
    }

    .error-message {
        color: red;
    }

    @media (max-width: 600px) {
        .feedback-section {
            width: 90%;
        }
    }
	.navbar a {
		display: block;
		margin: 5px 0;
	}
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

	.footer {
		position: fixed;
		bottom: 0;
		left: 0;
		width: 100%;
		color: #999999;
		padding: 10px;
		text-align: center;
		font-size: 14px;
		background-color: #e4d9d1;
		z-index: 999;
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

<div class="feedback-section">
    <div class="feedback-header">Dein Feedback ist uns wichtig!</div>
	
	<script src="Sonstige-Scripte-u.-Vokabeln/TooltipFunktion.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            showInfoBox("Gerne antwortet dir die Entwicklerin, hab etwas Geduld, du wirst deine Antwort erhalten!", 4000);

            const frosch = document.querySelector('.froschMaskottchen');
            if (frosch) {
            frosch.addEventListener('click', () => {
                showInfoBox("Gerne antwortet dir die Entwicklerin, hab etwas Geduld, du wirst deine Antwort erhalten!", 4000);
            });
            }
        });
        </script>

    <?php if (!empty($erfolg)): ?>
        <p class="feedback-message"><?php echo $erfolg; ?></p>
    <?php elseif (!empty($fehler)): ?>
        <p class="feedback-message error-message"><?php echo $fehler; ?></p>
    <?php endif; ?>

    <form method="post" action="Vokabeltrainer-Feedback.php">
        <input type="text" name="name" placeholder="Dein Name" required>
        <input type="email" name="email" placeholder="Deine E-Mail-Adresse" required>
        <textarea name="nachricht" placeholder="Deine Nachricht" required></textarea>
        <button type="submit">Absenden</button>
    </form>
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
