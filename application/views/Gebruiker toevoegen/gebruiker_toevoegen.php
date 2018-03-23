<?php
/**
* Formulier openen
*/

    $attributes = array('name' => 'mijnFormulier');
    echo form_open('gebruiker_toevoegen/registreer', $attributes);
?>
<table>
        <tr>
            <td><?php echo form_label('Naam:', 'naam'); ?></td>
            <td><?php echo form_input(array('name' => 'naam', 'id' => 'naam', 'size' => '20')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_label('Voornaam:', 'voornaam'); ?></td>
            <td><?php echo form_input(array('name' => 'voornaam', 'id' => 'voornaam', 'size' => '20')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_label('E-mail:', 'email'); ?></td>
            <td><?php echo form_input(array('name' => 'email', 'id' => 'email', 'size' => '20')); ?></td>
        </tr>
        <tr>
           <td><?php echo form_submit(array('name' => 'knopPersoneelslid', 'value' => 'Toevoegen als personeelslid', 'class' => 'btn btn-success')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_submit(array('name' => 'knopVrijwilliger', 'value' => 'Toevoegen als vrijwilliger', 'class' => 'btn btn-success')); ?></td>
        </tr>
</table>
 <p><?php echo smallDivAnchor('home/index', "Teruggaan", 'class="btn btn-info"');?></p>
<?php 
/**
* Formulier sluiten
*/
echo form_close(); ?>