<?php
/**
* Formulier openen
*/

$attributes = array('name' => 'mijnFormulier');
echo form_open('Personeelslid/GebruikerToevoegen/registreer', $attributes);
/**
* We geven altijd naar elke pagina door over welk personeelsfeest het gaat
 */
echo form_input(array('type' => 'hidden', 'name' => 'personeelsfeestId', 'value' => $personeelsfeest));
?>
<div class="table-responsive">
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
        <?php if($soortId > 2){ ?>
        <tr>
           <td><?php echo form_submit(array('name' => 'knopPersoneelslid', 'value' => 'Toevoegen als personeelslid', 'class' => 'btn btn-success')); ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td><?php echo form_submit(array('name' => 'knopVrijwilliger', 'value' => 'Toevoegen als vrijwilliger', 'class' => 'btn btn-success')); ?></td>
        </tr>
</table>
</div>
 <p><?php echo smallDivAnchor('home/toonStartScherm', "Teruggaan", 'class="btn btn-info"');?></p>
<?php 
/**
* Formulier sluiten
*/
echo form_close(); 

if($error){?>
    <script>
        $(document).ready(function(){
            alert("<?php echo $errorMessage; ?>");
        });
    </script> 
<?php } 