<?php
session_start();

if (isset($_POST['id']) && isset($_SESSION['username'])) {
    $id = intval($_POST['id']);
    $username = $_SESSION['username'];
    $tableName = "vokabeltrainer_tests_" . $username;

    $con = mysqli_connect("10.35.233.7:3306", "k218479_anne_tests", "anne_tests_PW!", "k218479_vokabeltrainer_anne_tests");
    if (!$con) {
        echo "Datenbankfehler";
        exit;
    }

    mysqli_set_charset($con, "utf8");

    $stmt = $con->prepare("DELETE FROM $tableName WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Fehler: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
} else {
    echo "Ungültige Anfrage";
}
?>
