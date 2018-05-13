<h3>Welkom <?php echo $gebruiker->voornaam ?>,</h3>
<p>Op de website voor het personeelsfeest van <?php echo $personeelsfeestHuidig->datum ?>.</p>
<p>Op deze website kan je jezelf inschrijven of hulp aanbieden voor het personeelsfeest. Je hebt hiervoor tot deze deadline: <?php echo $personeelsfeestHuidig->inschrijfDeadline ?>.</p>
<p>Je kan ook de emailadressen van de vrijwilligers en organisators raadplegen en foto's bekijken. Voor vragen kan je via de contactpagina een mail naar de juiste persoon sturen. Als je vanboven op de naam van je account klikt zie je een overzicht van jouw gegevens.</p>

<?php
if($gebruiker->soortId > 2){
?>
    <div class='panel panel-default'>
        <div class="panel-heading">
            <h3>Beheer hier het personeelsfeest</h3>
        </div>
        
        <div class="panel-body">   
            <?php echo smallDivAnchor("Organisator/PersoneelsfeestBeheren/index/$personeelsfeest", "Personeelsfeest beheren", 'class="btn btn-default"'); ?>
        </div>
    </div>
<?php } else { ?>
     <div class='panel panel-default'>
        <div class="panel-heading">
            <h3>Schrijf je hier in</h3>
        </div>
        
        <div class="panel-body">   
            <?php echo smallDivAnchor("Vrijwilliger/Inschrijven/index/$personeelsfeest", "Inschrijven", 'class="btn btn-default"'); ?>
        </div>
    </div>   
<?php } 

