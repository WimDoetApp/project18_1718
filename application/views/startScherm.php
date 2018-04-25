<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
$soort = $gebruiker->soortId;

?>
<div class="panel panel-default">
    <div class="panel-heading"><h2>Schrijf je hier in voor het personeelsfeest</h2></div>
    <div class="panel-body"><?php echo smallDivAnchor("Vrijwilliger/Inschrijven/index/$personeelsfeest", "Inschrijven", 'class="btn btn-default panel-body"') ?></div>
</div>
<div class="panel panel-default">
    <div class="panel-heading"><h2>Bied hier je hulp aan voor het personeelsfeest</h2></div>
    <div class="panel-body"><?php echo smallDivAnchor("", "Hulp aanbieden", 'class="btn btn-default"') ?></div>
</div>
<?php
/**
 * Als de gebruiker een vrijwilliger of personeelslid is, heeft hij toegang tot deze links
 */
if ($soort == 1 || $soort == 2) { ?>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Bekijk hier foto's</h2></div>
        <div class="panel-body"><?php echo smallDivAnchor("", "Foto's bekijken", 'class="btn btn-default"') ?></div>
    </div>

<?php }
/**
 * Als de gebruiker een personeelslid is, heeft hij toegang tot deze links
 */
if ($soort == 2) { ?>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Voeg hier vrijwilligers toe</h2></div>
        <div class="panel-body"><?php echo smallDivAnchor("Personeelslid/GebruikerToevoegen/index/$personeelsfeest", "Vrijwilliger toevoegen", 'class="btn btn-default"') ?></div>
    </div>

<?php }
/**
 * Als de gebruiker een organisator is, heeft hij toegang tot deze links
 */
if ($soort == 3 || $soort == 4) { ?>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Bekijk hier de overzichten van taken en activiteiten</h2></div>
        <div class="panel-body"><?php echo smallDivAnchor("Oganisator/Overzicht/index/$personeelsfeest", "Overzichten", 'class="btn btn-default"') ?></div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Stuur hier mails naar deelnemers en vrijwilligers</h2></div>
        <div class="panel-body"><?php echo smallDivAnchor("", "Mails sturen", 'class="btn btn-default"') ?></div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Pas hier het personeelsfeest aan</h2></div>
        <div class="panel-body"><?php echo smallDivAnchor("Organisator/PersoneelsfeestBeheren", "Personeelsfeest beheren", 'class="btn btn-default"') ?></div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Beheer hier de foto's</h2></div>
        <div class="panel-body"><?php echo smallDivAnchor("Organisator/FotosBeheren/index", "Foto's beheren", 'class="btn btn-default"') ?></div>
    </div>
<?php } ?>

<div class="panel panel-default">
    <div class="panel-heading"><h2>Raadpleeg hier de e-mailadressen</h2></div>
    <div class="panel-body"><?php echo smallDivAnchor("", "Emails raadplegen", 'class="btn btn-default"') ?></div>
</div>
</body>
</html>
