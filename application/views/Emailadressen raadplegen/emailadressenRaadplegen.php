<?php
?>
<table class="table">
    <?php foreach ($takenMetDeelnemers as $taak => $deelnemers){?>
    <tr><th colspan="2"><?php echo $taak ?></th></tr>
    <tr>
        <th>Naam</th>
        <th>E-mail</th>
    </tr>
    <tr>
        <?php foreach($deelnemers as $deelnemer) { ?>
        <td><?php echo $deelnemer->voornaam?> <?php echo $deelnemer->naam ?></td>
        <td><?php echo $deelnemer->email ?></td>
        <?php } ?>
    </tr>
    <?php } ?>
    <tr><th colspan="2">Organisatoren</th></tr>
    <tr>
        <th>Naam</th>
        <th>E-mail</th>
    </tr>
        <?php foreach ($organisatoren as $organisator){ 
           if ($organisator->personeelsfeestId == $personeelsfeest){
            ?>
        <tr>
            <td><?php echo $organisator->voornaam?> <?php echo $organisator->naam ?></td>
            <td><?php echo $organisator->email ?></td>
        </tr>  
        <?php } }?>
</table>


<p><?php echo smallDivAnchor('home/index', "Teruggaan", 'class="btn btn-info"');?></p>
