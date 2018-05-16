<?php
/**
 * @file account.php
 * @author Wim Naudts
 * 
 * View met overzicht van het account van de ingelogde gebruiker en de mogelijkheid om zijn wachtwoord te veranderen
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Uw gegevens</h4>
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
                    <td><?php echo $gebruiker->naam ?></td>
                    <td><?php echo $gebruiker->voornaam ?></td>
                    <td><?php echo $gebruiker->email ?></td>
                    <td><?php echo $gebruiker->soort->naam ?></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><h4>Uw inschrijvingen:</h4></div>
    
    <div class="panel-body">
        <?php if($gebruiker->inschrijfOpties != ""){ ?>
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
                        
                        foreach ($gebruiker->inschrijfOpties as $inschrijfOptie){
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
        <p>U bent voor geen enkele activiteit ingeschreven.</p>
        <?php } ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><h4>U helpt bij deze taken:</h4></div>
    
    <div class="panel-body">
        <?php if($gebruiker->helperTaken != ""){ ?>
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
                            
                            foreach($gebruiker->helperTaken as $helperTaak){
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
        <p>U heeft zich niet ingeschreven als vrijwilliger.</p>
        <?php } ?>
    </div>
</div>

<?php
$attributes = array('name' => 'mijnFormulier', 'id' => 'form');
echo form_open("Personeelslid/GebruikerToevoegen/wachtwoordVeranderen", $attributes);
/**
* We geven altijd naar elke pagina door over welk personeelsfeest het gaat
 */
echo form_input(array('type' => 'hidden', 'name' => 'personeelsfeestId', 'value' => $personeelsfeest));
?>

<div class="panel panel-default">
    <div class="panel-heading"><h4>Wachtwoord aanpassen:</h4></div>
    
    <div class="panel-body">
        <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <td><?php echo form_label('Oud wachtwoord:', 'oud'); ?></td>
                <td><?php echo form_input(array('name' => 'oud', 'id' => 'oud', 'size' => '20', 'required' => 'required', 'class' => 'form-control')); ?></td>
            </tr>
            <tr>
                <td><?php echo form_label('Nieuw wachtwoord:', 'nieuw'); ?></td>
                <td><?php echo form_input(array('name' => 'nieuw', 'id' => 'nieuw', 'size' => '20', 'required' => 'required', 'class' => 'form-control')); ?></td>
            </tr>
            <tr>
                <td><?php echo form_label('Bevestig nieuwe wachtwoord:', 'bevestig'); ?></td>
                <td><?php echo form_input(array('name' => 'bevestig', 'id' => 'bevestig', 'size' => '20', 'required' => 'required', 'class' => 'form-control')); ?></td>
            </tr>
            <tr>
                <td><?php echo form_submit(array('name' => 'knopPasAan', 'value' => 'Wachtwoord aanpassen', 'class' => 'btn btn-success form-control')); ?></td>
            </tr>
        </table>
        </div>
    </div>
</div>
<?php echo form_close();

if($error){?>
    <script>
        $(document).ready(function(){
           alert("<?php echo $errorMessage ?>"); 
        });
    </script>
<?php } 