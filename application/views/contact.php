<?php
/**
 * @author Wim Naudts
 */
?>
<p>Bij vragen kan u onderstaand contactformulier invullen.</p>
<?php
/**
 * formulier openen
 */
$attributes = array('name' => 'mijnFormulier');
echo form_open('Contact/stuurVraag', $attributes);
?>
<div class="form-group">

<div class="panel panel-default">
    <div class="panel-heading"><h4>Email</h4></div>
    <div class="panel-body">
        <?php echo form_input(array('type' => 'text', 'name' => "email", 'id' => 'email', 'required' => 'required', 'class' => 'form-control')); ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><h4>Onderwerp</h4></div>
    <div class="panel-body">
        <?php echo form_input(array('type' => 'text', 'name' => "onderwerp", 'required' => 'required', 'class' => 'form-control')); ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><h4>Vraag</h4></div>
    <div class="panel-body">
        <?php echo form_textarea(array('name' => "vraag", 'required' => 'required', 'cols' => '100', 'class' => 'form-control')); ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><h4>Sturen naar</h4></div>
    <div class="panel-body">
        <?php 
        $options = array(
        'organisator'         => 'organisator',
        'ontwikkelaar'           => 'ontwikkelaar',
        );
        
        echo form_dropdown(array('name' => 'ontvanger', 'options' => $options, 'class' => 'form-control')); 
        ?>
    </div>
</div>
    
<?php echo form_submit(array('name' => 'knopSubmit', 'value' => 'Vesturen', 'class' => 'btn btn-success')); ?>
    
</div>

<?php 
echo form_close();
?>

<script>
    $('form').on("submit", function(e){
        var email = $('#email').val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                
        if(!regex.test(email)){
            alert("Vul een correcte email in!");
            e.preventDefault();
        }
    });
</script>