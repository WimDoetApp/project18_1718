<?php
    /**
     * @author Jari Mathé
     */
$teller = 0;
$id = 0;
$error = '';

$filterOpties= "";
foreach($jaartallen as $jaartal){
    $filterOpties[$jaartal->id] = $jaartal->datum;
}

$attributes = array('name' => 'mijnFormulier');
    echo form_open('FotosBeheren/do_upload', $attributes);
?>

<div class="table-responsive">
<table class="table">
     <tr>
            <td ><?php echo form_label('Filteren:', 'filteren'); echo form_dropdown('filteren', $filterOpties, '0', $id++); ?></td>
            <td><input type="file" name="userfile" size="20" /> <input type="submit" value="upload" /></td>
            <td><?php echo $error;?></td>   
    </tr>
    <tr>
    <?php 
    foreach ($fotos as $foto){ 
       if($foto->personeelsfeestId == $id){
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