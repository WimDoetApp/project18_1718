<?php 
/**
 * formulier openen
 */
$attributes = array('name' => 'mijnFormulier');
echo form_open('dagonderdeelbeheren/wijzig', $attributes);
/**
 * We geven altijd naar elke pagina door over welk personeelsfeest het gaat
 */
echo form_input(array('type' => 'hidden', 'name' => 'personeelsfeestId', 'value' => $personeelsfeest));
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Naam</th>
            <th>Beginuur</th>
            <th>Einduur</th>
            <th>Dagonderdeel heeft taken</th>
            <th>Vrijwilligers mogen deelnemen</th>
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
            $dropdownLocaties = "<select name=locatie[$teller]>";
            
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
                'content'       => 'Wijzig',
                'class'         => 'btn btn-default',
                'onclick'       => "return confirm('Dagonderdeel wijzigen, bent u hier zeker van?');"
            );
            
            $dataVerwijder = array(
                'name'          => 'buttonVerwijder',
                'value'         => $teller,
                'type'          => 'submit',
                'content'       => "<span class='glyphicon glyphicon-remove'></span>",
                'class'         => 'btn btn-default',
                'onclick'       => "return confirm('Dagonderdeel verwijderen, bent u hier zeker van?');"
            );
            
            /**
             * Weergeven tabel
             */
            echo "<tr><td>" . form_input(array('type' => 'hidden', 'name' => "id[$teller]", 'value' => $dagonderdeel->id)) . form_input(array('type' => 'text', 'name' => "naam[$teller]", 'value' => $dagonderdeel->naam)) . "</td><td><input name=starttijd[$teller] type=time value=$dagonderdeel->starttijd></td><td><input name=eindtijd[$teller] type=time value=$dagonderdeel->eindtijd></td><td>$checkboxen</td><td>$dropdownLocaties</td><td>" . form_button($dataWijzig) . form_button($dataVerwijder) . "</td></tr>";  
            
            $teller++;
        }
        ?>
    </tbody>
</table>

<?php 
/**
 * Knop om nieuw dagonderdeel aan te maken
 */
$dataNieuw = array(
    'name'          => 'buttonNieuw',
    'value'         => 'nieuw',
    'type'          => 'submit',
    'content'       => 'Nieuw dagonderdeel aanmaken',
    'class'         => 'btn btn-default'
);

echo form_button($dataNieuw);

echo smallDivAnchor("", "Teruggaan", 'class="btn btn-default"');

echo form_close();
?>

<script>
    $('.checkboxClick').on('change', function(){
        $(this).attr('value', '1');
    });
</script>