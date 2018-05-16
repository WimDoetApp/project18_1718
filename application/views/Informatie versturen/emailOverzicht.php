<div class="table-responsive">
<table class="table table-striped">
    <tr>
        <th>Ontvanger(s)</th>
        <th>Onderwerp</th>
        <th>Bewerken</th>
    </tr>
     <?php foreach ($mails as $mail){ ?>
    <tr>
        <td><?php echo $mail->soortId ?></td>
        <td><?php echo $mail->onderwerp ?></td>
        <td><?php echo smallDivAnchor("Organisator/InformatieVersturen/wijzigPagina?id=$mail->id", 'Wijzig', 'class="btn btn-info"'); echo smallDivAnchor("Organisator/InformatieVersturen/verwijderenPagina?id=$mail->id", 'Verwijder', 'class="btn btn-danger"'); ?></td>
    </tr>
    <?php } ?>
</table>
<table class="table table-striped">
    <tr>
        <td><?php echo smallDivAnchor('Organisator/InformatieVersturen/emailOpstellenPagina', 'Nieuw', 'class="btn btn-success"');?></td>
        <td><?php echo smallDivAnchor('home/index', 'Terug', 'class="btn btn-info"'); ?></td>
    </tr>
</table>
</div>