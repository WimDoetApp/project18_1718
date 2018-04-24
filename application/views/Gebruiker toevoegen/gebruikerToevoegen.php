<?php
/**
* Formulier openen
*/

$attributes = array('name' => 'mijnFormulier', 'id' => 'form');
echo form_open('Personeelslid/GebruikerToevoegen/registreer', $attributes);
/**
* We geven altijd naar elke pagina door over welk personeelsfeest het gaat
 */
echo form_input(array('type' => 'hidden', 'name' => 'personeelsfeestId', 'value' => $personeelsfeest));
?>
<div class="table-responsive">
<table class="table table-striped">
        <tr>
            <td><?php echo form_label('Naam:', 'naam'); ?></td>
            <td><?php echo form_input(array('name' => 'naam', 'id' => 'naam', 'size' => '20', 'required' => 'required', 'class' => 'form-control')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_label('Voornaam:', 'voornaam'); ?></td>
            <td><?php echo form_input(array('name' => 'voornaam', 'id' => 'voornaam', 'size' => '20', 'required' => 'required', 'class' => 'form-control')); ?></td>
        </tr>
        <tr>
            <td><?php echo form_label('E-mail:', 'email'); ?></td>
            <td><?php echo form_input(array('name' => 'email', 'id' => 'email', 'size' => '20', 'required' => 'required', 'class' => 'form-control')); ?></td>
        </tr>
        <?php if($soortId > 2){ ?>
        <tr>
           <td><?php echo form_submit(array('name' => 'knopPersoneelslid', 'value' => 'Toevoegen als personeelslid', 'class' => 'btn btn-success form-control')); ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td><?php echo form_submit(array('name' => 'knopVrijwilliger', 'value' => 'Toevoegen als vrijwilliger', 'class' => 'btn btn-success form-control')); ?></td>
        </tr>
</table>
</div>
 <p><?php echo smallDivAnchor('Organisator/PersoneelsfeestBeheren/index', "Teruggaan", 'class="btn btn-info"');?></p>
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
<?php } ?>
<script>
    $(document).ready(function(){
        $('form').on("submit", function(e){
            var email = $('#email').val();
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                
            if(!regex.test(email)){
                alert("Vul een correcte email in!");
                e.preventDefault();
            }
        });
    });
</script>