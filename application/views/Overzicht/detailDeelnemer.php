<?php
/**
 * @author Wim Naudts
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Algemeen</h4>
    </div>
    
    <div class="panel-body">
        <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Voornaam</th>
                    <th>E-mail</th>
                    <th>Soort</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td><?php echo $deelnemer->naam ?></td>
                    <td><?php echo $deelnemer->voornaam ?></td>
                    <td><?php echo $deelnemer->email ?></td>
                    <td><?php echo $deelnemer->soort->naam ?></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><h4>Als deelnemer:</h4></div>
    
    <div class="panel-body">
        <?php if($deelnemer->inschrijfOpties != ""){ ?>
        <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <?php 
                    foreach ($dagonderdelen as $dagonderdeel){
                        echo "<th><p>$dagonderdeel->naam</p><h5>$dagonderdeel->starttijd - $dagonderdeel->eindtijd</h5></th>";
                    }
                    ?>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <?php
                    foreach($dagonderdelen as $dagonderdeel){
                        $geenInschrijving = true;
                        
                        foreach ($deelnemer->inschrijfOpties as $inschrijfOptie){
                            if ($inschrijfOptie->optie->dagOnderdeelId == $dagonderdeel->id){
                                echo "<td><p>" . $inschrijfOptie->optie->naam . "</p>";
                                
                                if($inschrijfOptie->commentaar != ""){
                                    echo "<h6>Commentaar: <i>$inschrijfOptie->commentaar</i></h6>";
                                }
                                
                                echo "</td>";
                                
                                $geenInschrijving = false;
                            }
                        }
                        
                        if($geenInschrijving){
                            echo "<td></td>";
                        }
                    }
                    ?>
                </tr>
            </tbody>
        </table>
        </div>
        <?php }else{ ?>
        <p>Deze persoon is voor geen enkele activiteit ingeschreven.</p>
        <?php } ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><h4>Als vrijwilliger:</h4></div>
    
    <div class="panel-body">
        <?php if($deelnemer->helperTaken != ""){ ?>
            <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <?php 
                        foreach ($dagonderdelen as $dagonderdeel){
                            echo "<th><p>$dagonderdeel->naam</p><h5>$dagonderdeel->starttijd - $dagonderdeel->eindtijd</h5></th>";
                        }
                    ?>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <?php
                        foreach($dagonderdelen as $dagonderdeel){
                            $geenHulp = true;
                            
                            foreach($deelnemer->helperTaken as $helperTaak){
                                if($helperTaak->taakShift->taak->dagOnderdeelId == $dagonderdeel->id){
                                    echo "<td><p>" . $helperTaak->taakShift->taak->naam . "</p>";
                                    
                                    echo "<h6>Shift: <i>" . $helperTaak->taakShift->begintijd . " - " . $helperTaak->taakShift->eindtijd . "</i></h6>";
                                    
                                    if($helperTaak->commentaar != ""){
                                        echo "<h6>Commentaar: <i>$helperTaak->commentaar</i></h6>";
                                    }
                                    
                                    echo "</td>";
                                    
                                    $geenHulp = false;
                                }
                            }
                            
                            if($geenHulp){
                                echo "<td></td>";
                            }
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
            </div>
        <?php }else{ ?>
        <p>Deze persoon heeft zich niet ingeschreven als vrijwilliger.</p>
        <?php } ?>
    </div>
</div>

<?php echo smallDivAnchor("Organisator/DeelnemersBekijken/index/$personeelsfeest", "Teruggaan", 'class="btn btn-info"');