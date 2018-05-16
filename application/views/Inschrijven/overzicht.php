<?php
/**
 * @file overzicht.php
 * @author Wim Naudts
 * 
 * View waar je een overzicht van je inschrijving op krijgt.
 */
?>
<h2>Overzicht inschrijving</h2>

<div class="table-responsive">
<table class="table table-striped">
    <thead>
        <tr>
            <th>Dagonderdeel</th>
            <th>Commentaar</th>
            <th>Activiteit</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach($dagonderdelen as $dagonderdeel){
    foreach($dagonderdeel->opties as $optie){
        foreach($ingeschrevenOpties as $inschrijfOptie){
            if($inschrijfOptie->optieId == $optie->id){
                echo "<tr><td>$dagonderdeel->naam ($dagonderdeel->starttijd" . " - " . "$dagonderdeel->eindtijd)</td>";
                echo "<td>$inschrijfOptie->commentaar</td>";
                echo "<td>$optie->naam</td></tr>";
            }
        }
    }
}
?>
    </tbody>
</table>
</div>

<?php 
echo smallDivAnchor("Vrijwilliger/Inschrijven/index/$personeelsfeest", "Aanpassen", 'class="btn btn-info"');
echo smallDivAnchor("Home/toonStartScherm", "Klaar", 'class="btn btn-success"');