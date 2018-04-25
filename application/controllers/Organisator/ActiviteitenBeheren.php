<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ActiviteitenBeheren extends CI_Controller {


    // +----------------------------------------------------------
    // | Personeelsfeest - Jari
    // +----------------------------------------------------------
    // | Activiteiten beheren controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

    /**
     * Controller Dagonderdelen beheren
     * @author Jari Mathé, Wim Naudts
     */



    public function __construct() {
        parent::__construct();
        /**
         * Laad de helper voor formulieren
        */
        $this->load->helper('form');
        $this->load->model('Optie_model');
        $this->load->model('Personeelsfeest_model');
        
        /**
         * Kijken of de gebruiker de juiste rechten heeft
         */
        if (!$this->authex->isAangemeld()) {
            redirect('home/index');
        } else {
            $gebruiker = $this->authex->getDeelnemerInfo();
            if ($gebruiker->soortId < 3) {
                redirect('home/toonStartScherm');
            }
        }
    }
    
    /**
    * Open de pagina met connectie tot de data van personeelsfeest_locatie en personeelsfeest_dagonderdeel
    */
    public function index($optieId, $dagonderdeelId) {
        $personeelsfeestId = $this->Personeelsfeest_model->getLaatsteId()->id;
        $data['personeelsfeest'] = $personeelsfeestId;
        
        $id = 0;
        $naam = "";
        $beschrijving = "";
        $minimum = 0;
        $maximum = 0;
        $locatie = "";
        $button = 'Toevoegen';
        
        if($optieId != 0){
            $optie = $this->Optie_model->get($optieId);
            
            $id = $optie->id;
            $naam = $optie->naam;
            $beschrijving = $optie->beschrijving;
            $minimum = $optie->minimumAantalPlaatsen;
            $maximum = $optie->maximumAantalPlaatsen;
            $locatie = $optie->locatieId;
            $button = 'Aanpassen';
        }
        
        $data['naam'] = $naam;
        $data['beschrijving'] = $beschrijving;
        $data['minimum'] = $minimum;
        $data['maximum'] = $maximum;
        $data['locatieId'] = $locatie;
        $data['dagonderdeelId'] = $dagonderdeelId;
        $data['button'] = $button;
        $data['id'] = $id;
        
        $data['titel']  = 'Nieuwe activiteit';
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Locatie_model');
        $data['locaties'] = $this->Locatie_model->getAllesBijLocatie();
        
        $this->load->model('DagOnderdeel_model');
        $data['dagonderdelen'] = $this->DagOnderdeel_model->getAllByStartTijd($personeelsfeestId);
        
        $partials = array('inhoud' => 'Activiteiten beheren/nieuweActiviteit', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
    * Alle ingevulde data doorsturen naar de database personeelsfeest_optie
    */
    public function input(){
        $personeelsfeestId = $this->Personeelsfeest_model->getLaatsteId()->id;
        
        $optie = new stdClass();
        
        $optie->naam = $this->input->post('naam');
        $optie->beschrijving = $this->input->post('beschrijving');
        $optie->minimumAantalPlaatsen = $this->input->post('minimumAantalPlaatsen');
        $optie->maximumAantalPlaatsen = $this->input->post('maximumAantalPlaatsen');
        $optie->locatieId = $this->input->post('locatie');
        $optie->dagOnderdeelId = $this->input->post('dagonderdeel');
        
        if (isset($_POST['Toevoegen'])) {
            $id = $this->Optie_model->insert($optie);
        }else{
            if(isset($_POST['Aanpassen'])){
                $optie->id = $this->input->post('optieId');
                $id = $this->Optie_model->update($optie);
            }
        }
        
        /**
        * Teruggaan
        */
        redirect("Organisator/Overzicht/index/$personeelsfeestId");
    }
    
    public function verwijderActiviteit($optieId){
        $this->Optie_model->delete($optieId);
        
        /**
        * Teruggaan
        */
        $personeelsfeestId = $this->Personeelsfeest_model->getLaatsteId()->id;
        redirect("Organisator/Overzicht/index/$personeelsfeestId");
    }
}

