<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT id, password, is_active FROM vokabeltrainer_logindaten WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $is_active);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            if ($is_active) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;

                header("Location: Vokabeltrainer-Home.php");
                exit();
            } else {
                $error = "Ihr Konto ist noch nicht aktiviert. Bitte überprüfen Sie Ihre E-Mail.";
            }
        } else {
            $error = "Falscher Benutzername oder Passwort. <br> Bitte erneut versuchen.";
        }
    } else {
        $error = "Falscher Benutzername oder Passwort. <br> Bitte erneut versuchen.";
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
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            background-color: #ffffff;
            text-align: center;
        }

        h1 {
            color: #2d6a4f;
            font-size: 24px;
            margin-bottom: 20px;
        }

        a {
            color: #2d6a4f;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
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

        .error {
            color: red;
            margin: 10px 0;
        }
    </style>
</head>
<body>
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
        <p>Noch keinen Account? <a href="Vokabeltrainer-Login-Registrierung.php">Registrieren Sie sich hier</a>.</p>
    </div>
</body>
</html>
