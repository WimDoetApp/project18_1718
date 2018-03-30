<?php
/**
 *  We geven naar elke pagina door over welk personeelsfeest het gaat
 */
echo form_hidden("personeelsfeestid", $data->id);

$attributen = array('name' => 'mijnFormulier');
echo form_open('PersoneelsfeestBeheren/nieuwPersoneelsfeest/' . $data->id, $attributen);
?>

<div class='Datums'>
    <h3>
        Datums:
    </h3>
    <div class="form-group">
        <?php
        /**
         * datum
         */
        echo form_labelpro('Datum:', 'datum');
        echo '<div class="input-group date">';
        echo form_input(array('name' => 'datum',
            'id' => 'datum',
            'value' => zetOmNaarDDMMYYYY($data->datum),
            'class' => 'form-control datepicker',
            'required' => 'required'));
        ?>
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
        </div>
        <?php
        /**
         * datum deadline
         */
        echo '</div></br>';
        echo form_labelpro('Deadline inschrijvingen', 'deadline');
        echo '<div class="input-group date">';
        echo form_input(array('name' => 'deadline',
            'id' => 'deadline',
            'value' => zetOmNaarDDMMYYYY($data->inschrijfDeadline),
            'class' => 'form-control datepicker',
            'required' => 'required'));
        ?>
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
        </div>
    </div>
</div>
</div>
<div class="Importeren">
    <h3>
        Importeren e-mailadressen:
    </h3>
    <div class="form-group">
        <input type="checkbox" name="formImporteren[]" value="Personeelsleden"/>Personeelsleden</br>
        <input type="checkbox" name="formImporteren[]" value="Vrijwilligers"/>Vrijwilligers</br>
        <input type="submit" name="formImporterenSubmit" value="Importeren"/>
    </div>
</div>
<div class="Exporteren">
    <h3>
        Overzicht exporteren:
    </h3>
    <div class="form-group">
        <?php
        echo form_dropdownpro('id', $exporteren, 'Jaar', 'Jaar', '0');
        ?>
    </div>
</div>
<div class="Aanpassen">
    <h3>
        Aanpassingen maken
    </h3>
    <div class="form-group">
        <?php
        echo smallDivAnchor("PersoneelsfeestBeheren/toonStartscherm/1", "Gebruikers toevoegen", 'class="btn btn-default"');
        echo smallDivAnchor("DagOnderdeelBeheren/toonDagonderdelen/$data->id", "Dagonderdelen beheren", 'class="btn btn-default"');
        echo smallDivAnchor("Locatie/index", "Locatie beheren", 'class="btn btn-default"');
        echo smallDivAnchor("OrganisatorenBeheren/toonPersoneelsleden/$data->id", "Organisatoren beheren", 'class="btn btn-default"');
        ?>
    </div>
</div>
<div class="NieuwPersoneelsfeest">
    <h3>
        Nieuw personeelsfeest:
    </h3>
    <div class="form-group">
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
                        <input type="checkbox" name="nieuwDagonderdeel"/>Dagonderdelen met de opties van
                        vorig jaar behouden</br>
                        <input type="checkbox" name="nieuwOrganisatoren"/>Organisatoren behouden</br>
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
</form>
