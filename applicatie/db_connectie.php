<?php

// defined in 'variables.env'
$db_host = 'database_server'; // de database server, wodt later veranderd wanneer dit op de server komt te staan ipv docker.
$db_name = 'pizzeria';                    // naam van database

// defined in sql-script 'movies.sql'   wordt later veranderd voor de webserver.
$db_user    = 'sa';                 // db user
$db_password = 'abc123!@#';  // wachtwoord db user
 
// Het 'ssl certificate' wordt altijd geaccepteerd (niet overnemen op productie, verder dan altijd "TrustServerCertificate=1"!!!)
$verbinding = new PDO('sqlsrv:Server=' . $db_host . ';Database=' . $db_name . ';ConnectionPooling=0;TrustServerCertificate=1', $db_user, $db_password);
 
// Bewaar het wachtwoord niet langer onnodig in het geheugen van PHP.
unset($db_password);
 
// Zorg ervoor dat eventuele fouttoestanden ook echt als fouten (exceptions) gesignaleerd worden door PHP.
$verbinding->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Functie om in andere files toegang te krijgen tot de verbinding.
function maakVerbinding() {
  global $verbinding;
  return $verbinding;
}

?>