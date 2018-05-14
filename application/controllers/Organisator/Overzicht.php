<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Overzicht extends CI_Controller {
    /**
     * Controller Overzicht
     * @class Overzicht
     * @author Wim Naudts
     */

    public function __construct() {
        parent::__construct();
        
        $this->load->helper('form');
        $this->load->model('DagOnderdeel_model');
        
        /**
         * Kijken of de gebruiker de juiste rechten heeft
         */
        if (!$this->authex->isAangemeld()) {
            redirect('Home/index');
        } else {
            $gebruiker = $this->authex->getDeelnemerInfo();
            if ($gebruiker->soortId < 3) {
                redirect('Home/toonStartScherm');
            }
        }
    }
    
    /**
     * Overzicht laten zien van alle dagonderdelen met zijn optie's, mogelijkheden om dit aan te passen
     * @param $personeelsfeestId id van het huidige personeelsfeest
     */
    public function index($personeelsfeestId){
        $data['titel'] = 'Overzicht per dagonderdeel';
        $data['dagonderdelen'] = $this->DagOnderdeel_model->getAllByStartTijdWithOpties($personeelsfeestId);
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        $data['personeelsfeest'] = $personeelsfeestId;
        $this->load->model('Personeelsfeest_model');
        $data['personeelsfeesten'] = $this->Personeelsfeest_model->getAll();
        
        $partials = array('inhoud' => 'Overzicht/overzichtDagonderdelen', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Met JSON telkens de deelnemers bij een optie ophalen
     */
    public function haalDeelnemersOpJson(){
        $optieId = $this->input->get('optieId');
        
        $this->load->model('InschrijvingsOptie_model');
        $inschrijfOpties = $this->InschrijvingsOptie_model->getIngeschrevenBijOptie($optieId);
        
        echo json_encode($inschrijfOpties);
    }
}

