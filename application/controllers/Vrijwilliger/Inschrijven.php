<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inschrijven extends CI_Controller {

    /**
     * Controller Inschrijven
     * @author Wim Naudts
     */

    public function __construct() {
        parent::__construct();
        
        $this->load->helper('form');
        
        /**
         * Kijken of de gebruiker de juiste rechten heeft
         */
        if (!$this->authex->isAangemeld()) {
            redirect('Home/index');
        }
        
        /**
         * De juiste models inladen
         */
        $this->load->model('DagOnderdeel_model');
    }
    
    /**
     * Ophalen lijst van alle dagonderdelen
     * @param $personeelsfeestId id van het huidige personeelsfeest
     */
    public function index($personeelsfeestId)
    {
        $data['titel']  = 'Inschrijven';
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();

        $data['dagonderdelen'] = $this->DagOnderdeel_model->getAllByStartTijdWithOpties($personeelsfeestId);
        $data['personeelsfeest'] = $personeelsfeestId;

        $partials = array('inhoud' => 'Inschrijven/inschrijven', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
}
