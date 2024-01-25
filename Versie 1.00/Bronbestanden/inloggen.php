<?php

include_once("functions.php");

$email = '"' . $_GET["Email"] . '"';
$rawww = '"' . $_GET["Wachtwoord"] . '"';
$ww = password_hash($rawww, PASSWORD_DEFAULT);

$db = ConnectDB();
$sql = "SELECT relaties.ID as RID,
                rollen.Waarde as Rol,
                Landingspagina,
                Wachtwoord 
        FROM relaties
        LEFT JOIN rollen ON relaties.FKrollenID = rollen.ID
        WHERE (Email = $email)";
                   
$inlog = $db->query($sql)->fetch();

$redirect_url = 'index.php?NOAccount';
if ($inlog && password_verify($_GET["Wachtwoord"], $inlog['Wachtwoord']))
{
    $redirect_url = $inlog['Landingspagina'] . '?RID=' . $inlog['RID'];
}

echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '. $redirect_url . '">';
?>
