<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Taak
 *
 * @author yen
 */
class Taak extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
    }

    function index($id, $isD = false) {
        //Index pagina laden van Taken Beheren
        //Klaarzetten Variabelen
        //Array Taken (Complete)
        $taken = array();

        //Variabelen klaarzetten
        $table = ($isD) ? 'dagOnderdeel' : 'optie';
        $taakColumn = ($isD) ? 'dagOnderdeelId' : 'optieId';

        //Titel van pagina ophalen
        $this->load->model('CRUD_Model');
        $titel = $this->CRUD_Model->get($id, $table);

        //Ophalen van taken via het meegegeven id, zetten in TakenIC (Taken InComplete - Niet Volledig)
        $this->load->model('Taak_model');
        $takenIC = $this->Taak_model->getAllByDagOnderdeel($id);

        //Voor elke taak-object extra attributen meegegeven (Tijd en Aantal plaatsen) -> TakenIC uitpakken
        $this->load->model('TaakShift_model');

        foreach ($takenIC as $taak) {
            //Ophalen tijd en aantal plaatsen attributen
            $begin = $this->TaakShift_model->getEersteTijd($taak->id);
            $einde = $this->TaakShift_model->getLaatsteTijd($taak->id);
            $aantal = $this->TaakShift_model->getSUM($taak->id);

            //Samanstellen van het tijd attribuut van taak
            $taak->tijd = $begin->begintijd . " - " . $einde->eindtijd;
            $taak->aantalPlaatsen = $aantal->aantalPlaatsen;

            //Het object taak in de array Taken plaatsen
            array_push($taken, $taak);
        }

        $data['isD'] = $isD;
        $data['doId'] = $id;

        $data['titel'] = $titel->naam;
        $data['taken'] = $taken;

        $this->load->model('CRUD_Model');
        $row = $this->CRUD_Model->getLast('id', 'personeelsfeest');
        $data['personeelsfeest'] = $row->id;

        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        $partials = array('inhoud' => 'Taak beheren/overzichtTaken', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    function wijzig($taakId, $doId, $isD) {
        //Het taakId en dagonderdeelId worden meegegeven aan de methode index van de controller TaakShift -> Redirect naar TaakShift;
        redirect("Organisator/TaakShift/index/$taakId/$doId/$isD");
    }

    function voegToe($doId, $isD) {
        //Toevoegen van een niewe taak aan een bepaald dagonderdeel
        //Nieuw (standaard leeg) object taak aanmaken
        $taak = new stdClass();

        //Het object taak opvullen met standaard informatie, het dagonderdeelid wordt opgevuld met de veriabele doId
        $taak->dagOnderdeelId = $doId;
        $taak->optieId = null;
        $taak->naam = "Druk op Wijzigen";
        $taak->beschrijving = "Voeg hier een beschrijving toe";

        //De methode add van het Crud Model oproepen om het object taak toe te voegen aan de tabel taak
        $this->load->model('CRUD_Model');
        $this->CRUD_Model->add($taak, 'taak');

        //De methode index uitvoeren van deze controller, er wordt het dagonderdeelid meegegeven waarvoor zojuist een nieuwe record was aangemaakt.
        $this->index($doId, $isD);
    }

    //I'm sorry Wim but it's time for the Java way
    function verwijderen($id, $doId, $isD) {
        date_default_timezone_set('Europe/Brussels');
        
        ///Get everything ready
        $this->load->model('Pipeline_Model');

        ///Get Array from Pipeline
        $stuurArray = $this->Pipeline_Model->pl_Mail(2, $id);

        $taken = $stuurArray["taken"];
        $shiften = $stuurArray["shiften"];
        $helpers = $stuurArray["helpers"];
        $vrijwilligers = $stuurArray["vrijwilligers"];

        $this->load->model('CRUD_Model');
        $taak = $this->CRUD_Model->get($taken, 'taak');
        foreach ($shiften as $shift) {
            foreach ($helpers[$shift->id] as $helper) {
                $geadresseerde = $vrijwilligers["$shift->id-$helper->deelnemerId"]->email;
                $boodschap = "Beste " . $vrijwilligers["$shift->id-$helper->deelnemerId"]->voornaam . " " . $vrijwilligers["$shift->id-$helper->deelnemerId"]->naam . ",\n u inschrijving bij de taak \"" . $taak->naam . "\" van $shift->begintijd tot $shift->eindtijd werd geannuleerd.";
                $titel = "Annulatie inschrijving";

                $this->load->library('email');
                $this->email->from('teamachtien@gmail.com', 'Team 18');
                $this->email->to($geadresseerde);
                $this->email->cc('');
                $this->email->subject($titel);
                $this->email->message($boodschap);
                
                $this->CRUD_Model->delete($helper->id, 'helperTaak');
            }
            
            $this->CRUD_Model->delete($shift->id, 'taakShift');
        }
        
        $this->CRUD_Model->delete($taak->id, 'taak');
        
        $this->index($doId, $isD);
    }

}
