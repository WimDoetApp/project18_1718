<?php 
/**
 * @author Wim Naudts
 */
/**
 * Zoeken op naam
 */
echo "<p><span class='glyphicon glyphicon-search'></span>";
echo form_input(array('type' => 'text', 'id' => 'zoekInput', 'placeholder' => "Zoek op naam..", 'class' => 'form-control')) . "</p>";
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
        foreach($deelnemers as $deelnemer){
            /**
             * Weergeven tabel
             */
            echo "<tr class=rij><td><span class=naam>$deelnemer->voornaam $deelnemer->naam</span></td>"; 
            echo "<td>" . smallDivAnchor("Organisator/DeelnemersBekijken/detail/$deelnemer->id/$personeelsfeest", "Details", 'class="btn btn-success"') . "</td></tr>";
        }
        ?>
        <tr>
            <td><?php echo smallDivAnchor("Organisator/PersoneelsfeestBeheren/index", "Teruggaan", 'class="btn btn-info"');?></td>
        </tr>
    </tbody>
</table>
</div>

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
