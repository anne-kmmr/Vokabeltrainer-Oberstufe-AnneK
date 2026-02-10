<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';

$login_con = mysqli_connect("10.35.233.7:3306", "k218479_anne_login", "anne_login_PW!", "k218479_vokabeltrainer_anne_login");
if (!$login_con) {
    die("Verbindung zur Login-Datenbank fehlgeschlagen: " . mysqli_connect_error());
}

$test_con = mysqli_connect("10.35.233.7:3306", "k218479_anne_tests", "anne_tests_PW!", "k218479_vokabeltrainer_anne_tests");
if (!$test_con) {
    die("Verbindung zur Test-Datenbank fehlgeschlagen: " . mysqli_connect_error());
}

mysqli_set_charset($test_con, "utf8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $tableName = "vokabeltrainer_tests_" . $username;

        $checkTableQuery = "SHOW TABLES LIKE '$tableName'";
        $result = mysqli_query($test_con, $checkTableQuery);
        if (mysqli_num_rows($result) == 0) {
            $createTableQuery = "CREATE TABLE $tableName (
                id INT AUTO_INCREMENT PRIMARY KEY,
                datum DATE NOT NULL,
                art VARCHAR(255) NOT NULL
            )";
            if (!mysqli_query($test_con, $createTableQuery)) {
                echo "Fehler bei der Erstellung der Tabelle: " . mysqli_error($test_con) . "<br>";
            }
        }

        $erfolgreichGespeichert = false;

        if (isset($_POST['editId'])) {
            $editId = $_POST['editId'];
            $datum = $_POST['editDatum'];
            $art = $_POST['editArt'];

            $stmt = $test_con->prepare("UPDATE $tableName SET datum = ?, art = ? WHERE id = ?");
            $stmt->bind_param('ssi', $datum, $art, $editId);
            if ($stmt->execute()) {
                $erfolgreichGespeichert = true;
            }
            $stmt->close();
        } 
        elseif (isset($_POST['addEntry'])) {
            $datum = isset($_POST['datum']) ? trim($_POST['datum']) : '';
            $art = isset($_POST['art']) ? trim($_POST['art']) : '';

            if (!empty($datum) && !empty($art)) {
                $stmt = $test_con->prepare("INSERT INTO $tableName (datum, art) VALUES (?, ?)");
                $stmt->bind_param('ss', $datum, $art);
                if ($stmt->execute()) {
                    $erfolgreichGespeichert = true;
                }
                $stmt->close();
            }
        }

        if ($erfolgreichGespeichert) {
            header('Location: Vokabeltrainer-Tests.php');
            exit();
        }

    } else {
        echo "<script>alert('Bitte melden Sie sich an, um Einträge hinzuzufügen oder zu bearbeiten.');</script>";
    }
}

$heute = date('Y-m-d');

$result_zukunft = null;
$result_vergangen = null;

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $tableName = "vokabeltrainer_tests_" . $username;

    $sql_zukunft = "SELECT id, datum, art FROM $tableName WHERE datum >= ? ORDER BY datum ASC";
    $stmt_zukunft = $test_con->prepare($sql_zukunft);
    $stmt_zukunft->bind_param('s', $heute);
    $stmt_zukunft->execute();
    $result_zukunft = $stmt_zukunft->get_result();

    $sql_vergangen = "SELECT id, datum, art FROM $tableName WHERE datum < ? ORDER BY datum DESC";
    $stmt_vergangen = $test_con->prepare($sql_vergangen);
    $stmt_vergangen->bind_param('s', $heute);
    $stmt_vergangen->execute();
    $result_vergangen = $stmt_vergangen->get_result();
}
?>



<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests</title>
    <link rel="stylesheet" href="Eingebundene-CSS-Scripte/Vokabeltrainer-Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="Vokabeltrainer-Allgemeine-JSFunktionen.js"></script>
    <style>

        table {
            width: 60%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: #f5f5f5;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            width: 50%;
        }

        th {
            background-color: #2d6a4f;
            color: white;
            font-size: 1.2em;
        }

        td {
            background-color: #e0e0e0;
            font-size: 1em;
        }

        /* Zebra-Streifen */
        tr:nth-child(even) td {
            background-color: #d0d0d0;
        }

        tr:nth-child(odd) td {
            background-color: #e0e0e0;
        }


        .eintragsformular {
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            width: 90%;
            margin: 20px auto;
        }

        .eintragsformular label {
            font-weight: bold;
            color: #2d6a4f;
        }

        .eintragsformular input[type="text"],
        .eintragsformular input[type="date"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 2px solid #2d6a4f;
            border-radius: 4px;
        }

        .eintragsformular input[type="submit"] {
            background-color: #2d6a4f;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .eintragsformular input[type="submit"]:hover {
            background-color: #1b4332;
        }

        .past-entries {
            padding: 8px;
            margin-top: 40px;
        }

        h2 {
            padding: 8px 0;
            text-align: center;
            margin: 20px auto;
        }

        .icon {
            margin-right: 10px;
            cursor: pointer;
            color: #2d6a4f;
        }

        .icon:hover {
            opacity: 0.7;
        }

        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            width: 300px;
            max-width: 90%;
            z-index: 1000;
            text-align: center;
        }

        .popup h3 {
            margin-bottom: 15px;
            color: #2d6a4f;
        }

        .popup button {
            background-color: #2d6a4f;
            color: white;
            border: none;
            padding: 8px 16px;
            margin-top: 10px;
            border-radius: 8px;
            cursor: pointer;
        }

        .popup button:hover {
            background-color: #1b4332;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .copyright-satz {
            color: #000000;
            font-size: 18px;
        }

        .footer {
            color: #999999;
            text-align: center;
            font-size: 14px;
            background-color: #e4d9d1;
            width: 100%;
        }

        .footer a {
            color: #2d6a4f;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }


        .footer p {
            color: #000000;
            font-size: 18px;
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

    <?php
    if (isset($_SESSION['username'])) {
    ?>
        <div class="eintragsformular">
            <form action="Vokabeltrainer-Tests.php" method="post">
                <label for="art">Art</label>
                <input type="text" id="art" name="art" required><br><br>
                <label for="datum">Datum</label>
                <input type="date" id="datum" name="datum" required><br><br>
                <input type="hidden" name="addEntry" value="1"> <!-- Wichtig! -->
                <input type="submit" value="Eintrag hinzufügen">
            </form>
        </div>


        <h2>Kommende oder heutige Einträge</h2>
        <table>
            <tr>
                <th>Datum</th>
                <th>Art</th>
                <th>Aktion</th>
            </tr>
            <?php
            if ($result_zukunft->num_rows > 0) {
                while ($row = $result_zukunft->fetch_assoc()) {
                    $deutschesDatum = date("d.m.Y", strtotime($row['datum']));
                    echo "<tr id='entry-" . $row['id'] . "'>
                            <td>" . htmlspecialchars($deutschesDatum) . "</td>
                            <td>" . htmlspecialchars($row['art']) . "</td>
                            <td>
                               <center>    
                                    <a href='javascript:void(0)' onclick='openPopup(\"edit\", " . $row["id"] . ", \"$deutschesDatum\", \"" . htmlspecialchars($row["art"]) . "\")' class='icon'>
                                        <i class='fas fa-pencil-alt'></i>
                                    </a>
                                </center>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Keine Einträge gefunden</td></tr>";
            }
            ?>
        </table>
        <br>

        <h2>Vergangene Einträge</h2>
        <table>
            <tr>
                <th>Datum</th>
                <th>Art</th>
                <th>Aktionen</th>
            </tr>
            <?php
            if ($result_vergangen->num_rows > 0) {
                while ($row = $result_vergangen->fetch_assoc()) {
                    $deutschesDatum = date("d.m.Y", strtotime($row['datum']));
                    echo "<tr id='entry-" . $row['id'] . "'>
                            <td>" . htmlspecialchars($deutschesDatum) . "</td>
                            <td>" . htmlspecialchars($row['art']) . "</td>
                            <td>
                               <center>    
                                    <a href='javascript:void(0)' onclick='openPopup(\"edit\", " . $row["id"] . ", \"$deutschesDatum\", \"" . htmlspecialchars($row["art"]) . "\")' class='icon'>
                                        <i class='fas fa-pencil-alt'></i>
                                    </a>
                                </center>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Keine Einträge gefunden</td></tr>";
            }
            ?>
        </table>
    <?php
    } else {
    ?>
        <div class="square">
			<br>
            <h2>Übersicht Tests</h2>
            <br>
            <center><p><i>Bitte melde dich an, um Tests hinzuzufügen und zu verwalten.</i></p></center>
        </div>
    <?php
    }
    ?>

    <br>
    <br>
    <br>
    <?php
	if (isset($_SESSION['username'])) {
	?>
	<br><br><br>
	<div class="footer">
		<p class="copyright-satz">&copy Alle Rechte vorbehalten | Anne Kämmerer | Version: <?php echo $version; ?></p>
		<div class="footerlinks">
			<a href="Vokabeltrainer-Datenschutz.php">Datenschutz |</a>
            <a href="Vokabeltrainer-Impressum.php"> Impressum |</a>
            <a href="Vokabeltrainer-FAQ.php"> FAQ |</a>
			<a href="Vokabeltrainer-Feedback.php"> Feedback</a>
		</div>
	</div>
	<?php
	}
	?>

    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popupEdit">
        <h3>Eintrag bearbeiten</h3>
        <form id="editForm" method="post" action="Vokabeltrainer-Tests.php">
            <input type="hidden" id="editId" name="editId">
            <label for="editDatum">Datum</label>
            <input type="date" id="editDatum" name="editDatum"><br><br>

            <label for="editArt">Art</label>
            <input type="text" id="editArt" name="editArt"><br><br>

            <button type="submit">Speichern</button>
            <button type="button" onclick="confirmDelete()">Löschen</button>
            <button type="button" onclick="closePopup()">Abbrechen</button>
        </form>
    </div>

    <div class="popup" id="popupDelete">
        <h3>Eintrag löschen</h3>
        <p>Bist du sicher, dass du diesen Eintrag löschen möchtest?</p>
        <button id="confirmDeleteBtn" onclick="deleteEntry(deleteEntryId)">Ja, löschen</button>
        <button onclick="closeDeletePopup()">Abbrechen</button>
    </div>

    <script>
        function openPopup(type, id, datum = '', art = '') {
            if (type === 'edit') {
                document.getElementById('editId').value = id;
            
                if (datum.includes('.')) {
                    const parts = datum.split('.');
                    datum = `${parts[2]}-${parts[1]}-${parts[0]}`;
                }
            
                document.getElementById('editDatum').value = datum;
                document.getElementById('editArt').value = art;
                document.getElementById('popupEdit').style.display = 'block';
            }

            document.getElementById('overlay').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('popupEdit').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function confirmDelete() {
            const id = document.getElementById('editId').value;
            if (id) {
                openDeletePopup(id);
            }
        }


        let deleteEntryId = null;

        function openDeletePopup(id) {
            deleteEntryId = id;
            document.getElementById('popupDelete').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closeDeletePopup() {
            document.getElementById('popupDelete').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function deleteEntry(entryId) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "Vokabeltrainer-Tests-Tabelle-Löschen.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = xhr.responseText.trim();
                    if (response === "success") {
                        const row = document.getElementById("entry-" + entryId);
                        if (row) row.remove();

                        closeDeletePopup();
                        closePopup();
                    }
                else {
                    alert("Fehler beim Löschen: " + response);
                }
                }
            };
            xhr.send("id=" + encodeURIComponent(entryId));
        }

    </script>
</body>
</html>

<?php
$stmt_zukunft->close();
$stmt_vergangen->close();
$con->close();
?>