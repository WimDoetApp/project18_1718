<?php
$id = 0;

//$soortOpties= "";
//foreach($soorten as $soort){
//    $soortOpties[$soort->id] = $soort->naam;
//}

$attributes = array('name' => 'mijnFormulier');
    echo form_open("Organisator/InformatieVersturen/wijzigMail?id=$mail->id", $attributes);
?>
<div class="table-responsive">
    <table class="table table-striped">
<!--        <tr>
            <td><?php echo form_label('aan:', 'email'); ?></td>
            <td><?php echo form_dropdown('filteren', $soortOpties, $id++, 'class="form-control"');?></td>
        </tr> -->
        <tr>
            <td><?php echo form_label('Onderwerp:', 'onderwerp'); ?></td>
            <td><?php echo form_input(array('name' => 'onderwerp', 'id' => 'onderwerp', 'size' => '45px', 'value' => $mail->onderwerp,'class' => 'form-control')); ?> </td>
        </tr>
        <tr>
            <td><?php echo form_label('Mail:', 'mail'); ?></td>
            <td ><?php echo form_textarea(array('name' => 'mail', 'id' => 'mail', 'size' => '45px', 'value' => $mail->sjabloon, 'class' => 'form-control')) ?></td>
        </tr>
        <tr>
            <td><?php echo form_submit('Opslaan', 'Opslaan', 'class="btn btn-success"'); ?></td>
            <td><?php echo smallDivAnchor('Organisator/InformatieVersturen/index', 'Annuleren', 'class="btn btn-info"'); ?></td>
        </tr>
        <tr>
            <td ><?php echo smallDivAnchor('', 'Verzenden', 'class="btn btn-info"'); ?></td>
        </tr>
    </table>
</div>
<?php echo form_close(); ?>