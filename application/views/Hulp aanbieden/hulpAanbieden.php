<?php
foreach ($dagonderdelenTaken as $dagonderdeelTaak) {
    echo $dagonderdeelTaak->naam;
}
foreach ($taken as $taak) {
    echo $taak->naam;
    echo $taak->beschrijving;
}
foreach ($taakShiften as $taakShift) {
    echo $taakShift->aantalPlaatsen;
}

echo '<table class="table-striped">';

echo '<tr><td></td><td></td></tr>';
echo '<tr><td></td><td></td></tr>';














echo '</table>';

echo smallDivAnchor('home/index', "Teruggaan", 'class="btn btn-info"');


?>
