<?php
$id = 0;

$soortOpties= "";
foreach($soorten as $soort){
    $soortOpties[$soort->id] = $soort->naam;
}

$attributes = array('name' => 'mijnFormulier');
    echo form_open('Organisator/InformatieVersturen/registreerMail', $attributes);
?>
<div class="table-responsive">
    <table class="table table-striped">
        <tr>
            <td><?php echo form_label('aan:', 'email'); ?></td>
            <td><?php echo form_dropdown('filteren', $soortOpties, $id++, 'class="form-control"');?></td>
        </tr>
        <tr>
            <td><?php echo form_label('Onderwerp:', 'onderwerp'); ?></td>
            <td><?php echo form_input(array('name' => 'onderwerp', 'id' => 'onderwerp', 'size' => '45px', 'class' => 'form-control')); ?> </td>
        </tr>
        <tr>
            <td><?php echo form_label('Mail:', 'mail'); ?></td>
            <td rowspan='2'><?php echo form_textarea(array('name' => 'mail', 'id' => 'mail', 'size' => '45px', 'class' => 'form-control')) ?></td>
        </tr>
        <tr>
            <td>
                <?php echo form_label('Legende:', 'Legende'); ?>
                <table border="1">
                    <tr>
                        <th>Commando</th>
                        <th>Uitleg</th>
                    </tr>
                    <tr>
                        <td> &lt;datumFeest&gt; </td>
                        <td>Datum van het feest</td>
                    </tr>
                    <tr>
                        <td>&lt;deadline&gt;</td>
                        <td>Datum van de deadline</td>
                    </tr>
                    <tr>
                        <td>&lt;naam&gt;</td>
                        <td>Naam van de gebruiker</td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td><?php echo form_submit('Verzenden', 'Verzenden', 'class="btn btn-success"'); ?></td>
            <td><?php echo smallDivAnchor('Organisator/InformatieVersturen/index', 'Annuleren', 'class="btn btn-info"'); ?></td>
        </tr>
    </table>
</div>
<?php echo form_close(); ?>

