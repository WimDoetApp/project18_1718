<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$naamInput = array ('name' => 'naam', 'value' => '', 'size' => '15', 'class' => 'form-control');
$beschrijvingInput = array ('name' => 'beschrijving', 'value' => '', 'size' => '50', 'class' => 'form-control');
$KnopWijzig = array ('name' => 'action', 'value' => 'Wijzig', 'content' => "<span class='glyphicon glyphicon-edit'></span>", 'class' => 'btn btn-warning');
$KnopVerwijder = array ('name' => 'action', 'value' => 'Verwijder', 'content' => "<span class='glyphicon glyphicon-trash'></span>", 'class' => 'btn btn-danger');
?>
<br/>
<div class="table-responsive">
<table class="table table-striped">
    <thead class="thead-dark">
    <tr>
        <th>Naam</th>
        <th>Beschrijving</th>
    </tr>
    </thead>
    <tbody>
        <?php
        foreach ($locaties as $locatie) {
            $naamInput['value'] = $locatie->naam;
            $beschrijvingInput['value'] = $locatie->beschrijving;
            echo "<form method=\"post\" action=\"knopInput\"> \n";
            echo "<tr><td>" . form_hidden('id', "$locatie->id") . form_input($naamInput) . "</td>\n";
            echo "<td>" . form_input($beschrijvingInput) . "</td>\n";
            echo "<td>" . form_submit($KnopWijzig) . "</td>\n";
            echo "<td>" . form_submit($KnopVerwijder) . "</td>\n";
            echo "</form>\n";
        }
        ?>
        <tr>
            <td colspan="3"><?php echo smallDivAnchor('Organisator/Locatie/voegToe', 'Nieuwe locatie aanmaken', 'class="btn btn-success"')?></td>
            <td><?php echo smallDivAnchor('Organisator/PersoneelsfeestBeheren/index', 'Terug gaan', 'class="btn btn-info"')?></td>
        </tr>
    </tbody>
</table>
</div>