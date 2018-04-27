<?php
echo "<table class='table-striped'>";
echo "<tr><th>Dagonderdeel</th><th>Inschrijven als helper</th><th>Aantal ingeschreven</th>";
foreach ($dagonderdelen as $dagonderdeel) {
    $ingeschreven = 0;
    $maxAantal = 0;
    // TODO ingeschreven terug op 0 zetten.
    echo "</tr><tr>";
    /**
     * Contoleren of het dagonderdeel een taak heeft.
     * Indien dit het geval is wordt het aantal plaatsen en het maximum aantal plaatsen geteld en wordt de taak teruggegeven.
     * Indien dit niet het geval is wordt de optie weergegeven
     */
    if ($dagonderdeel->heeftTaak == "1") {
        foreach ($dagonderdeel->taken as $taak) {
            foreach ($taak->shiften as $shift) {
                $ingeschreven += $shift->aantalIngeschreven;
                $maxAantal += $shift->aantalPlaatsen;
            }
        }
        echo "<td>dagonderdeelTaak: " . $dagonderdeel->naam . "</td>";
    } else {
        foreach ($dagonderdeel->opties as $optie) {
            foreach ($optie->taak as $taak) {
                foreach ($taak->shiften as $shift) {
                    $ingeschreven += $shift->aantalIngeschreven;
                    echo $ingeschreven;
                }
            }
            echo "<td>dagonderdeelOptie: " . $optie->naam . "</td>";
            $maxAantal = $optie->maximumAantalPlaatsen;
        }
    }

    /**
     * Controleren hoeveel personen er zijn ingeschreven
     */
    if ($ingeschreven == $maxAantal) {
        echo "<td><a href='#' class='btn btn-danger' disabled='true'>Volzet</a></td>";
    } else if ((($ingeschreven / $maxAantal) * 100) > 75) {
        echo "<td><a href='#'class='btn btn-warning'>Inschrijven</a></td>";
    } else {
        echo "<td><a href='#'class='btn btn-default'>Inschrijven</a></td>";
    }
    echo "<td>" . $ingeschreven . "/" . $maxAantal . "</td>";
var_dump($dagonderdeel);
echo "<br />";
}

echo '</tr></table>';

echo smallDivAnchor('home/index', "Teruggaan", 'class="btn btn-info"');
?>
