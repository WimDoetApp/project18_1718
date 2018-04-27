<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DeelnemersBekijken extends CI_Controller {
    /**
     * Controller Deelnemers bekijken
     * @author Wim Naudts
     */

    public function __construct() {
        parent::__construct();
        
        $this->load->helper('form');
        $this->load->model('DagOnderdeel_model');
        $this->load->model('Deelnemer_model');
        $this->load->model('Personeelsfeest_model');
        
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
     * Overzicht van alle gebruikers bij een personeelsfeest
     * @param $personeelsfeestId
     */
    public function index($personeelsfeestId){
        $data['titel']  = 'Overzicht gebruikers';
        $data['personeelsfeest'] = $personeelsfeestId;
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $data['deelnemers'] = $this->Deelnemer_model->getAll($personeelsfeestId);
        
        $partials = array('inhoud' => 'Overzicht/overzichtDeelnemers', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function detail($deelnemerId, $personeelsfeestId){
        $data['personeelsfeest'] = $personeelsfeestId;
        $gebruiker = $this->Deelnemer_model->getWithAll($deelnemerId);
        $data['detailGebruiker'] = $gebruiker;
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        $data['titel']  = "Details $gebruiker->voornaam $gebruiker->naam";
        $data['deelnemer'] = $gebruiker;
        $data['dagonderdelen'] = $this->DagOnderdeel_model->getAllByStartTijd($personeelsfeestId);
        
        $partials = array('inhoud' => 'Overzicht/detailDeelnemer', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
}
