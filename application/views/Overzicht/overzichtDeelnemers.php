<p id="personeelsfeestId" data-id="<?php echo $personeelsfeest?>"></p>
<label><input type="checkbox" id="checkBoxIngeschreven" value="">Ingeschreven</label>
<label><input type="checkbox" id="checkBoxPersoneelsleden" value="">Personeelsleden</label>
<label><input type="checkbox" id="checkBoxOrganisators" value="">Organisators</label>
<label><input type="checkbox" id="checkBoxVrijwilligers" value="">Vrijwilligers</label>
<?php 
/**
 * @file overzichtDeelnemers.php
 * @author Wim Naudts
 * 
 * View met overzicht van alle gebruikers en mogelijkheid om te filteren op soort en zoeken op naam.
 */
/**
 * Zoeken op naam
 */
echo "<p><span class='glyphicon glyphicon-search'></span>";
echo form_input(array('type' => 'text', 'id' => 'zoekInput', 'placeholder' => "Zoek op naam..", 'class' => 'form-control')) . "</p>";
?>

<div class="table-responsive">
<table class="table table-striped" id="tabel">
    <thead>
        <tr>
            <th>Naam</th>
            <th></th>
        </tr>
    </thead>
    
    <tbody id="tabelBody">
    </tbody>
</table>
</div>

<?php echo smallDivAnchor("Organisator/Overzicht/index/$personeelsfeest", "Terug", 'class="btn btn-info"');?>

<script>    
    $(document).ready(function(){
        /**
         * Alle deelnemers ophalen
         */
        $('#personeelfeestId').hide();
        var personeelsfeestId = $('#personeelsfeestId').attr('data-id');
        var isChecked = false;
        var ingeschreven = false;
        var personeelsleden = false;
        var vrijwilligers = false;
        var organisators = false;
        haalDeelnemersOp(personeelsfeestId);
        
        /**
         * Filteren
         */
        var filter = "";
        
        $('#checkBoxIngeschreven').change(function(){
            filter = "ingeschreven";
            if(this.checked){
                isChecked = true;
                ingeschreven = true;
            }else{
                isChecked = false;
                ingeschreven = false;;
            }
            
            filteren(); 
            noCheck();
        });
        
        $('#checkBoxPersoneelsleden').change(function(){
            filter = "personeelsleden";
            if(this.checked){
                isChecked = true;
                personeelsleden = true;
            }else{
                isChecked = false;
                personeelsleden = false;
            }
            
            filteren(); 
            noCheck();
        });
        
        $('#checkBoxOrganisators').change(function(){
            filter = "organisators";
            if(this.checked){
                isChecked = true;
                organisators = true;
            }else{
                isChecked = false;
                organisators = false;
            }
            
            filteren();
            noCheck();
        });
        
        $('#checkBoxVrijwilligers').change(function(){
            filter = "vrijwilligers";
            if(this.checked){
                isChecked = true;
                vrijwilligers = true;
            }else{
                isChecked = false;
                vrijwilligers = false;
            }
            
            filteren(); 
            noCheck();
        });
        
        function filteren(){     
            switch(filter){
                case "ingeschreven":
                    $('.rij').each(function(){
                        if($(this).attr('data-isIngeschreven') === "1" && isChecked === true){
                            $(this).addClass('ingeschreven');
                            $(this).show();
                        }else{
                            $(this).removeClass('ingeschreven');
                            $(this).hide();
                        }
                    });
                    break;
                case "personeelsleden":
                    $('.rij').each(function(){
                        if($(this).attr('data-soort') === "personeelslid" && isChecked === true){
                            $(this).addClass('personeelslid');
                            $(this).show();
                        }else{
                            $(this).removeClass('personeelslid');
                        }
                    });
                    break;
                case "organisators":
                    $('.rij').each(function(){
                        if(($(this).attr('data-soort') === "organisator" || $(this).attr('data-soort') === "hoofdorganisator") && isChecked === true){
                            $(this).addClass('organisator');
                            $(this).show();
                        }else{
                            $(this).removeClass('organisator');
                        }
                    });
                    break;
                case "vrijwilligers":
                    $('.rij').each(function(){
                        if($(this).attr('data-soort') === "vrijwilliger" && isChecked === true){
                            $(this).addClass('vrijwilliger');
                            $(this).show();
                        }else{
                            $(this).removeClass('vrijwilliger');
                        }
                    });
                    break;
            }
            
            $('.rij').each(function(){
                if(!$(this).hasClass('personeelslid') && !$(this).hasClass('ingeschreven') && !$(this).hasClass('organisator') && !$(this).hasClass('vrijwilliger')){
                    $(this).hide();
                }
                                
                if(ingeschreven){
                    if(!$(this).hasClass('ingeschreven')){
                        $(this).hide();
                    }
                    
                    if(organisators){
                        if(!$(this).hasClass('organisator')){
                            $(this).hide();
                        }
                    }
                    if(personeelsleden){
                        if(!$(this).hasClass('personeelslid')){
                            $(this).hide();
                        }
                    }
                    if(vrijwilligers){
                        if(!$(this).hasClass('vrijwilliger')){
                            $(this).hide();
                        }
                    }
                }
            });
        }
        
        function noCheck(){
            var eentjeChecked = false;
            
            $(':checkbox').each(function(){
                if(this.checked){
                    eentjeChecked = true;
                }
            });
            
            if(!eentjeChecked){
                $('.rij').each(function(){
                    $(this).show(); 
                });
            }
        }
        
        /**
         * Functie om alle deelnemers op te halen
         */
        function haalDeelnemersOp(id){
            $.ajax({
                type: "GET",
                url: site_url + "/Organisator/DeelnemersBekijken/haalDeelnemersOp",
                data: {personeelsfeestId: id},
                success: function(result){
                    try{
                        var deelnemers = jQuery.parseJSON(result);
                        console.log(deelnemers);
                        
                        $.each(deelnemers, function(index){
                            $('#tabelBody').append('<tr class=rij data-isIngeschreven="' + deelnemers[index].isIngeschreven + '" data-soort="' + deelnemers[index].soort.naam + '"><td><span class=naam>' + deelnemers[index].voornaam +  ' ' + deelnemers[index].naam + '</span><h6><i>' + deelnemers[index].soort.naam + '</h6></i></td>' +
                                    '<td><a href="' + site_url + "/Organisator/DeelnemersBekijken/detail/" + deelnemers[index].id + '/' + personeelsfeestId + '" class="btn btn-success">Details</a></td></tr>');
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
        
        /**
        * Functie om op naam te zoeken
        */
        $('#zoekInput').keyup(function(){
            /**
            * Variabelen
            */
            var filter = $(this).val().toUpperCase();
        
            /**
            * Loopen door alle rijen
            */
            $('.rij').each(function(){
                var rij = $(this);
                var naam = $(this).find('.naam');
            
                if (naam.text().toUpperCase().indexOf(filter) > -1) {
                    rij.show();
                }
                else{
                    rij.hide();
                }
            });
            
            $('#checkBoxPersoneelsleden').prop('checked', false);
            $('#checkBoxIngeschreven').prop('checked', false);
            $('#checkBoxOrganisators').prop('checked', false);
            $('#checkBoxVrijwilligers').prop('checked', false);
        });
    });
</script>
