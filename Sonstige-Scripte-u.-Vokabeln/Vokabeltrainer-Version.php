<?php
$version = file_get_contents('Vokabeltrainer-Aktuelle-Version.txt');

if ($version === false) {
    $version = 'Unbekannte Version';
}
?>
