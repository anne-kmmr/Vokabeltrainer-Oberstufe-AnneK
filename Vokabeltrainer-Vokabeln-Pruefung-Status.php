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

session_start(); 

if (isset($_POST['vokabel'], $_POST['status'], $_SESSION['username'])) {
    $user = $_SESSION['username'];
    $tableName = "vokabeltrainer_vokabeln_" . $conn->real_escape_string($user);
    $vokabel = $conn->real_escape_string($_POST['vokabel']);
    $status = $conn->real_escape_string($_POST['status']);

    $updateQuery = "UPDATE `$tableName` SET status='$status' WHERE deutsch='$vokabel'";

    if ($conn->query($updateQuery) === TRUE) {
        if ($conn->affected_rows > 0) {
            echo "Erfolg";
        } else {
            echo "Keine Zeile aktualisiert - möglicherweise keine Übereinstimmung gefunden.";
        }
    } else {
        echo "Fehler: " . $conn->error;
    }
} else {
    echo "POST-Daten oder Session-Username nicht gesetzt.";
}

$conn->close();
