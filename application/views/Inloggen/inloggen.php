<?php 
/**
 * @author Wim Naudts
 */
$dataInloggen = array(
    'name'          => 'buttonInloggen',
    'type'          => 'submit',
    'content'       => 'Inloggen',
    'class'         => 'btn btn-lg btn-primary btn-block',
);

$attributes = array('name' => 'mijnFormulier', 'class' => 'form-signin');
?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Inloggen</h1>
            <div class="account-wall">
                <?php 
                echo form_open('home/toonStartScherm', $attributes);
                echo form_input(array('type' => 'text', 'name' => "email", 'placeholder' => 'email', 'class' => 'form-control', 'required' => 'required', 'autofocus' => 'autofocus'));
                echo form_input(array('type' => 'password', 'name' => 'wachtwoord', 'placeholder' => 'wachtwoord', 'class' => 'form-control', 'required' => 'required'));
                echo form_button($dataInloggen);
                ?>
                <a href="<?php echo base_url("index.php/Home/hulp"); ?>" class="pull-right need-help">Hulp nodig? </a><span class="clearfix"></span>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>