<?php
    /**
     * @author Jari Mathé
     */
$teller = 0;

$filterOpties= "";
foreach($jaartallen as $jaartal){
    $filterOpties[$jaartal->id] = $jaartal->datum;
}

$attributes = array('name' => 'mijnFormulier');
    echo form_open('Activiteiten_beheren/registreer', $attributes);
?>
<div class="table-responsive">
<table class="table">
     <tr>
            <td><?php echo form_label('Filteren:', 'filteren'); echo form_dropdown('filteren', $filterOpties, '0'); ?></td>
            <td><?php echo smallDivAnchor('FotosBeheren/index', 'Foto Uploaden', 'class="btn btn-info"'); ?> </td>
    </tr>
    <tr>
        
    <?php 
    foreach ($fotos as $foto){ 
       if($foto->personeelsfeestId == $filterOpties){
        $teller++ ?>
        
            <td><?php echo toonAfbeelding($foto->foto, "width='350px'") ?></td>
        
        <?php
        if ($teller >= 3){
            echo "</tr><tr>";
            
            $teller = 0;
        }
        ?>
    <?php }} ?>
    <tr>
            <td><?php echo smallDivAnchor('home/index', 'Terug gaan', 'class="btn btn-info"')?></td>
    </tr>    
<table>
</div>
    <?php echo form_close(); ?>