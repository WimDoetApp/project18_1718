<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
     * Controller Home
     * @author: Wim Naudts
     */
    public function __construct() {
        parent::__construct();
        
        $this->load->helper('form');
        $this->load->model('personeelsfeest_model');
        $this->load->model('deelnemer_model');
    }

    /**
     * Inlogscherm
     */
    public function index() {
        $data['titel'] = '';

        $partials = array('inhoud' => 'Inloggen/inloggen', 'header' => 'Inloggen/inloggen_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Startscherm van alle gebruikers
     */
    public function toonStartScherm() {
        /**
         * Titel kiezen
         */
        $data['titel'] = 'Personeelsfeest';
        $aangemeld = false;
                
        /**
         * Bepalen wat het huidige personeelsfeest is
         */
        $personeelsfeest = $this->personeelsfeest_model->getLaatsteId();
        $personeelsfeestId = $personeelsfeest->id;
        $data['personeelsfeest'] = $personeelsfeestId;
        
        if($this->authex->isAangemeld()){
            $aangemeld = true;
        }else{
            /**
            * Email en wachtwoord ophalen
            */
            $email = $this->input->post('email');
            $wachtwoord = $this->input->post('wachtwoord');
            /**
            * Aanmelden van de gebruiker
            */
            if($this->authex->meldAan($email, $wachtwoord, $personeelsfeestId)){
               $aangemeld = true; 
            }
        }
        
        if($aangemeld){
            $gebruiker = $this->authex->getDeelnemerInfo();
            $data["gebruiker"] = $gebruiker;
            
            $partials = array('inhoud' => 'startScherm', 'header' => 'main_header', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }else{
            $this->index();
            /**
             * Foutmelding
             */
        }
    }
    
    /**
     * Afmelden
     */
    public function afmelden(){
        $this->authex->meldAf();
        $this->index();
    }
}
