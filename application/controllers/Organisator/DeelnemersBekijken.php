<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DeelnemersBekijken extends CI_Controller {
    /**
     * @class DeelnemersBekijken
     * @brief Controller voor de usecase Deelnemers bekijken
     * @author Wim Naudts
     */

    public function __construct() {
        parent::__construct();
        
        $this->load->helper('form');
        /**
         * Benodigde models inladen
         * @see DagOnderdeel_model.php
         * @see Deelnemer_model.php
         * @see Personeelsfeest_model.php
         */
        $this->load->model('DagOnderdeel_model');
        $this->load->model('Deelnemer_model');
        $this->load->model('Personeelsfeest_model');
        
        /**
         * Kijken of de gebruiker de juiste rechten heeft
         * @see Authex::isAangemeld()
         * @see Authex::getDeelnemerInfo()
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
     * Naar de pagina navigeren
     * @param $personeelsfeestId
     * @see Authex::getDeelneemerInfo()
     * @see Overzicht/overzichtDeelnemers.php
     */
    public function index($personeelsfeestId){
        $data['titel']  = 'Overzicht gebruikers';
        $data['personeelsfeest'] = $personeelsfeestId;
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $partials = array('inhoud' => 'Overzicht/overzichtDeelnemers', 'header' => 'main_header', 'footer' => 'Overzicht/deelnemers_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Overzicht van alle gebruikers bij een personeelsfeest
     * @see Deelnemer_model::getAll()
     */
    public function haalDeelnemersOp(){
        $personeelsfeestId = $this->input->get('personeelsfeestId');
        
        $deelnemers = $this->Deelnemer_model->getAll($personeelsfeestId);
        
        echo json_encode($deelnemers);
    }
    
    /**
     * Details over een gebruiker ophalen
     * @param $deelnemerId id van de gebruiker
     * @param $personeelsfeestId id van het huidige personeelsfeest
     * @see Deelnemer_model::getWithAll()
     * @see Authex::getDeelnemerInfo()
     * @see DagOnderdeel_model::getAllByStartTijd()
     * @see Overzicht/detailDeelnemer.php
     */
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
