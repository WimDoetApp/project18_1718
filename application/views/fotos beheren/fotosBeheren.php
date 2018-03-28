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
<table >
     <tr>
            <td><?php echo form_label('Filteren:', 'filteren'); ?></td>
            <td><?php echo form_dropdown('filteren', $filterOpties, '0'); ?></td>
    </tr>
    <tr>
    <?php foreach ($fotos as $foto){ 
        $teller++ ?>
        
            <td><?php echo toonAfbeelding($foto->foto, "width='350px'") ?></td>
        
        <?php
        if ($teller >= 3){
            echo "</tr><tr>";
            
            $teller = 0;
        }
        ?>
    <?php } ?>
    
    
<table>
    <?php echo form_close(); ?>