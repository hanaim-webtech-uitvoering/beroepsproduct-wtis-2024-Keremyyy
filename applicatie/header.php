<?php
function renderHeader () {
    return '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS_casus_Homepage.css">
    <link rel="stylesheet" href="Hooft_opmaak.css">
</head>
<body>
<header>
    <a href="index.php" class="logo">
        <img src="logoBakker.png" alt="bakker">
    </a>
    <nav>
        <a href="Order.php">Bestellingsoverzicht</a>
        <a href="winkelmandje.php">Winkelmandje</a>
        <a href="profielPagina.php">Profielpagina</a>
        <a href="Inloggen.php" class="Login">login</a>
    </nav>
</header>';
}
?>