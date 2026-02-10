<?php
session_start();

if (isset($_SESSION['user_id'])) {
    echo "<span><a href='Vokabeltrainer-Logout-Home.php'>Logout</a></span>";
} else {
    echo "<span><a href='Vokabeltrainer-Login-Home.php'>Login</a></span>";
}
?>
