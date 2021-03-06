<h2>Overzicht personeelsleden</h2>
<?php 
/**
 * @file organisatoren.php
 * @author Wim Naudts
 * 
 * View waar je personeelsleden in organisatoren kunt veranderen om omgekeerd
 */
/**
 * Zoeken op naam
 */
echo "<p><span class='glyphicon glyphicon-search'></span>";
echo form_input(array('type' => 'text', 'id' => 'zoekInput', 'placeholder' => "Zoek op naam..", 'class' => 'form-control')) . "</p>";
/**
 * Knop om op te slagen
 */
$dataOpslagen = array(
    'name'          => 'buttonOpslagen',
    'value'         => 'opslagen',
    'type'          => 'submit',
    'content'       => 'Opslagen',
    'class'         => 'btn btn-success'
);
/**
 * formulier openen
 */
$attributes = array('name' => 'mijnFormulier');
echo form_open('HoofdOrganisator/OrganisatorenBeheren/wijzig', $attributes);
/**
 * We geven altijd naar elke pagina door over welk personeelsfeest het gaat
 */
echo form_input(array('type' => 'hidden', 'name' => 'personeelsfeestId', 'value' => $personeelsfeest));
?>

<div class="table-responsive">
<table class="table table-striped" id="tabel">
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
        <tr>
            <td><?php echo form_button($dataOpslagen);?></td>
            <td><?php echo smallDivAnchor("Organisator/PersoneelsfeestBeheren/index", "Terug", 'class="btn btn-info"');?></td>
        </tr>
    </tbody>
</table>
</div>

<?php 
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