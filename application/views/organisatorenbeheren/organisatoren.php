<h2>Overzicht personeelsleden</h2>
<?php 
/**
 * Zoeken op naam
 */
echo "<p><span class='glyphicon glyphicon-search'></span>";
echo form_input(array('type' => 'text', 'id' => 'zoekInput', 'placeholder' => "Zoek op naam..")) . "</p>";
/**
 * formulier openen
 */
$attributes = array('name' => 'mijnFormulier');
echo form_open('organisatorenbeheren/wijzig', $attributes);
/**
 * We geven altijd naar elke pagina door over welk personeelsfeest het gaat
 */
echo form_input(array('type' => 'hidden', 'name' => 'personeelsfeestId', 'value' => $personeelsfeest));
?>

<table class="table table-bordered" id="tabel">
    <thead>
        <tr>
            <th>Naam</th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>
        <?php
        foreach($personeelsleden as $personeelslid){
            /**
             * Opbouwen checkbox voor organisator
             */
            if ($personeelslid->soortId == 3) {
                $checkbox = "<input type=checkbox class=checkboxClick name=organisator[$personeelslid->id] value=1 checked/>";
            }else{
                $checkbox = "<input type=checkbox class=checkboxClick name=organisator[$personeelslid->id] value=0 />";
            }
            
            /**
             * Weergeven tabel
             */
            echo "<tr class=rij><td>" . form_input(array('type' => 'hidden', 'name' => "ids[]", 'value' => $personeelslid->id)) . "<span class=naam>$personeelslid->voornaam $personeelslid->naam</span></td><td>$checkbox Organisator</td></tr>"; 
        }
        ?>
    </tbody>
</table>

<?php 
/**
 * Knop om op te slagen
 */
$dataOpslagen = array(
    'name'          => 'buttonOpslagen',
    'value'         => 'opslagen',
    'type'          => 'submit',
    'content'       => 'Opslagen',
    'class'         => 'btn btn-default'
);

echo form_button($dataOpslagen);

echo smallDivAnchor("", "Teruggaan", 'class="btn btn-default"');

echo form_close();
?>

<script>
    /**
     * Als een checkbox aangeklikt wordt, krijgt deze een value van 1
     */
    $('.checkboxClick').on('click', function(){
        $(this).attr('value', '1');
    });
    
    /**
     * Functie om op naam te zoeken
     */
    $('#zoekInput').keyup(function(){
        /**
         * Variabelen
         */
        var filter = $(this).val().toUpperCase();
        
        /**
         * Loopen door alle rijen
         */
        $('.rij').each(function(){
            var rij = $(this);
            var naam = $(this).find('.naam');
            
            if (naam.text().toUpperCase().indexOf(filter) > -1) {
                rij.show();
            }
            else{
                rij.hide();
            }
        });
    });
</script>