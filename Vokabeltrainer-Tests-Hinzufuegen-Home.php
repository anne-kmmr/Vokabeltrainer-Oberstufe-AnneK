<?php
include 'Vokabeltrainer-Sitzungsverwaltung.php';

mysqli_set_charset($con, "utf8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editId'])) {
        $editId = $_POST['editId'];
        $datum = $_POST['editDatum'];
        $art = $_POST['editArt'];

        $stmt = $con->prepare("UPDATE vokabeltrainer_tests SET datum = ?, art = ? WHERE id = ?");
        $stmt->bind_param('ssi', $datum, $art, $editId);
        $stmt->execute();
        $stmt->close();
    } else {
        $datum = isset($_POST['datum']) ? trim($_POST['datum']) : '';
        $art = isset($_POST['art']) ? trim($_POST['art']) : '';

        if (!empty($datum) && !empty($art)) {
            $stmt = $con->prepare("INSERT INTO vokabeltrainer_tests (datum, art) VALUES (?, ?)");
            $stmt->bind_param('ss', $datum, $art);
            $stmt->execute();
            $stmt->close();
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$heute = date('Y-m-d');

$sql_zukunft = "SELECT id, datum, art FROM vokabeltrainer_tests WHERE datum >= ? ORDER BY datum ASC";
$stmt_zukunft = $con->prepare($sql_zukunft);
$stmt_zukunft->bind_param('s', $heute);
$stmt_zukunft->execute();
$result_zukunft = $stmt_zukunft->get_result();

$sql_vergangen = "SELECT id, datum, art FROM vokabeltrainer_tests WHERE datum < ? ORDER BY datum DESC";
$stmt_vergangen = $con->prepare($sql_vergangen);
$stmt_vergangen->bind_param('s', $heute);
$stmt_vergangen->execute();
$result_vergangen = $stmt_vergangen->get_result();

$stmt_zukunft->close();
$stmt_vergangen->close();
$con->close();
?>