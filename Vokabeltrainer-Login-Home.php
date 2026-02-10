<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT id, password FROM vokabeltrainer_logindaten WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id; 
            header("Location: Vokabeltrainer-Home.php");
            exit();
        } else {
            $error = "Falsches Passwort.";
        }
    } else {
        $error = "Benutzername nicht gefunden.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="password"] {
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
        .register-link {
            margin-top: 15px;
            font-size: 14px;
            color: #2d6a4f;
        }
        .register-link a {
            color: #2d6a4f;
            text-decoration: none;
        }
        .register-link a:hover {
            color: #2d6a4f;
            text-decoration: underline;
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
            showInfoBox("Hier kannst du dich ganz einfach mit deinen Benutzerdaten anmelden, wenn du schon ein Konto hast. Ansonsten erstelle dir schnell noch eins!", 4000);

            const frosch = document.querySelector('.froschMaskottchen');
            if (frosch) {
            frosch.addEventListener('click', () => {
                showInfoBox("Hier kannst du dich ganz einfach mit deinen Benutzerdaten anmelden, wenn du schon ein Konto hast. Ansonsten erstelle dir schnell noch eins!", 4000);
            });
            }
        });
        </script>

    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="Vokabeltrainer-Login-Script.php" method="post">
            <input type="text" name="username" placeholder="Benutzername" required>
            <input type="password" name="password" placeholder="Passwort" required>
            <button type="submit">Anmelden</button>
        </form>
        <div class="register-link">
            <p>Noch kein Konto? <a href="Vokabeltrainer-Login-Registrierung.php">Jetzt registrieren</a></p>
        </div>
    </div>
	
	<img src="Eingebundene-Bilder/Vokabeltrainer-Froschmaskottchen.png" alt="Froschmaskottchen" class="froschMaskottchen">
</body>
</html>
