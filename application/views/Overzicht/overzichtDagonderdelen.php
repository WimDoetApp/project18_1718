<?php
/**
 * @author Wim Naudts
 */
foreach($dagonderdelen as $dagonderdeel){?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?php
            echo "<h2>$dagonderdeel->naam</h2><h3>$dagonderdeel->starttijd - $dagonderdeel->eindtijd</h3>";
        ?>
    </div>
    
    <div class="panel-body">
        <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Activiteiten</th>
                    <th></th>
                    <?php if ($dagonderdeel->heeftTaak != "1"){ ?>
                    <th></th>
                    <?php } ?>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
                <?php
                foreach($dagonderdeel->opties as $optie){
                    echo "<tr><td>$optie->naam</td>";
                    echo "<td>" . smallDivAnchor("Organisator/ActiviteitenBeheren/index/$optie->id/$dagonderdeel->id", "Activiteit aanpassen", 'class="btn btn-warning"') . "</td>";
                    
                    if($dagonderdeel->heeftTaak != "1"){
                        echo "<td>" . smallDivAnchor("Organisator/Taak/index/$optie->id/0", "Taken aanpassen", 'class="btn btn-warning"') . "</td>";
                    }
                    
                    echo "<td>" . smallDivAnchor("Organisator/ActiviteitenBeheren/verwijderActiviteit/$optie->id", "Activiteit verwijderen", 'class="btn btn-danger"') . "</td>";
                    
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        </div>
        
        <?php 
        echo "<p>" . smallDivAnchor("Organisator/ActiviteitenBeheren/index/0/$dagonderdeel->id", "Activiteit toevoegen", 'class="btn btn-success"') . "</p>"; 
        
        if($dagonderdeel->heeftTaak == "1"){
            echo "<p>" . smallDivAnchor("Organisator/Taak/index/$dagonderdeel->id/1", "Taken aanpassen", 'class="btn btn-warning"') . "</p>";
        }
        ?>
    </div>
</div>

<?php 
 }
 echo smallDivAnchor("Organisator/PersoneelsfeestBeheren/index", "Teruggaan", 'class="btn btn-info"');