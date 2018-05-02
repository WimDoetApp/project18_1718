<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$inputNaam = array ('name' => 'naam', 'value' => $taak->naam, 'size' => '100');
$inputBeschrijving = array ('name' => 'beschrijving', 'value' => $taak->beschrijving, 'size' => '100');
$inputWijzig = array('name' => 'action', 'value' => 'Wijzig', 'content' => "<span class='glyphicon glyphicon-edit'></span>", 'class' => 'btn btn-warning');
$inputVerwijder = array('name' => 'action', 'value' => 'Verwijder', 'content' => "<span class='glyphicon glyphicon-edit'></span>", 'class' => 'btn btn-danger');
?>
<form method="post" action="index.php/Organisator/TaakShift/inputRouting">
    <div class="table-responsive">
        <table class="table">
            <tr>
                <td><label for="naam">Naam van de taak:</label></td>
                <td colspan="2"><?php echo form_input($inputNaam) . form_hidden('TYPE', 'T') . form_hidden('taakId', $taak->id). form_hidden('doID', "$doId") . form_hidden('isD', "$isD")?></td>
            </tr>
            <tr>
                <td><label for="naam">Beschrijving:</label></td>
                <td colspan="2"><?php echo form_input($inputBeschrijving)?></td>
            </tr>
            <tr>
                <td><?php echo form_submit($inputWijzig)?></td>
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
                echo "<tr><form method=\"POST\" action=\"inputRouting\"><td>" . form_hidden('id', "$shift->id") . form_hidden('doID', "$doId") . form_hidden('isD', "$isD") . form_hidden('taakId', "$taak->id") . form_hidden('TYPE', 'T') . form_input('begintijd', $shift->begintijd) . "</td><td>" . form_input('eindtijd', $shift->eindtijd) . "</td><td>" . form_input('aantalPlaatsen', $shift->aantalPlaatsen) . "</td><td>" . $shift->aantalInschrijvingen . "</td>";
                echo "<td>" . form_submit($inputWijzig) . "</td>";
                echo "<td>" . form_submit($inputVerwijder) . "</td>";
                echo "</form></tr>";
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