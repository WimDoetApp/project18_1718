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
foreach($dagonderdelen as $dagonderdeel){ ?>

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
        foreach($dagonderdeel->opties as $dagonderdeel){
            
        $checkbox = "<td><input type=radio class=radioButton name=optie$dagonderdeel->id value=$optie->id />";
        ?>
        
        <tr>
            <td><?php echo $optie->naam ?></td>
            <?php
            echo "<td>" . form_input(array('type' => 'text', 'name' => "commentaar$optie->id", 'value' => '')) . "</td>";
            echo $checkbox . " Inschrijven</td>";
            ?>
        </tr>  
        
        <?php } ?>
        <tr>
            <td></td>
            <td></td>
            <?php echo "<td><input type=radio class=radioButton name=optie$dagonderdeel->id value=0 /> Geen</td>"?>
        </tr>
    </tbody>
</table>
</div>

<?php } ?>
<script>
    $( document ).ready(function() {
    });
</script> 