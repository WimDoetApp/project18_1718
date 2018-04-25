<?php
$teller = 0;
?>

<tr>
    <?php 
    
    foreach ($fotos as $foto){ 
       
        $teller++ ?>
        
    <td><?php echo form_hidden('idFoto', $foto->id); echo toonAfbeelding($foto->foto, "width='350px'"); echo smallDivAnchor('Organisator/FotosBeheren/delete_image', "Verwijder", 'class="btn btn-danger"'); ?> </td>
        
        <?php
        if ($teller >= 3){
            echo "</tr><tr>";
            
            $teller = 0;
        }
        ?>
    <?php } ?>      
</tr>