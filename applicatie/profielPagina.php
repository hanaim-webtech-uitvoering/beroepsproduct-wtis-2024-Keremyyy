<?php
include 'header.php';
session_start();
if (!isset($_SESSION["gebruiker_ingelogd"]) || $_SESSION["gebruiker_ingelogd"] == false ){
    header("Location: index.php");
    exit();
}
?>
<html>

<?php echo renderHeader(); ?>
<main>
        <section class="profile">
            <h1>Profiel</h1>
            <div class="profile-info">
                <img src="hackerman.png" alt="Profielfoto" class="profile-picture">               
                <div class="details">
                    <h2>Gebruikersnaam: <?php echo ($_SESSION["username"]);?></h2>
                    <p>Naam: <?php echo ($_SESSION["voornaam"] . " " . $_SESSION["achternaam"])?>  </p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>