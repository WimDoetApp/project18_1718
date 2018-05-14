<a href="" data-toggle="modal" data-target="#modalHulp">Hulp nodig?</a>
<?php
/**
 * @author Bram Van Bergen, Wim Naudts
 */
/**
 *  We geven naar elke pagina door over welk personeelsfeest het gaat
 */

$attributen = array('name' => 'mijnFormulier');
echo form_open('Organisator/PersoneelsfeestBeheren/nieuwPersoneelsfeest/' . $data->id, $attributen);
echo form_hidden("personeelsfeestId", $data->id);
?>

<div class='panel panel-default Datums'>
    <div class="panel-heading"><h3>
            Datums:
        </h3></div>
    <div class="panel-body form-group">
        <?php
        /**
         * datum
         */
        $datum = $data->datum;
        echo form_labelpro('Datum:', 'datum');
        echo '<div class="input-group date">';
        echo form_input(array('name' => 'datum',
            'id' => 'datum',
            'value' => $datum,
            'class' => 'form-control',
            'required' => 'required',
            'type' => 'date'));
        /**
         * datum deadline
         */
        $deadline = $data->inschrijfDeadline;
        echo '</div></br>';
        echo form_labelpro('Deadline inschrijvingen', 'deadline');
        echo '<div class="input-group date">';
        echo form_input(array('name' => 'deadline',
            'id' => 'deadline',
            'value' => $deadline,
            'class' => 'form-control',
            'required' => 'required',
            'type' => 'date'));
        ?>
    </div>
    <?php echo "<br />" . form_submit('knopDatum', 'Verander datum', 'class="btn btn-default"') ?>
</div>
</div>
<!-- <div class="panel panel-default Exporteren">
    <div class="panel-heading"><h3>
        Overzicht exporteren:
    </h3></div>
    <div class="panel-body form-group">
        <?php
//echo form_dropdownpro('id', $exporteren, 'Jaar', 'Jaar', '0');
?>
    </div>
</div> -->
<div class="panel panel-default Aanpassen">
    <div class="panel-heading"><h3>
            Aanpassingen maken
        </h3></div>
    <div class="panel-body form-group">
        <?php
        echo smallDivAnchor("Personeelslid/GebruikerToevoegen/index/$data->id", "Gebruikers toevoegen", 'class="btn btn-default btn-beheren"');
        echo smallDivAnchor("Organisator/DagonderdeelBeheren/toonDagonderdelen/$data->id", "Dagonderdelen beheren", 'class="btn btn-default btn-beheren"');
        echo smallDivAnchor("Organisator/Locatie/index", "Locaties beheren", 'class="btn btn-default btn-beheren"');
        echo smallDivAnchor("Organisator/Overzicht/index/$data->id", "Activiteiten en Taken beheren", 'class="btn btn-default btn-beheren"');
        if($gebruiker->soortId == 4){
            echo smallDivAnchor("Hoofdorganisator/OrganisatorenBeheren/toonPersoneelsleden/$data->id", "Organisatoren beheren", 'class="btn btn-default btn-beheren"');
        }
        ?>
    </div>
</div>
<div class="panel panel-default NieuwPersoneelsfeest">
    <div class="panel-heading"><h3>
            Nieuw personeelsfeest:
        </h3></div>
    <div class="panel-body form-group">
        <?php
        echo smallDivAnchor("#", "Nieuw personeelsfeest", 'data-toggle="modal" data-target="#myModal" class="btn btn-default"')
        ?>
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Nieuw personeelsfeest</h4>
                    </div>
                    <div class="modal-body">
                        <input type="checkbox" name="nieuwDagonderdeel"/> Dagonderdelen met de opties van
                        vorig jaar behouden</br>
                        <input type="checkbox" name="nieuwOrganisatoren"/> Organisatoren behouden</br>
                        <p class="text-danger">Wanneer je op bevestigen klikt, wordt het huidige personeelsfeest
                            afgesloten! Klik vanboven op de hulp knop voor meer informatie.</p>
                    </div>
                    <div class="modal-footer">
                        <?php echo form_submit('knop', 'Bevestig', 'class="btn btn-default"') ?>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo form_close();
?>
<div class="panel panel-default Importeren">
    <div class="panel-heading"><h3>
            Importeren e-mailadressen:
        </h3></div>
    <div class="panel-body form-group">
        <form action="PersoneelsfeestBeheren/importeer" method="post" enctype="multipart/form-data">
            <input type="checkbox" name="formImporteren[]" value="Importeer als personeelsleden"/>Personeelsleden</br>
            <input type="checkbox" name="formImporteren[]" value="Importeer als vrijwilligers"/>Vrijwilligers</br>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" name="submit" value="Importeren" class="btn btn-default"/>
        </form>
    </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalHulp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Personeelsfeest beheren</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Op deze pagina kan je het personeelsfeest beheren.</p>
            <p>Je kan de datum van het feest en de deadline aanpassen in de eerste tab. Hier stel je ook datums in voor het nieuwe personeelsfeest.</p>
            <p>In de tweede tab krijg je links naar verschillende pagina's:</p>
            <ul>
                <li>Op de pagina 'Gebruikers toevoegen' kan je personeelsleden en vrijwilligers toevoegen. Deze krijgen dan een mail aan met hun inloggegevens en een link om direct in te loggen.</li>
                <li>Op de pagina 'Dagonderdelen beheren' kan je de dagonderdelen beheren. Je kan dagonderdelen verwijderen, aanmaken en aanpassen. Je kan de naam instellen, het begin -en einduur, en of vrijwilligers mogen deelnemen</li>
                <li>Op de pagina 'Locaties beheren' kan je locaties aanpassen, aanmaken en verwijderen. Je kan telkens de naam en beschrijving ingeven.</li>
                <li>Op de pagina 'Activiteiten en Taken beheren' kan je per dagonderdeel de activiteiten en de taken aanpassen, aanmaken en verwijderen.</li>
                <?php if($gebruiker->soortId == 4){ ?>
                <li>Op de pagina 'Organisatoren beheren' krijg je een lijst van alle personeelsleden waarin je op naam kan zoeken. Je kan telkens zien of deze organisator zijn of niet en dit aanpassen. Let zeker op dat je je aanpassingen telkens opslaagt!</li>
                <?php } ?>
            </ul>
            <p>
            In de derde tab staat een knop om een nieuw personeelsfeest aan te maken. <span class="text-danger">Pas op! Als je dit doet kan je geen aanpassingen meer maken aan het huidige personeelsfeest,</span> dit wordt dan als afgesloten
            beschouwd. Gebruikers zullen niet meer kunnen inloggen! Voor het nieuwe personeelsfeest kan je
            kiezen of je de dagonderdelen wilt behouden en of je de organisators mee wil overnemen, zodat zij hun
            account kunnen blijven gebruiken. Locaties blijven ook bestaan. De datums voor het nieuwe personeelsfeest stel je op de eerste tab in.
            </p>
            <p>
            In de vierde tab kan je emailadressen importeren. Hiervoor moet je een csv bestand uploaden. Dit kan
            je via excel aanmaken. Je maakt 3 kolommen. Je zet telkens in de eerste kolom de voornaam, in de tweede
            de achternaam, en in de derde het emailadres van de persoon. Je slaagt dit op als .csv bestand en kan
            het dan importeren. Alle personen in dit bestand zullen automatisch een account krijgen. Je kan kiezen
            om ze als vrijwilligers of als personeelsleden toe te voegen.
            </p>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<?php if($error){?>
    <script>
        $(document).ready(function(){
            alert("<?php echo $errorMessage; ?>");
        });
    </script>
<?php }
 