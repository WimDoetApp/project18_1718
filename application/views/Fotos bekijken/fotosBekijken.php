<script>
    $(document).ready(function(){
        // eerste keer laden
        loadData();
    
        // laad bij change
        $("[name='filteren']").change(function(){
            loadData();
        });
        
        function loadData() {
            $.ajax({type : "GET",
            url : site_url + "/Vrijwilliger/FotosBekijken/loadFotosAjax",
            data : {personeelsfeestId : $("[name='filteren']").val()},
            success : function(result){
                $("#resultaatTable tbody").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
        }
    });
</script>

<?php
    /**
     * @file fotosBekijken.php
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
    echo form_open('Organisator/FotosBeheren/do_upload', $attributes);
?>

<div class="table-responsive">
<table class="table">
     <tr>
            <td ><?php echo form_label('Filteren:', 'filteren'); echo form_dropdown('filteren', $filterOpties, $id++, 'class="form-control"');?></td>
    </tr>
</table>
<table class="table" id="resultaatTable">
    <tbody>
        
    </tbody>
</table>
<table class="table">
    <tr>
            <td><?php echo smallDivAnchor('home/index', 'Terug', 'class="btn btn-info"')?></td>
    </tr>    
<table>
</div>
    <?php echo form_close(); ?>