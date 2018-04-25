<?php 
/**
 * @author Wim Naudts
 */
/**
 * Knop om nieuw dagonderdeel aan te maken
 */
$dataNieuw = array(
    'name'          => 'buttonNieuw',
    'value'         => 'nieuw',
    'type'          => 'submit',
    'content'       => 'Nieuw dagonderdeel aanmaken',
    'class'         => 'btn btn-success'
);
/**
 * formulier openen
 */
$attributes = array('name' => 'mijnFormulier');
echo form_open('Organisator/DagonderdeelBeheren/getInput', $attributes);
/**
 * We geven altijd naar elke pagina door over welk personeelsfeest het gaat
 */
echo form_input(array('type' => 'hidden', 'name' => 'personeelsfeestId', 'value' => $personeelsfeest));
?>
<div class="table-responsive">
<table class="table table-striped">
    <thead>
        <tr>
            <th>Naam</th>
            <th>Beginuur</th>
            <th>Einduur</th>
            <th><span data-toggle="tooltip" title="Wanneer u deze optie aanzet, zullen de taken voor de helpers bij dit dagonderdeel horen, inplaats van nog onderverdeeld te zijn tussen de opties bij het dagonderdeel.">Dagonderdeel heeft taken</span></th>
            <th><span data-toggle="tooltip" title="Als u deze optie aanzet, mogen vrijwilligers aan de activiteiten bij dit dagonderdeel deelnemen.">Vrijwilligers mogen deelnemen</span></th>
            <th>Locatie</th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>
        <?php   
        $teller = 0;
        foreach($dagonderdelen as $dagonderdeel){ 
            /**
             * declareren variabelen
             */
            $checkboxen = "";
            $dropdownLocaties;
            
            /**
             * Opbouwen dropdownlijst met locaties
             */
            $dropdownLocaties = "<select class='form-control' name=locatie[$teller]>";
            
            foreach($locaties as $locatie){
                if ($locatie->id == $dagonderdeel->locatieId) {
                    $dropdownLocaties .= "<option value=$locatie->id selected>$locatie->naam</option>";
                }else{
                    $dropdownLocaties .= "<option value=$locatie->id>$locatie->naam</option>";
                }
            }
            
            $dropdownLocaties .= "</select>";
            
            /**
             * Opbouwen checkboxen voor heeftTaak en VrijwilligerMeedoen
             */
            if ($dagonderdeel->heeftTaak == 1) {
                $checkboxen .= "<input type=checkbox class=checkboxClick name=heeftTaak[$teller] value=$dagonderdeel->heeftTaak checked /></td>";
            }else{
                $checkboxen .= "<input type=checkbox class=checkboxClick name=heeftTaak[$teller] value=$dagonderdeel->heeftTaak /></td>";
            }
            
            if ($dagonderdeel->vrijwilligerMeeDoen == 1) {
                $checkboxen .= "<td><input type=checkbox class=checkboxClick name=vrijwilligerMeedoen[$teller] value=$dagonderdeel->vrijwilligerMeeDoen checked />";
            }else{
                $checkboxen .= "<td><input type=checkbox class=checkboxClick name=vrijwilligerMeedoen[$teller] value=$dagonderdeel->vrijwilligerMeeDoen />";
            } 
            
            /**
             * Data knoppen
             */
            $dataWijzig = array(
                'name'          => 'buttonWijzig',
                'value'         => $teller,
                'type'          => 'submit',
                'content'       => "<span class='glyphicon glyphicon-edit'></span>",
                'class'         => 'btn btn-warning',
                'onclick'       => "return confirm('Dagonderdeel wijzigen, bent u hier zeker van?');"
            );
            
            $dataVerwijder = array(
                'name'          => 'buttonVerwijder',
                'value'         => $teller,
                'type'          => 'submit',
                'content'       => "<span class='glyphicon glyphicon-trash'></span>",
                'class'         => 'btn btn-danger',
                'onclick'       => "return confirm('Dagonderdeel verwijderen, bent u hier zeker van?');"
            );
            
            /**
             * Weergeven tabel
             */
            echo "<tr><td>" . form_input(array('type' => 'hidden', 'name' => "id[$teller]", 'value' => $dagonderdeel->id, 'class' => 'form-control')) . form_input(array('type' => 'text', 'name' => "naam[$teller]", 'value' => $dagonderdeel->naam, 'class' => 'form-control')) . "</td><td><input name=starttijd[$teller] type=time class='form-control' value=$dagonderdeel->starttijd></td><td><input name=eindtijd[$teller] type=time class='form-control' value=$dagonderdeel->eindtijd></td><td>$checkboxen</td><td>$dropdownLocaties</td><td>" . form_button($dataWijzig) . form_button($dataVerwijder) . "</td></tr>";  
            
            $teller++;
        }
        ?>
        <tr>
            <td colspan="6"><?php echo form_button($dataNieuw);?></td>
            <td><?php echo smallDivAnchor("Organisator/PersoneelsfeestBeheren/index", "Teruggaan", 'class="btn btn-info"');?></td>
        </tr>
    </tbody>
</table>
</div>

<p>Voor tooltips: hover over de titels van de tabel.</p>

<?php 
echo form_close();
?>

<script>
    $('.checkboxClick').on('change', function(){
        $(this).attr('value', '1');
    });
    
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
</script>