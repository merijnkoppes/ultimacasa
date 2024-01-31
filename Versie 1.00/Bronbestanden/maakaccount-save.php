<?php

include_once("functions.php");

$email = $_GET["Email"];
$rawww = $_GET["Wachtwoord"];
$ww = password_hash($rawww, PASSWORD_DEFAULT);

$db = ConnectDB();

// Use a prepared statement to prevent SQL injection
$sql = "SELECT relaties.ID as RID,
                rollen.Waarde as Rol,
                Landingspagina,
                Wachtwoord 
        FROM relaties
        LEFT JOIN rollen ON relaties.FKrollenID = rollen.ID
        WHERE Email = :email";
                   
$stmt = $db->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$inlog = $stmt->fetch();

$redirect_url = 'index.php?NOAccount';
if ($inlog && password_verify($rawww, $inlog['Wachtwoord']))
{
    $redirect_url = $inlog['Landingspagina'] . '?RID=' . $inlog['RID'];
}

echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '. $redirect_url . '">';
?>
