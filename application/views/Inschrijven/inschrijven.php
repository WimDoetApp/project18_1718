<h2>Activiteiten</h2>
<?php
/**
 * @author Wim Naudts
 */
/**
 * formulier openen
 */
$attributes = array('name' => 'mijnFormulier');
echo form_open('Vrijwilliger/Inschrijven/schrijfIn', $attributes);
/**
 * We geven altijd naar elke pagina door over welk personeelsfeest het gaat
 */
echo form_input(array('type' => 'hidden', 'name' => 'personeelsfeestId', 'value' => $personeelsfeest));

/**
 * Voor elk dagonderdeel een tabel
 */
foreach($dagonderdelen as $index => $dagonderdeel){ 
    /**
     * Vrijwilligers krijgen alleen maar de dagonderdelen te zien waar ze aan mogen deelnemen
     */
    if(!($dagonderdeel->vrijwilligerMeeDoen == "0" && $gebruiker->soortId == 1)){
        
        $alIngeschreven = false; //voor geen knop
        
        $radioKlasse = "";
        
        /**
         * Voor conflicterende tijden
         */
        if(array_key_exists($index-1, $dagonderdelen) && array_key_exists($index+1, $dagonderdelen) && $dagonderdeel->starttijd < $dagonderdelen[$index-1]->eindtijd && $dagonderdeel->eindtijd > $dagonderdelen[$index+1]->starttijd){
            $radioKlasse = " conflictLang";
        }else{
            if((array_key_exists($index-1, $dagonderdelen) && $dagonderdeel->starttijd < $dagonderdelen[$index-1]->eindtijd) || (array_key_exists($index+1, $dagonderdelen) && $dagonderdeel->eindtijd > $dagonderdelen[$index+1]->starttijd)){
                $radioKlasse = " conflictKort";
            }
        }
    ?>
<div class="table-responsive">
<table class="table table-striped">
    <thead>
        <tr>
            <th>
                <h3><?php echo $dagonderdeel->naam ?></h3>
                <h4><?php echo $dagonderdeel->starttijd . " - " . $dagonderdeel->eindtijd ?></h4>
            </th>
            <th>Commentaar</th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>
        <?php
        /**
         * Alle opties weergeven
         */
        foreach($dagonderdeel->opties as $optie){
            
        $radiobutton = "<td><input type=radio name=optie[$dagonderdeel->id] value=$optie->id class='radio$radioKlasse'";
        
        if($optie->isAllIngeschreven == true){
            $radiobutton .= " checked/> <span style='color:green;'>Ingeschreven</span></td>";
            $alIngeschreven = true; //voor geen knop
        }
        else{
            if($optie->aantalIngeschreven > $optie->maximumAantalPlaatsen && $optie->maximumAantalPlaatsen != 0){
                $radiobutton .= " disabled='disabled'/> <span style='color:red;'>Volzet</span></td>";
            }else{
                $radiobutton .= " /> Inschrijven</td>";
            }
        }
        
        ?>
        
        <tr>
            <td>
                <?php 
                echo "<h5>$optie->naam<h5>";
                echo "<p>$optie->beschrijving</p>";
                ?>
            </td>
            <?php
            if($optie->isAllIngeschreven == true){
                $commentaar = $optie->commentaar;
            }else{
                $commentaar = '';
            }
            echo "<td>" . form_input(array('type' => 'text', 'name' => "commentaar[$optie->id]", 'value' => $commentaar, 'class' => 'form-control')) . "</td>";
            echo $radiobutton;
            ?>
        </tr>  
        
        <?php } ?>
        <tr>
            <td></td>
            <td></td>
            <?php 
            $radioGeen = "<td><input type=radio class=radioButton name=optie[$dagonderdeel->id] value=0";
            
            if($alIngeschreven == true){
               $radioGeen .= " /> Geen</td>";
            }
            else{
               $radioGeen .= " checked /> Geen</td>"; 
            }
            echo $radioGeen;
            ?>
        </tr>
    </tbody>
</table>
</div>

    <?php }else{
        echo "<h3>$dagonderdeel->naam</h3><p>Vrijwilligers kunnen niet deelnemen aan activiteiten tijdens $dagonderdeel->naam";
    }
        } 
echo "<p>" . form_submit(array('name' => 'knopSubmit', 'value' => 'Bevestigen', 'class' => 'btn btn-success')) . "</p>"; 
echo form_close(); 
?>

<script>
    $( document ).ready(function() {
        $('.radio').change(function(){
            if($(this).hasClass('conflictLang')){
                $('.conflictKort').prop('checked', false);
            }
            
            if($(this).hasClass('conflictKort')){
                $(".conflictLang").prop('checked', false);
            }
        });
    });
</script>
