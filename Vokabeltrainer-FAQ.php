<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <script src="Vokabeltrainer-Allgemeine-JSFunktionen.js"></script>
    <link rel="stylesheet" href="Eingebundene-CSS-Scripte/Vokabeltrainer-Style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .faq-section {
            max-width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .faq-header {
            background-color: #2d6a4f;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            text-align: center;
            font-size: 24px;
        }

        .faq-item {
            border-bottom: 1px solid #ddd;
        }

        .faq-question {
            padding: 15px;
            cursor: pointer;
            background-color: #e7f5e0;
            border-radius: 5px;
            margin: 10px 0;
            transition: background-color 0.3s;
        }

        .faq-question:hover {
            background-color: #d4edda;
        }

        .faq-answer {
            display: none;
            padding: 15px;
            background-color: #fafafa;
            border-radius: 0 0 5px 5px;
        }

        @media (max-width: 600px) {
            .faq-section {
                width: 90%;
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

    <div class="faq-section">
        <div class="faq-header">Häufig gestellte Fragen (FAQ)</div>

        <script src="Sonstige-Scripte-u.-Vokabeln/TooltipFunktion.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            showInfoBox("Schau gerne die Antworten durch, vielleicht beantwortet sich ja deine Frage. Ansonsten sende gerne eine Nachricht unter Feedback.", 4000);

            const frosch = document.querySelector('.froschMaskottchen');
            if (frosch) {
            frosch.addEventListener('click', () => {
                showInfoBox("Schau gerne die Antworten durch, vielleicht beantwortet sich ja deine Frage. Ansonsten sende gerne eine Nachricht unter Feedback.", 4000);
            });
            }
        });
        </script>

    
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Wie kann ich die nächste Vokabel anzeigen lassen?
            </div>
            <div class="faq-answer">
                <p>Die nächste Vokabel wird angezeigt, wenn du die aktuelle Vokabel als "richtig" oder "falsch" gekennzeichnet hast.  </p>
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Wie wechsle ich zwischen Lern- und Abfragemodus?
            </div>
            <div class="faq-answer">
                <p>Du kannst den Modus mit dem großen Button links über der Vokabelkarte wechseln.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Was passiert, wenn ich eine Vokabel nicht übersetze?
            </div>
            <div class="faq-answer">
                <p>Im Lernmodus kannst du die Vokabelkarte einfach umdrehen und dir die Übersetzung einprägen, danach auf "Weiter" klicken. Im Abfragemodus kannst du sie auch als "Falsch" markieren und danach gezielt lernen. </p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Kann ich eigene Vokabeln zur Liste hinzufügen?
            </div>
            <div class="faq-answer">
                <p>Nein, aktuell kannst du noch keine eigenen Vokabeln hinzufügen. Die Sammlung besteht aus über 1200 Vokabeln, da wird bestimmt etwas für dich dabei sein!</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Gibt es eine Möglichkeit, Vokabeln zu wiederholen, die ich oft falsch habe?
            </div>
            <div class="faq-answer">
                <p>Ja, falsch beantwortete Vokabeln werden automatisch markiert und häufiger wiederholt.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Kann ich die Website auch auf meinem Smartphone oder Tablet nutzen?
            </div>
            <div class="faq-answer">
                <p>Ja, die Website ist für mobile Geräte optimiert und passt sich automatisch der Bildschirmgröße an.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Wie kann ich zwischen verschiedenen Sprachen wechseln?
            </div>
            <div class="faq-answer">
                <p>Aktuell kannst du unsere Website nur auf Deutsch nutzen, um Englisch zu lernen. Wir arbeiten aber an der vielseitigen Verwendbarkeit unserer Seite in verschiedenen Sprachen.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Wie viele Vokabeln enthält der Trainer insgesamt?
            </div>
            <div class="faq-answer">
                <p>Der Vokabeltrainer enthält derzeit über 1200 Vokabeln in verschiedenen Schwierigkeitsgraden.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Wie kann ich mich für ein Benutzerkonto registrieren und meinen Fortschritt speichern?
            </div>
            <div class="faq-answer">
                <p>Du kannst dich über das Registrierungsformular auf der Website anmelden, um deinen Fortschritt zu speichern. Dafür benötigst du ein Email-Konto und musst einen Benutzernamen sowie ein sicheres Passwort festlegen.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Wie kann ich mich für den Newsletter anmelden?
            </div>
            <div class="faq-answer">
                <p>Du kannst dich jederzeit über den Abmeldelink auf der Homeseite für den Newsletter anmelden.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Kann ich mich jederzeit vom Newsletter abmelden?
            </div>
            <div class="faq-answer">
                <p>Ja, du kannst dich jederzeit über den Abmeldelink auf der Homeseite für den Newsletter abmelden.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Was passiert mit meiner E-Mail-Adresse, nachdem ich mich abgemeldet habe?
            </div>
            <div class="faq-answer">
                <p>Deine E-Mail-Adresse wird aus unserer Datenbank vollständig gelöscht und nicht mehr für den Newsletter verwendet.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Erhalte ich eine Bestätigung, wenn die Anmeldung erfolgreich war?
            </div>
            <div class="faq-answer">
                <p>Ja, du erhältst eine Bestätigungs-E-Mail, wenn du dich erfolgreich angemeldet hast.</p>
            </div>
        </div>
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

    <script>
        function toggleFAQ(element) {
            const answer = element.nextElementSibling;
            answer.style.display = answer.style.display === "block" ? "none" : "block";
        }
    </script>
</body>
</html>
