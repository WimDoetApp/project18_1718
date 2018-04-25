<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Tijd</th>
                <th>Vrijwilligers</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                for ($i = 0; $i < count($taken); $i++) {
                    echo "<tr><td><label class=\"fw\">". $taken[$i]->naam . "</label></td>\n";
                    echo "<td><label class=\"fw\">" . $taken[$i]->tijd . "</label></td>\n";
                    echo "<td><label class=\"fw\">" . $taken[$i]->aantalPlaatsen . "</label></td>\n";

                    echo "<td>" . smallDivAnchor('Organisator/Taak/wijzig/' . $taken[$i]->id . "/$doId/$isD", 'Wijzigen', 'class="btn btn-warning"') . "</td>";
                    echo "<td>" . smallDivAnchor('Organisator/Taak/verwijderen/' . $taken[$i]->id . "/$doId/$isD", 'Verwijderen', 'class="btn btn-danger"') . "</td></tr>\n";
                }
            ?>
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