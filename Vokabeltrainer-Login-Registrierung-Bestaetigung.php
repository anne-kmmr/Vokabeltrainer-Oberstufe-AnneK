<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';

$message = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $con->prepare("SELECT id FROM vokabeltrainer_logindaten WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();

        $stmt = $con->prepare("UPDATE vokabeltrainer_logindaten SET is_active = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $message = "Ihr Konto wurde aktiviert! Sie können sich jetzt anmelden.";
    } else {
        $message = "Ungültiger oder abgelaufener Token.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bestätigung Registrierung</title>
    <link rel="stylesheet" href="Eingebundene-CSS-Scripte/Vokabeltrainer-Style.css">
    <script src="Vokabeltrainer-Allgemeine-JSFunktionen.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #4CAF50;
            padding: 10px 15px;
            border-radius: 5px;
        }
        a:hover {
            background-color: #45a049;
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
            showInfoBox("Super, du hast es geschafft! Nun kannst du dich anmelden und direkt loslernen!", 4000);

            const frosch = document.querySelector('.froschMaskottchen');
            if (frosch) {
            frosch.addEventListener('click', () => {
                showInfoBox("Super, du hast es geschafft! Nun kannst du dich anmelden und direkt loslernen!", 4000);
            });
            }
        });
        </script>
	
    <div class="container">
        <h1>Aktivierung</h1>
        <p><?php echo isset($message) ? $message : ''; ?></p>
        <p><a href="Vokabeltrainer-Login-Home.php">Zurück zum Login</a></p>
    </div>
	
	<img src="Eingebundene-Bilder/Vokabeltrainer-Froschmaskottchen.png" alt="Froschmaskottchen" class="froschMaskottchen">
</body>
</html>
