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
            </tr>
        </thead>
        <tbody>
            <?php
                for ($i = 0; $i < count($taken); $i++) {
                    echo "<tr><td><label class=\"fw\">". $taken[$i]->naam . "</label></td>\n";
                    echo "<td><label class=\"fw\">" . $taken[$i]->tijd . "</label></td>\n";
                    echo "<td><label class=\"fw\">" . $taken[$i]->aantalPlaatsen . "</label></td>\n";
                    echo "<td>" . smallDivAnchor('Taak/wijzig/' . $taken[$i]->id . "/$doId", 'Wijzigen', 'class="btn btn-warning"') . "</td></tr>\n";
                }
            ?>
            <tr>
                <td colspan="3"><?php echo smallDivAnchor('Taak/voegToe/' . $doId, 'Nieuwe taak aanmaken', 'class="btn btn-success"')?></td>
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