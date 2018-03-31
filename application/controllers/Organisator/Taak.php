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
    
    function index($id) {
        //Index pagina laden van Taken Beheren
        //Aanmaken array taken
        $taken = array();
        
        //Ophalen van taken via het meegegeven id, zetten in TakenIC (Taken InComplete - Niet Volledig)
        $this->load->model('Taak_model');
        $takenIC = $this->taak_model->getAllByDagOnderdeel($id);
        
        //Voor elke taak-object extra attributen meegegeven (Tijd en Aantal plaatsen) -> TakenIC uitpakken
        $this->load->model('Taakshift_model');  
        foreach ($takenIC as $taak) {
            //Ophalen tijd en aantal plaatsen attributen
            $begin = $this->taakshift_model->getEersteTijd($taak->id);
            $einde = $this->taakshift_model->getLaatsteTijd($taak->id);
            $aantal = $this->taakshift_model->getSUM($taak->id); 
            
            //Samanstellen van het tijd attribuut van taak
            $taak->tijd = $begin->begintijd . " - " . $einde->eindtijd;
            
            $taak->aantalPlaatsen = $aantal->aantalPlaatsen;
            
            //Het object taak in de array Taken plaatsen
            array_push($taken, $taak);
        }
        
        //de array Taken in de Array Data zetten om doorgestuurd te worden
        $data['taken'] = $taken;
        
        //het dagonderdeelId in een variabele zetten voor andere functies te kunnen laten werken
        $data['doId'] = $id;
        
        $data['titel'] = 'Tennis';
        
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        $partials = array('inhoud' => 'Taak beheren/overzichtTaken', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    function wijzig($taakId, $doId) {
        //Het taakId en dagonderdeelId worden meegegeven aan de methode index van de controller TaakShift -> Redirect naar TaakShift
        redirect("TaakShift/index/$taakId/$doId");
    }
    
    function voegToe($doId) {
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
        $this->index($doId);
    }
}
