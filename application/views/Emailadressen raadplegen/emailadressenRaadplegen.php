<?php
?>
<p>Vrijwilligers</p>
<table class="table">
    <tr>
        <th>Naam</th>
        <th>E-mail</th>
        <th></th>
    </tr>
        <?php foreach ($vrijwilligers as $vrijwilliger){ ?>
        <tr>
            <td><?php echo $vrijwilliger->voornaam?> <?php echo $vrijwilliger->naam ?></td>
            <td><?php echo $vrijwilliger->email ?></td>
            <td><?php echo $vrijwilliger->personeelsfeestId ?></td>
        </tr>  
        <?php }?>
   
</table>
</br>
</br>
</br>
<p>Organisatoren</p>
<table class="table">
    <tr>
        <th>Naam</th>
        <th>E-mail</th>
        <th></th>
    </tr>
        <?php foreach ($organisatoren as $organisator){ ?>
        <tr>
            <td><?php echo $organisator->voornaam?> <?php echo $organisator->naam ?></td>
            <td><?php echo $organisator->email ?></td>
            <td><?php echo $organisator->personeelsfeestId ?></td>
        </tr>  
        <?php }?>
   
</table>

<p><?php echo smallDivAnchor('home/index', "Teruggaan", 'class="btn btn-info"');?></p>
