<?php
foreach ($dagonderdelen as $dagonderdeel) {
    if ($dagonderdeel->heeftTaak == "1") {
        echo $dagonderdeel->naam;
        var_dump($dagonderdeel);
    }
    else {
        var_dump($dagonderdeel->opties);
        foreach ($dagonderdeel->opties as $optie){
            echo $optie->naam;
        }
    }
}














echo '</table>';

echo smallDivAnchor('home/index', "Teruggaan", 'class="btn btn-info"');


?>
