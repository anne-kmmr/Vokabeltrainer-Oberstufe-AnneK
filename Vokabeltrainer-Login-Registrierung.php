<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'Vokabeltrainer-Sitzungsverwaltung.php';

$message = "";

function isPasswordValid($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!isPasswordValid($password)) {
        $message = "Das Passwort muss min. 8 Zeichen lang sein, min. einen Großbuchstaben, eine Ziffer und ein Sonderzeichen enthalten. ";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(16));

        if (!$con) {
            die("<p style='color:red;'>Datenbankverbindung ist fehlgeschlagen: " . mysqli_connect_error() . "</p>");
        }

        $check_stmt = $con->prepare("SELECT id FROM vokabeltrainer_logindaten WHERE username = ? OR email = ?");
        if (!$check_stmt) {
            die("<p style='color:red;'>Fehler bei der Vorbereitung der Abfrage: " . $con->error . "</p>");
        }

        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $message = "Benutzername oder E-Mail-Adresse ist bereits vergeben.";
        } else {
            $stmt = $con->prepare("INSERT INTO vokabeltrainer_logindaten (username, email, password, token, is_active) VALUES (?, ?, ?, ?, 0)");
            if (!$stmt) {
                die("<p style='color:red;'>Fehler beim Vorbereiten des INSERT-Statements: " . $con->error . "</p>");
            }

            $stmt->bind_param("ssss", $username, $email, $hashed_password, $token);

            if ($stmt->execute()) {
                $verify_link = "http://testeninf.de/anne/Vokabeltrainer-Login-Registrierung-Bestätigung.php?token=$token";
                $subject = "Bestätigen Sie Ihre Registrierung";
                $message_content = "Hallo $username,\n\nBitte klicken Sie auf den folgenden Link, um Ihren Account zu aktivieren:\n$verify_link";
                $headers = "From: noreply@newsletter_sprachtacular.com";

                if (mail($email, $subject, $message_content, $headers)) {
                    $message = "Registrierung erfolgreich! Eine Bestätigungs-E-Mail wurde an $email gesendet.";
                } else {
                    $message = "Registrierung erfolgreich, aber E-Mail konnte nicht gesendet werden.";
                    error_log("Mailversand fehlgeschlagen an: $email");
                }
            } else {
                $message = "Fehler bei der Registrierung: " . $stmt->error;
            }

            $stmt->close();
        }

        $check_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrierung</title>
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
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
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
        .info-boxMeldung {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
        }
        .info-boxMeldung.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .info-boxMeldung.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
        showInfoBox("Gib deine Daten ein, erstelle ein Konto, aktiviere es und schon kann es losgehen! Ein TIPP: Manchmal braucht die Registrierungs-Email etwas länger oder landet im SPAM-Ordner.", 4000);

        const frosch = document.querySelector('.froschMaskottchen');
        if (frosch) {
            frosch.addEventListener('click', () => {
                showInfoBox("Gib deine Daten ein, erstelle ein Konto, aktiviere es und schon kann es losgehen! Ein TIPP: Manchmal braucht die Registrierungs-Email etwas länger oder landet im SPAM-Ordner.", 4000);
            });
        }
    });
</script>


<div class="container">
    <h1>Registrieren</h1>

    <?php if (!empty($message)): ?>
        <div class="info-boxMeldung <?php echo (strpos($message, 'erfolgreich') !== false) ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form action="Vokabeltrainer-Login-Registrierung.php" method="post">
        <input type="text" name="username" placeholder="Benutzername" required>
        <input type="email" name="email" placeholder="E-Mail" required>
        <input type="password" name="password" placeholder="Passwort" required>
        <button type="submit">Registrieren</button>
    </form>
</div>

<img src="Eingebundene-Bilder/Vokabeltrainer-Froschmaskottchen.png" alt="Froschmaskottchen" class="froschMaskottchen">
</body>
</html>