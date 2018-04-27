<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$inputNaam = array ('name' => 'naam', 'value' => $taak->naam, 'size' => '100');
$inputBeschrijving = array ('name' => 'naam', 'value' => $taak->beschrijving, 'size' => '100');
$inputSubmit = array('name' => 'action', 'value' => 'Wijzig', 'content' => "<span class='glyphicon glyphicon-edit'></span>", 'class' => 'btn btn-warning');
?>
<form method="post" action="">
    <div class="table-responsive">
        <table class="table">
            <tr>
                <td><label for="naam">Naam van de taak:</label></td>
                <td colspan="2"><?php echo form_input($inputNaam)?></td>
            </tr>
            <tr>
                <td><label for="naam">Beschrijving:</label></td>
                <td colspan="2"><?php echo form_input($inputBeschrijving)?></td>
            </tr>
            <tr>
                <td><?php echo form_submit($inputSubmit)?></td>
                <td></td>
            </tr>
        </table>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Start</th>
                <th>Einde</th>
                <th>Aantal helpers</th>
                <th>Aantal inschrijvingen</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shiften as $shift)  {
                echo "<tr><td>" . form_hidden('id', "$shift->id") . form_input('begintijd', $shift->begintijd) . "</td><td>" . form_input('eindtijd', $shift->eindtijd) . "</td><td>" . form_input('aantalPlaatsen', $shift->aantalPlaatsen) . "</td><td>" . form_input('aantalInschrijvingen', $shift->aantalInschrijvingen) . "</td>";
                echo "<td>" . smallDivAnchor('Organisator/TaakShift/wijzigen/' . "$taak->id/$doId/$isD", 'Wijzigen', 'class="btn btn-warning"') . "</td>";
                echo "</tr>";
            }?>
            <tr>
                <td colspan="4"><?php echo smallDivAnchor('Organisator/TaakShift/voegToe/' . $doId . "/$isD", 'Nieuwe taak aanmaken', 'class="btn btn-success"')?></td>
                <td><?php echo smallDivAnchor('Organisator/Taak/index/' . "$doId/$isD", 'Terug gaan', 'class="btn btn-info"')?></td>
            </tr>
        </tbody>
    </table>
</div>

<style>
    .fw {
        font-weight: normal;
    }
</style>