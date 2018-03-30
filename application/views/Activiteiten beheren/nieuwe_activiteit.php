
<?php
/**
* Data geven voor het dropdown menu van locatie
*/
$locatieOpties= "";
foreach($locaties as $locatie){
    $locatieOpties[$locatie->id] = $locatie->naam;
}

/**
* Data geven voor het dropdown menu van dagonderdeel
*/
$dagonderdeelOpties= "";
foreach($dagonderdelen as $dagonderdeel){
    $dagonderdeelOpties[$dagonderdeel->id] = $dagonderdeel->naam;
}
?>

<?php
/**
* Formulier openen
*/

    $attributes = array('name' => 'mijnFormulier');
    echo form_open('Activiteiten_beheren/registreer', $attributes);
?>
<table>
        <tr>
            <td><?php echo form_label('Naam van de activiteit:', 'naam'); ?></td>
            <td><?php echo form_input(array('name' => 'naam', 'id' => 'naam', 'size' => '50')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_label('Beschrijving:', 'beschrijving'); ?></td>
            <td><?php echo form_input(array('name' => 'beschrijving', 'id' => 'beschrijving', 'size' => '50')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_label('Minimum aantal deelnemers:', 'minimumAantalPlaatsen'); ?></td>
            <td><?php echo form_input(array('name' => 'minimumAantalPlaatsen', 'id' => 'minimumAantalPlaatsen', 'size' => '2')); ?></td>
            <td><?php echo form_label('Maximum aantal deelnemers:', 'maximumAantalPlaatsen'); ?></td>
            <td><?php echo form_input(array('name' => 'maximumAantalPlaatsen', 'id' => 'maximumAantalPlaatsen', 'size' => '2')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_label('Locatie:', 'locatie'); ?></td>
            <td><?php echo form_dropdown('locatie', $locatieOpties, '0'); ?></td>
            
        </tr>
        <tr>
            <td><?php echo form_label('Dagonderdeel:', 'dagonderdeel'); ?></td>
            <td><?php echo form_dropdown('dagonderdeel', $dagonderdeelOpties, '0'); ?></td>
        </tr>
        <tr>
            <td><?php echo form_submit(array('name' => 'knop', 'value' => 'Bevestigen', 'class' => 'btn btn-success')); ?></td>
            <td><?php echo smallDivAnchor('home/index', "Annuleren", 'class="btn btn-info"');?></td>
        </tr>
    </table>
<?php 
/**
* Formulier sluiten
*/
echo form_close(); ?>