<?php
session_start();

$version = file_get_contents('Sonstige-Scripte-u.-Vokabeln/Vokabeltrainer-Aktuelle-Version.txt');
if ($version === false) {
    $version = 'Unbekannte Version';
}

$con_login = mysqli_connect("10.35.233.7:3306", "k218479_anne_login", "anne_login_PW!", "k218479_vokabeltrainer_anne_login");
if (!$con_login) {
    die("Verbindung zur Login-Datenbank fehlgeschlagen: " . mysqli_connect_error());
}

$con_tests = mysqli_connect("10.35.233.7:3306", "k218479_anne_tests", "anne_tests_PW!", "k218479_vokabeltrainer_anne_tests");
if (!$con_tests) {
    die("Verbindung zur Tests-Datenbank fehlgeschlagen: " . mysqli_connect_error());
}

$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : null;

if ($isLoggedIn) {
    $tableName = "vokabeltrainer_tests_" . $username;

    $checkTableQuery = "SHOW TABLES LIKE '$tableName'";
    $result = mysqli_query($con_tests, $checkTableQuery);
    if (mysqli_num_rows($result) == 0) {
        $createTableQuery = "CREATE TABLE $tableName (
            id INT AUTO_INCREMENT PRIMARY KEY,
            datum DATE NOT NULL,
            art VARCHAR(255) NOT NULL
        )";
        if (!mysqli_query($con_tests, $createTableQuery)) {
            echo "Fehler bei der Erstellung der Tabelle: " . mysqli_error($con_tests);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editId'])) {
        $editId = $_POST['editId'];
        $datum = $_POST['editDatum'];
        $art = $_POST['editArt'];

        $stmt = $con_tests->prepare("UPDATE $tableName SET datum = ?, art = ? WHERE id = ?");
        $stmt->bind_param('ssi', $datum, $art, $editId);
        $stmt->execute();
        $stmt->close();
    } else {
        $datum = isset($_POST['datum']) ? trim($_POST['datum']) : '';
        $art = isset($_POST['art']) ? trim($_POST['art']) : '';

        if (!empty($datum) && !empty($art)) {
            $stmt = $con_tests->prepare("INSERT INTO $tableName (datum, art) VALUES (?, ?)");
            $stmt->bind_param('ss', $datum, $art);
            $stmt->execute();
        } else {
            $message = "Bitte Datum und Art ausfüllen.";
        }
    }
}
$con_login->close();
$con_tests->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="Eingebundene-CSS-Scripte/Vokabeltrainer-Style.css">
    <link rel="stylesheet" href="Eingebundene-CSS-Scripte/Style-Home.css">
    <script src="Vokabeltrainer-Allgemeine-JSFunktionen.js"></script>
	<style>
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
    <script>
        function updateClock() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const mins = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const timeString = `${hours}:${mins}:${seconds}`;
            document.getElementById('clock').textContent = timeString;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
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
            showInfoBox("Hi, ich bin Froschi! Hier kannst du fleißig Englisch lernen. Melde dich gerne an oder erstelle ein Konto, um deinen Fortschritt zu speichern. Mich findest du immer hier unten.", 4000);

            const frosch = document.querySelector('.froschMaskottchen');
            if (frosch) {
            frosch.addEventListener('click', () => {
                showInfoBox("Hi, ich bin Froschi! Hier kannst du fleißig Englisch lernen. Melde dich gerne an oder erstelle ein Konto, um deinen Fortschritt zu speichern. Mich findest du immer hier unten.", 4000);
            });
            }
        });
        </script>
    
    <div class="container">
        <div class="left-container">
        <?php
        if (isset($_SESSION['username'])) {
            ?>
            <div class="square">
                <h2>Übersicht Tests</h2>
        
                <div class="eintragsformular">
                    <form action="" method="post">
                        <label for="art">Art</label>
                        <input type="text" id="art" name="art" required><br><br>
        
                        <label for="datum">Datum</label>
                        <input type="date" id="datum" name="datum" required><br><br>
        
                        <input type="submit" value="Eintrag hinzufügen">
                    </form>
                    <br>
                    <div class="button-row">
                        <a href="Vokabeltrainer-Tests.php" class="button2">Alle Tests ansehen</a>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="square">
                <h2>Übersicht Tests</h2>
                <br>
                <br>
                <br>
                <p><i>
                Bitte melde dich an, um Tests hinzuzufügen und zu verwalten.</i>
                </p>
            </div>
            <?php
        }
        ?>
        
            <div class="square">
                <?php
                if (isset($_SESSION['username'])) {
                ?>
                    <h2>Vokabeln lernen</h2>
                    <p>
                        Möchtest du lernen oder dich selbst abfragen?
                        <br>
                        Navigieren entweder zum Lernmodus oder Abfragemodus!
                    </p>
                    <div class="button-container">
                        <div class="button-row">
                            <a href="Vokabeltrainer-Vokabeln-Lernmodus.php" class="button">Lernmodus</a>
                            <a href="Vokabeltrainer-Vokabeln-Abfragemodus.php" class="button">Abfragemodus</a>
                        </div>
                        <hr class="long-divider">
                        <br>
                        <p>Vergiss nicht, deine nächsten Tests bei "Tests" einzutragen!</p>
                    </div>
                <?php
                } else {
                ?>
                    <h2>Vokabeln lernen</h2>
					<br>
					<br>
					<br>
					<p><i>
					Bitte melde dich an, um Vokabeln zu lernen und deinen Fortschritt zu speichern.</i>
					</p>
                        
                <?php
                }
                ?>
            </div>            

            <div class="square">
                <h2>Newsletter</h2>
                <p> Hier kannst du dich für unseren Newsletter an- oder abmelden!
                <br>
                Lese dir bei Fragen gerne die FAQs durch.
                </p>
                <div class="button-container">
                    <div class="button-row">
                        <a href="Vokabeltrainer-Newsletter-Anmeldung.php" class="button">Newsletter Anmeldung</a>
                        <a href="Vokabeltrainer-Newsletter-Abmeldung.php" class="button">Newsletter Abmeldung</a>
                    </div>
                    <a href="Vokabeltrainer-FAQ.php" class="button">FAQ</a>
                </div> 
            </div>

            <div class="square">
                <h2>Weitere Sprachtacular-Informationen</h2>
                <p>Aktuell keine neuen Informationen.</p>
                <hr class="long-divider">
                <p>Sieh dir hier die neusten Nachrichten an:</p>
                <a href="https://www.tagesschau.de" target="_blank">
                    <img src="Eingebundene-Bilder/Vokabeltrainer-Bild-Tagesschau.png" alt="Tagesschau Nachrichten" class="news-image">
                </a>
                <br>
            </div>
        </div>

        <div class="right-container">
            <div class="square-large">
                <div class="square-large-top">
                    <div style="text-align:center; padding:0;">
                        <h2>
                            <a style="text-decoration:none;" href="https://www.zeitverschiebung.net/de/city/2881646">
                                <span style="color:gray;">Aktuelle Uhrzeit / Ortszeit</span>
                                <br/>Landau in der Pfalz, Deutschland
                            </a>
                        </h2>
                        
                        <iframe 
                            src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=de&size=large&timezone=Europe%2FBerlin" 
                            width="100%" 
                            height="140" 
                            frameborder="0" 
                            seamless
                        ></iframe>
                        
                        <small style="color:gray;">
                            &copy; 
                            <a href="https://www.zeitzonenrechner.net/" style="color: gray;">Zeitzonenrechner</a>
                        </small>
                    </div>                    
                </div>
                <div class="square-large-bottom">
                    <div id="ww_29485cec25538" v='1.3' loc='id' a='{"t":"horizontal","lang":"de","sl_lpl":1,"ids":["wl4132"],"font":"Arial","sl_ics":"one_a","sl_sot":"celsius","cl_bkg":"#FFFFFF00","cl_font":"#000000","cl_cloud":"#d4d4d4","cl_persp":"#2196F3","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722"}'>Mehr Vorhersagen:
                    <a href="https://oneweather.org/de/deutschland/21_tage/" id="ww_29485cec25538_u" target="_blank">Wettervorhersage 21 tage</a></div><script async src="https://app3.weatherwidget.org/js/?id=ww_29485cec25538"></script>
                </div>

                <small style="color:gray;">
                    &copy;
                    <a href="https://oneweather.org/de/deutschland/21_tage/" style="color: gray;">OneWeather</a>
                </small>
            </div>
        </div>
    </div>
	
	<img src="Eingebundene-Bilder/Vokabeltrainer-Froschmaskottchen.png" alt="Froschmaskottchen" class="froschMaskottchen">
	
    <div class="footer">
        <div class="additional-section">
            <h2>Zusätzliche Ressourcen</h2>
            <div class="additional-container">
                <div class="additional-box">
                    <h3>Grammatik</h3>
                    <p><a href="https://www.grammarly.com">Grammarly</a></p>
                    <p><a href="https://www.englishclub.com/grammar/">English Club Grammar</a></p>
                    <p><a href="https://www.ego4u.de/de/cram-up/grammar">Ego4u</a></p>
                    <p><a href="https://www.perfect-english-grammar.com">Perfect english Grammar</a></p>
                </div>
                <div class="additional-box">
                    <h3>Lernstrategien</h3>
                    <p><a href="https://www.learningscientists.org">The Learning Scientists</a></p>
                    <p><a href="https://www.edutopia.org">Edutopia Learning Strategies</a></p>
                    <p><a href="https://www.mindtools.com">MindTools</a></p>
                    <p><a href="https://www.oxfordlearning.com">Oxford Learning</a></p>
                    <p><a href="https://www.verywellmind.com">Very Well Mind</a></p>
                </div>
                <div class="additional-box">
                    <h3>Lernmaterialien</h3>
                    <p><a href="https://www.education.com/resources/grammar/">Education.com Grammar Resources</a></p>
                    <p><a href="https://www.englishforeveryone.org/">English For Everyone</a></p>
                </div>
            </div>
        </div>

        <hr class="long-divider">
        <br>
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