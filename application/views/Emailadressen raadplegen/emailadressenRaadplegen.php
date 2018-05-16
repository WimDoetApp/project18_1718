<?php
?>
<div class="table-responsive">
<table class="table table-striped">
    <?php if($takenMetDeelnemers != ""){
    foreach ($takenMetDeelnemers as $taak => $deelnemers){?>
    <tr><th colspan="2" style="font-size:20px;"><?php echo $taak ?></th></tr>
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
    <?php } } ?>
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
</div>

<p><?php echo smallDivAnchor('home/index', "Terug", 'class="btn btn-info"');?></p>
