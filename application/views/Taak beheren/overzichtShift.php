<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$naam = "Naam van de ";
if ($isD) {
    $naam .= "Dagonderdeel";
} else {
    $naam .= "Optie";
}

$inputNaam = array ('name' => 'naam', 'value' => '', 'size' => '100');
$inputBeschrijving = array ('name' => 'naam', 'value' => '', 'size' => '100');

?>
<form method="post" action="">
    <div class="table-responsive">
        <table class="table">
            <tr>
                <td><label for="naam"><?php echo $naam . ":";?></label></td>
                <td colspan="2"><?php echo form_input($inputNaam)?></td>
            </tr>
            <tr>
                <td><label for="naam">Beschrijving:</label></td>
                <td colspan="2"><?php echo form_input($inputNaam)?></td>
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
            
            <tr>
                <td colspan="4"><?php echo smallDivAnchor('Organisator/Taak/voegToe/' . $doId . "/$isD", 'Nieuwe taak aanmaken', 'class="btn btn-success"')?></td>
                <td><?php echo smallDivAnchor('home/index', 'Terug gaan', 'class="btn btn-info"')?></td>
            </tr>
        </tbody>
    </table>
</div>

<style>
    .fw {
        font-weight: normal;
    }
</style>