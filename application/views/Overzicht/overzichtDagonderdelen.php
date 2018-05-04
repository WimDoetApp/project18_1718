<?php
/**
 * @author Wim Naudts
 */
echo "<p>" . smallDivAnchor("Organisator/DeelnemersBekijken/index/$personeelsfeest", "Overzicht gebruikers", 'class="btn btn-info"') . "</p>";
foreach($dagonderdelen as $dagonderdeel){?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?php
            echo "<h2>$dagonderdeel->naam</h2><h3>$dagonderdeel->starttijd - $dagonderdeel->eindtijd</h3>";
        ?>
    </div>
    
    <div class="panel-body">
        <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Activiteiten</th>
                    <th></th>
                    <th></th>
                    <?php if ($dagonderdeel->heeftTaak != "1"){ ?>
                    <th></th>
                    <?php } ?>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
                <?php
                foreach($dagonderdeel->opties as $optie){
                    echo "<tr><td>$optie->naam</td>";
                    echo "<td>" . smallDivAnchor("*", "Deelnemers", 'class="btn btn-info knopDeelnemers" data-toggle="modal" data-target="#modalOverview" data-id="' . $optie->id . '"')  . "</td>";
                    echo "<td>" . smallDivAnchor("Organisator/ActiviteitenBeheren/index/$optie->id/$dagonderdeel->id", "Activiteit aanpassen", 'class="btn btn-warning"') . "</td>";
                    
                    if($dagonderdeel->heeftTaak != "1"){
                        echo "<td>" . smallDivAnchor("Organisator/Taak/index/$optie->id/0", "Taken aanpassen", 'class="btn btn-warning"') . "</td>";
                    }
                    
                    $confirm = "return confirm('Activiteit verwijderen, bent u hier zeker van?');";
                    
                    echo "<td>" . smallDivAnchor("Organisator/ActiviteitenBeheren/verwijderActiviteit/$optie->id", "Activiteit verwijderen", 'class="btn btn-danger" onclick="' . $confirm . '"') . "</td>";
                    
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        </div>
        
        <?php 
        echo "<p>" . smallDivAnchor("Organisator/ActiviteitenBeheren/index/0/$dagonderdeel->id", "Activiteit toevoegen", 'class="btn btn-success"') . "</p>"; 
        
        if($dagonderdeel->heeftTaak == "1"){
            echo "<p>" . smallDivAnchor("Organisator/Taak/index/$dagonderdeel->id/1", "Taken aanpassen", 'class="btn btn-warning"') . "</p>";
        }
        ?>
    </div>
</div>

<?php 
 }
 echo smallDivAnchor("Organisator/PersoneelsfeestBeheren/index", "Teruggaan", 'class="btn btn-info"');
 ?>
<div class="modal fade" id="modalOverview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLongTitle"></h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        /**
         * Deelnemers weergeven
         */
        $('.knopDeelnemers').click(function(){
            var id = $(this).attr('data-id');
            haalDeelnemerOp(id);
        });
        
        function haalDeelnemerOp(id){
            $.ajax({
                type: "GET",
                url: site_url + "/Organisator/Overzicht/haalDeelnemersOpJson",
                data: {optieId: id},
                success: function(result){
                    try{
                        var inschrijfOpties = jQuery.parseJSON(result);
                        
                        $('.modal-body').html('');
                        $('.modal-title').text('Deelnemers');
                        
                        $.each(inschrijfOpties, function(index){
                            $('.modal-body').append('<h4>' + inschrijfOpties[index].deelnemer.voornaam +  ' ' + inschrijfOpties[index].deelnemer.naam + '</h4>');
                            
                            var commentaar = inschrijfOpties[index].commentaar;
                            
                            if(commentaar !== ""){
                                $('.modal-body').append('<p>Commentaar: <i>' + inschrijfOpties[index].commentaar + '</i></p>');
                            }
                        });
                    } catch(error){
                        alert('JSON error: ' + result);
                    }
                },
                error: function(xhr, status, error){
                    alert('Ajax error: ' + xhr.responseText);
                }
            });
        }
    });
</script>