<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';

$servername = "10.35.233.7:3306";
$username = "k218479_anne_vokabeln";
$password = "anne_vokabeln_PW!";
$dbname = "k218479_vokabeltrainer_anne_vokabeln";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$user = $_SESSION['username'];
$tableName = "vokabeltrainer_vokabeln_" . $conn->real_escape_string($user);

$sql = "SELECT deutsch, englisch FROM `$tableName` WHERE status = 'nicht gelernt'";
$result = $conn->query($sql);

$vocabList = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vocabList[] = [
            "word" => $row["deutsch"],
            "translation" => $row["englisch"]
        ];
    }
} else {
    echo "Keine Vokabeln mit dem Status 'nicht gelernt' gefunden.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lernmodus</title>
    <link rel="stylesheet" href="Eingebundene-CSS-Scripte/Vokabeltrainer-Style.css">
    <script src="Vokabeltrainer-Allgemeine-JSFunktionen.js"></script>
    <style>
        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            height: 770px;
            padding: 20px;
        }

        .left-container {
            width: 25%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .divider {
            width: 1px;
            background-color: #838282;
            height: 100%;
            margin: 0 20px;
        }

        .right-container {
            width: 75%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        .vocab-card-container {
            perspective: 1000px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 600px;
            background-color: #f5f5f5;
            flex-direction: row;
            touch-action: none;
            padding: 0 10%;
        }

        .vocab-card {
            width: 65%;
            height: 450px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.6s, opacity 0.6s;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .vocab-card .front,
        .vocab-card .back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            border-radius: 10px;
        }

        .vocab-card .front {
            background-color: #2d6a4f;
        }

        .vocab-card .back {
            background-color: #1b4332;
            transform: rotateY(180deg);
        }

        .flipped {
            transform: rotateY(180deg);
        }

        .vocab-info {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }

        .vocab-card.slide-left {
            transform: translateX(-30%);
            opacity: 0;
        }


        .progress-bar {
            width: 100%;
            max-width: 800px;
            background-color: #e0e0e0;
            height: 20px;
            border-radius: 10px;
            margin-top: 10px;
            position: relative;
        }

        .progress-bar-fill {
            height: 100%;
            width: 0;
            background-color: #2d6a4f;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            transition: width 0.3s;
        }

        .progress-bar-fill.filled {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .standard-controls {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        .standard-controls img {
            width: 40px;
            height: 40px;
            cursor: pointer;
            margin: 0 10px;
        }

        .button {
            width: 90%;
            padding: 12px 24px;
            background-color: transparent;
            color: #2d6a4f;
            font-size: 16px;
            font-weight: bold;
            border: 2px solid #2d6a4f;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .button:hover {
            background-color: #2d6a4f;
            color: white;
            border-color: #1b4332;
        }

        .tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #2d6a4f;
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        .tooltip .tooltiptext::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #2d6a4f transparent transparent transparent;
        }

        .long-divider {
            border: none;
            border-top: 2px solid #838282;
            margin-top: 20px;
            margin-bottom: 0;
            width: 90%;
        }

        #pomodoro-widget {
            max-width: 800px;
            border-radius: 15px;
            overflow: hidden; 
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
            showInfoBox("Hier kannst du die Vokabeln lernen, die du schon kannst. Klicke die Vokabelkarte an und wiederhole die Übersetzung nochmals.", 4000);

            const frosch = document.querySelector('.froschMaskottchen');
            if (frosch) {
            frosch.addEventListener('click', () => {
                showInfoBox("Hier kannst du die Vokabeln lernen, die du schon kannst. Klicke die Vokabelkarte an und wiederhole die Übersetzung nochmals.", 4000);
            });
            }
        });
        </script>
	
    <div class="container">
        <div class="left-container">
            <br>
            <a href="Vokabeltrainer-Vokabeln-Lernen-Richtig.php" class="button">Lerne nur richtige Vokabeln</a>
            <br>
            <a href="Vokabeltrainer-Vokabeln-Lernen-Falsch.php" class="button">Lerne nur falsche Vokabeln</a>
            <div class="long-divider"></div>
            <br>
            <a href="Vokabeltrainer-Vokabeln-Abfragemodus.php" class="button">Wechsle zum Abfragemodus</a>
            <br>
            <a href="Vokabeltrainer-Vokabeln-Lernmodus.php" class="button">Wechsle zum Lernmodus</a>
        </div>

        <div class="divider"></div>

        <div class="right-container">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
                <div class="vocab-card" id="vocabCard" onclick="flipCard()">
                    <div class="front">
                        <p id="vocabWord"></p>
                    </div>

                    <div class="back">
                        <p id="vocabTranslation"></p>
                    </div>
                </div>

            <div class="vocab-info">
                Vokabel <span id="currentVocab">1</span> von <span id="totalVocab">10</span>
            </div>

            <div class="progress-bar">
                <div class="progress-bar-fill" id="progressBarFill"></div>
            </div>

            <div class="standard-controls">
                <div class="tooltip">
                        <img src="Eingebundene-Bilder/Vokabeltrainer-Vokabeln-Icon-Richtig.png" alt="Richtig" onclick="markAsRight()">
                        <span class="tooltiptext">Richtig</span>
                    </div>

                    <div class="tooltip">
                        <img src="Eingebundene-Bilder/Vokabeltrainer-Vokabeln-Icon-Zuruecksetzen.png" alt="Zurücksetzen" onclick="resetProgress()">
                        <span class="tooltiptext">Zurücksetzen</span>
                    </div>
                    <div class="tooltip">
                        <img src="Eingebundene-Bilder/Vokabeltrainer-Vokabeln-Icon-Random.png" alt="Random" onclick="randomVoc()">
                        <span class="tooltiptext">Zufällig</span>
                    </div>
                    
                    <div class="tooltip">
                            <img src="Eingebundene-Bilder/Vokabeltrainer-Vokabeln-Icon-Falsch.png" alt="Falsch" onclick="markAsFalse()">
                            <span class="tooltiptext">Falsch</span>
                    </div>
            </div>
        </div>
    </div>
    
	<img src="Eingebundene-Bilder/Vokabeltrainer-Froschmaskottchen.png" alt="Froschmaskottchen" class="froschMaskottchen">
	
    <script>
        let currentVocabIndex = 0;
        let vocabList = <?php echo json_encode($vocabList); ?>;
        const totalVocabCount = vocabList.length;
        let repeatList = [...vocabList];
        let learnedList = [];
        const vocabCard = document.getElementById('vocabCard');
        const vocabWord = document.getElementById('vocabWord');
        const progressBarFill = document.getElementById('progressBarFill');
        let wrongAttempts = {};

        function displayVocab() {
            vocabCard.classList.remove('flipped');

            if (repeatList.length > 0) {
                const vocab = repeatList[currentVocabIndex];
                vocabWord.textContent = vocab.word;
                document.getElementById('vocabTranslation').textContent = vocab.translation;
                document.getElementById('currentVocab').textContent = learnedList.length + 1;
                document.getElementById('totalVocab').textContent = totalVocabCount;
            } else {
                vocabWord.textContent = 'Alle Vokabeln gelernt!';
            }
            updateProgressBar();
        }

        function flipCard() {
            vocabCard.classList.toggle('flipped');
        }

        function resetProgress() {
            repeatList = [...vocabList]; 
            currentVocabIndex = 0;
            learnedList = [];
            wrongAttempts = {};
            localStorage.removeItem('currentVocabIndex'); 
            displayVocab();
        }

        function randomVoc() {
            repeatList = shuffleArray([...vocabList]);
            currentVocabIndex = 0;
            learnedList = [];
            localStorage.setItem('currentVocabIndex', currentVocabIndex);

            displayVocab();
        }

        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        function updateProgressBar() {
            const progress = (learnedList.length / totalVocabCount) * 100;
            progressBarFill.style.width = `${progress}%`;

            if (progress === 100) {
                progressBarFill.classList.add('filled');
            } else {
                progressBarFill.classList.remove('filled');
            }
        }

        function markAsRight() {
            if (repeatList.length > 0) {
                const vocab = repeatList.splice(currentVocabIndex, 1)[0];
                vocab.status = "richtig";
                learnedList.push(vocab);

                updateVocabStatus(vocab.word, "richtig");

                if (currentVocabIndex >= repeatList.length) {
                    currentVocabIndex = 0;
                }


                localStorage.setItem('currentVocabIndex', currentVocabIndex);

                displayVocab();
            } else {
                vocabWord.textContent = 'Alle Vokabeln gelernt!';
                document.getElementById('vocabTranslation').textContent = '';
            }
            updateProgressBar();
        }


        function markAsFalse() {
            if (repeatList.length > 0) {

                const vocab = repeatList.splice(currentVocabIndex, 1)[0];
                vocab.status = "falsch"; 
                learnedList.push(vocab);

                updateVocabStatus(vocab.word, "falsch");

                if (currentVocabIndex >= repeatList.length) {
                    currentVocabIndex = 0;
                }

                localStorage.setItem('currentVocabIndex', currentVocabIndex);

                displayVocab();
            } else {
                vocabWord.textContent = 'Alle Vokabeln gelernt!';
                document.getElementById('vocabTranslation').textContent = '';
            }

            updateProgressBar();
        }

        function updateVocabStatus(word, status) {
            fetch('Vokabeltrainer-Vokabeln-Pruefung-Status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `vokabel=${encodeURIComponent(word)}&status=${encodeURIComponent(status)}`
            })
            .then(response => response.text())
            .then(data => {
                console.log("Serverantwort:", data);
            })
            .catch(error => {
                console.error('Fehler beim Update:', error);
            });
        }


        displayVocab();
    </script>
</body>
</html>