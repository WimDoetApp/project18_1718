<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <?php if ($gebruiker == 1 || $gebruiker == 2) {?>
    <div>
        <h2>Schrijf je hier in voor het personeelsfeest</h2>
        <?php echo smallDivAnchor("", "", 'class="btn btn-default"') ?>
    </div>
    <div>
        <h2>Bied hier je hulp aan voor het personeelsfeest</h2>
        <?php echo smallDivAnchor("", "", 'class="btn btn-default"') ?>
    </div>
    <div>
        <h2>Bekijk hier foto's</h2>
        <?php echo smallDivAnchor("", "", 'class="btn btn-default"') ?>
    </div>
    
    <?php } 
    if ($gebruiker == 2) { ?>
     <div>
        <h2>Voeg hier vrijwilligers toe</h2>
        <?php echo smallDivAnchor("", "", 'class="btn btn-default"') ?>
    </div>
    
    <?php }
    if ($gebruiker == 3) { ?>
     <div>
        <h2>Bekijk hier de overzichten van taken en activiteiten</h2>
        <?php echo smallDivAnchor("", "", 'class="btn btn-default"') ?>
    </div>
    <div>
        <h2>Stuur hier mails naar deelnemers en vrijwilligers</h2>
        <?php echo smallDivAnchor("", "", 'class="btn btn-default"') ?>
    </div>
    <div>
        <h2>Pas hier het personeelsfeest aan</h2>
        <?php echo smallDivAnchor("", "", 'class="btn btn-default"') ?>
    </div>
    <div>
        <h2>Beheer hier de foto's</h2>
        <?php echo smallDivAnchor("", "", 'class="btn btn-default"') ?>
    </div>
    <?php }?>
   
    <div>
        <h2>Raadpleeg hier de e-mailadressen</h2>
        <?php echo smallDivAnchor("", "", 'class="btn btn-default"') ?>
    </div>
    
</body>
</html>
