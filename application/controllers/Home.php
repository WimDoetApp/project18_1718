<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
     * Controller Home
     * @class Home
     * @author Wim Naudts
     */
    public function __construct() {
        parent::__construct();
        
        $this->load->helper('form');
        $this->load->model('Personeelsfeest_model');
        $this->load->model('Deelnemer_model');
    }

    /**
     * Inlogscherm
     */
    public function index() {
        /**
         * Als de gebruiker al is aangemeld, wordt hij meteen naar zijn startscherm doorverwezen
         */
        if($this->authex->isAangemeld()){
            $this->toonStartScherm();
        }else{
            $data['titel'] = '';

            $partials = array('inhoud' => 'Inloggen/inloggen', 'header' => 'Inloggen/inloggen_header', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
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
        $personeelsfeest = $this->Personeelsfeest_model->getLaatstePersoneelsfeest();
        $personeelsfeestId = $personeelsfeest->id;
        $data['personeelsfeest'] = $personeelsfeestId;
        $data['personeelsfeestHuidig'] = $personeelsfeest;
        
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
            
            $partials = array('inhoud' => 'startScherm', 'header' => 'main_header', 'footer' => 'start_footer');
            $this->template->load('main_master', $partials, $data);
        }else{
            $this->index();
            /**
             * Foutmelding
             */
        }
    }
    
    /**
     * Directe link in mail om aan te melden
     */
    public function aanmelden(){
        $id = $this->input->get('id');
        $email = $this->input->get('email');
        $deelnemers = $this->Deelnemer_model->getGebruikerByEmail($email);
        $gebruiker = "";
        
        foreach($deelnemers as $deelnemer){
            if(sha1($deelnemer->id) == $id){
                $gebruiker = $deelnemer;
            }
        }
        
        $this->authex->meldAan($gebruiker->email, $gebruiker->wachtwoord, $gebruiker->personeelsfeestId);
        $this->toonStartScherm();
    }
    
    /**
     * Afmelden
     */
    public function afmelden(){
        $this->authex->meldAf();
        $this->index();
    }
    
    /**
     * Voor mensen die niet ingelogd geraken
     */
    function hulp(){
        $data['titel'] = '';
        $data['message'] = '<p>Dit is een applicatie bestemt voor personeelsleden van de Thomas More Hogeschool in Geel en andere uitgenodigden. Accounts worden enkel per uitnodiging verzonden.</p><p>Bent u personeelslid maar hebt u geen aanmeldgegevens ontvangen in u mail? Neem dan contact op met de organisator</p>';
        $data['refer'] = 'Home/index';

        $partials = array('inhoud' => 'message', 'header' => 'Inloggen/inloggen_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Informatie over het account van de ingelogde gebruiker laten zien
     * @param $personeelsfeestId id van het huidige personeelsfeest
     * @param $error bool om te weten of we een foutmelding moeten weergeven
     * @param $errorMessage inhoud van de foutmelding
     */
    public function account($personeelsfeestId, $error, $errorMessage){
        $this->load->model('DagOnderdeel_model');
        $gebruiker = $this->Deelnemer_model->getWithAll($this->authex->getDeelnemerInfo()->id);
        
        $data['titel'] = "Welkom $gebruiker->voornaam";
        $data['personeelsfeest'] = $personeelsfeestId;
        $data['dagonderdelen'] = $this->DagOnderdeel_model->getAllByStartTijd($personeelsfeestId);
        $data['gebruiker'] = $gebruiker;
        $data['error'] = $error;
        $data['errorMessage'] = str_replace('%20', ' ', $errorMessage);
        
        $partials = array('inhoud' => 'account', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
}
