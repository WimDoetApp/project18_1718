
<?php
/** 
 * @author Jari Mathé, Wim Naudts
 */

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
    echo form_open('Organisator/ActiviteitenBeheren/input', $attributes);
    echo form_input(array('type' => 'hidden', 'name' => 'optieId', 'value' => $id));
?>
<div class="table-responsive">
<table class="table table-striped">
    <tr>
        <td><?php echo form_label('Naam van de activiteit:', 'naam'); ?></td>
        <td><?php echo form_input(array('name' => 'naam', 'id' => 'naam', 'size' => '50', 'value' => $naam, 'class' => 'form-control')); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label('Beschrijving:', 'beschrijving'); ?></td>
        <td><?php echo form_input(array('name' => 'beschrijving', 'id' => 'beschrijving', 'size' => '50', 'value' => $beschrijving, 'class' => 'form-control')); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label('Minimum aantal deelnemers:', 'minimumAantalPlaatsen'); ?></td>
        <td><?php echo form_input(array('type' => 'number', 'name' => 'minimumAantalPlaatsen', 'id' => 'minimumAantalPlaatsen', 'size' => '2', 'value' => $minimum, 'class' => 'form-control')); ?></td>
        <td><?php echo form_label('Maximum aantal deelnemers:', 'maximumAantalPlaatsen'); ?></td>
        <td><?php echo form_input(array('type' => 'number', 'name' => 'maximumAantalPlaatsen', 'id' => 'maximumAantalPlaatsen', 'size' => '2', 'value' => $maximum, 'class' => 'form-control')); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label('Locatie:', 'locatie'); ?></td>
        <td><?php echo form_dropdown('locatie', $locatieOpties, $locatieId, 'class="form-control"'); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label('Dagonderdeel:', 'dagonderdeel'); ?></td>
        <td><?php echo form_dropdown('dagonderdeel', $dagonderdeelOpties, $dagonderdeelId, 'class="form-control"'); ?></td>
    </tr>
    <tr>
        <td><?php echo form_submit(array('name' => $button, 'value' => $button, 'class' => 'btn btn-success')); ?></td>
        <td><?php echo smallDivAnchor("Organisator/overzicht/index/$personeelsfeest", "Annuleren", 'class="btn btn-info"');?></td>
    </tr>
</table>
</div>
<?php 
/**
* Formulier sluiten
*/
echo form_close(); ?>