<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$naamInput = array ('name' => 'naam', 'value' => '', 'size' => '15');
$beschrijvingInput = array ('name' => 'beschrijving', 'value' => '', 'size' => '50');
$KnopWijzig = array ('name' => 'action', 'value' => 'wijzig', 'content' => "<span class='glyphicon glyphicon-edit'></span>", 'class' => 'btn btn-warning');
$KnopVerwijder = array ('name' => 'action', 'value' => 'verwijder', 'content' => "<span class='glyphicon glyphicon-trash'></span>", 'class' => 'btn btn-danger');

?>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Tijd</th>
                <th>Vrijwilligers</th>
                <th>Aanpassen</th>
                <th>Verwijderen</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($taken as $taak) {
                    echo "<tr><td>$taak->naam</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>