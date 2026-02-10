<?php
session_start();

$con = new mysqli("10.35.233.7:3306", "k218479_anne_login", "anne_login_PW!", "k218479_vokabeltrainer_anne_login");
if ($con->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $con->connect_error);
}

$con_tests = mysqli_connect("10.35.233.7:3306", "k218479_anne_tests", "anne_tests_PW!", "k218479_vokabeltrainer_anne_tests");
if (!$con_tests) {
    die("Verbindung zur Tests-Datenbank fehlgeschlagen: " . mysqli_connect_error());
}

if (isset($_SESSION['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $_SESSION['username'] = $username;
}

$isLoggedIn = isset($_SESSION['username']);

$version = file_get_contents('Sonstige-Scripte-u.-Vokabeln/Vokabeltrainer-Aktuelle-Version.txt');

if ($version === false) {
    $version = 'Unbekannte Version';
}
?>