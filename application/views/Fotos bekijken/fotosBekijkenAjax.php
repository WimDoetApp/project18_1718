<?php
/**
* @author Jari Mathé
*/

$teller = 0;
?>

<tr>
    <?php 
    
    foreach ($fotos as $foto){ 
       
        $teller++ ?>
        
    <td><?php echo toonAfbeelding($foto->foto, "width='350px'");?> </td>
        
        <?php
        if ($teller >= 3){
            echo "</tr><tr>";
            
            $teller = 0;
        }
        ?>
    <?php } ?>      
</tr>