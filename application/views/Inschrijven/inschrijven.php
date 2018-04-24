<h2>Activiteiten</h2>
<?php
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
foreach($dagonderdelen as $dagonderdeel){ 
    /**
     * Vrijwilligers krijgen alleen maar de dagonderdelen te zien waar ze aan mogen deelnemen
     */
    if(!($dagonderdeel->vrijwilligerMeeDoen == "0" && $gebruiker->soortId == 1)){
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
            
        $radiobutton = "<td><input type=radio class=radioButton name=optie[$dagonderdeel->id] value=$optie->id";
        
        if($optie->isAllIngeschreven == true){
            $radiobutton .= " checked/> <span style='color:green;'>Ingeschreven</span></td>";
        }
        else{
            if($optie->aantalIngeschreven > $optie->maximumAantalPlaatsen){
                $radiobutton .= " disabled='disabled'/> <span style='color:red;'>Volzet</span></td>";
            }else{
                $radiobutton .= " /> Inschrijven</td>";
            }
        }
        ?>
        
        <tr>
            <td><?php echo $optie->naam ?></td>
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
            
            if($optie->isAllIngeschreven == true){
               $radioGeen .= " /> Geen</td>";
            }
            else{
               $radioGeen .= "checked /> Geen</td>"; 
            }
            echo $radioGeen;
            ?>
        </tr>
    </tbody>
</table>
</div>

    <?php }
        } 
echo "<p>" . form_submit(array('name' => 'knopSubmit', 'value' => 'Bevestigen', 'class' => 'btn btn-success')) . "</p>"; 
echo form_close(); 
