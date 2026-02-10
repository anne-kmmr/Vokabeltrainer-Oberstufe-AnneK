<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="Vokabeltrainer-Allgemeine-JSFunktionen.js"></script>
    <link rel="stylesheet" href="Eingebundene-CSS-Scripte/Vokabeltrainer-Style.css">
    <style>

    .datenschutz-container {
        background-color: #f0f5f0;
        color: #333;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .datenschutz-container h1, .datenschutz-container h2 {
        color: #006400;
    }

    .datenschutz-container a {
        color: #008000;
        text-decoration: underline;
    }

    .datenschutz-container p {
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
            showInfoBox("Hier findest du alle wichtigen Informationen, bei weiteren Fragen sende gerne eine Nachricht unter Feedback!", 4000);

            const frosch = document.querySelector('.froschMaskottchen');
            if (frosch) {
            frosch.addEventListener('click', () => {
                showInfoBox("Hier findest du alle wichtigen Informationen, bei weiteren Fragen sende gerne eine Nachricht unter Feedback!", 4000);
            });
            }
        });
        </script>

    <div class="datenschutz-container">
        <h1>Herzlich Willkommen auf meiner schulischen Webseite</h1>
        <p>Ich messe dem Datenschutz große Bedeutung bei. Die Verarbeitung Ihrer personenbezogenen Daten geschieht unter Beachtung der geltenden datenschutzrechtlichen Vorschriften, insbesondere der Datenschutzgrundverordnung (DSGVO) und der darüber hinausgehenden einschlägigen nationalen Datenschutzregelungen. Ich erhebe und verarbeite Ihre personenbezogenen Daten, um Ihnen diese Schulhomepage anbieten zu können. Diese Erklärung beschreibt, wie und zu welchem Zweck Ihre Daten erfasst und genutzt werden und welche Wahlmöglichkeiten Sie im Zusammenhang mit persönlichen Daten haben.</p>
    
        <p><strong>Durch Ihre Verwendung dieser Webseite stimmen Sie der Verarbeitung Ihrer personenbezogenen Daten im Umfang und unter den Voraussetzungen dieser Datenschutzerklärung zu.</strong></p>
    
        <br>
        <h2>I. Name und Anschrift des Verantwortlichen</h2>
        <p>Der Verantwortliche im Sinne der Datenschutz-Grundverordnung und anderer nationaler Datenschutzgesetze der Mitgliedsstaaten sowie sonstiger datenschutzrechtlicher Bestimmungen ist die:</p>
        <p>Anne Kämmerer</p>
        <p>76829 Landau</p>
        <a href="mailto:annekaemmerer@gmx.de">annekaemmerer@gmx.de</a>
    
        <p>Sofern Sie der Verarbeitung Ihrer personenbezogenen Daten durch mich nach Maßgabe dieser Datenschutzbestimmungen insgesamt oder für einzelne Maßnahmen widersprechen wollen, können Sie Ihren Widerspruch an den Verantwortlichen richten.</p>
    
        <p>Sie können diese Datenschutzerklärung jederzeit speichern und ausdrucken.</p>
    
        <br>
        <h2>II. Geltungsbereich</h2>
        <p>Diese Datenschutzerklärung gilt für das Internet-Angebot und die dort angebotenen eigenen Inhalte. Für Inhalte anderer Anbieter, auf die z.B. über Links verwiesen wird, gelten die dortigen Nutzungsbestimmungen.</p>
    
        <br>
        <h2>III. Weiterleitung zu einem anderen Anbieter</h2>
        <p>Soweit aus meinem Angebot zu Inhalten anderer Anbieter verlinkt wird, unterliegt die Nutzung dieser Angebote gegebenenfalls anderen Bedingungen als in dieser Datenschutzerklärung beschrieben.</p>
    
        <br>
        <h2>IV. Allgemeines zur Datenverarbeitung</h2>
        <h3>1. Umfang der Verarbeitung personenbezogener Daten</h3>
        <p>Ich verarbeite personenbezogene Daten der Nutzer grundsätzlich nur, soweit dies zur Bereitstellung einer funktionsfähigen Website sowie meiner Inhalte und Leistungen erforderlich ist. Eine Speicherung oder Aufzeichnung personenbezogener Daten findet nicht statt.</p>
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