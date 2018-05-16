<p>U staat op het punt om de e-mail te verwijderen met onderwerp "<?php echo $mail->onderwerp ?>".</p>
<p>Bent u zeker dat u deze e-mail wilt verwijderen?</p>
<?php echo smallDivAnchor("Organisator/InformatieVersturen/verwijderMail?id=$mail->id", 'Bevestigen', 'class="btn btn-success"');?>
<?php echo smallDivAnchor('Organisator/InformatieVersturen/index', 'Annuleren', 'class="btn btn-info"'); ?>