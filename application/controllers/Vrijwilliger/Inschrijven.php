<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inschrijven extends CI_Controller {

    /**
     * Controller Inschrijven
     * @class Inschrijven
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
        $this->load->model('InschrijvingsOptie_model');
        $this->load->model('Optie_model');
    }
    
    /**
     * Variabele die de inschrijvingen bijhoudt om door te geven aan de overzichtpagina
     * @var ingeschrevenOpties 
     */
    private $ingeschrevenOpties = array();
    
    /**
     * Ophalen lijst van alle dagonderdelen
     * @param $personeelsfeestId id van het huidige personeelsfeest
     */
    public function index($personeelsfeestId)
    {
        $data['titel']  = 'Inschrijven';
        $gebruiker = $this->authex->getDeelnemerInfo();
        $data['gebruiker'] = $gebruiker;

        $data['dagonderdelen'] = $this->DagOnderdeel_model->getAllByStartTijdWithOpties($personeelsfeestId);
        $this->load->model('CRUD_Model');
        $data['feest'] = $this->CRUD_Model->get($personeelsfeestId, 'personeelsfeest');
        $data['personeelsfeest'] = $personeelsfeestId;

        $partials = array('inhoud' => 'Inschrijven/inschrijven', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Inschrijven van de deelnemer
     */
    public function schrijfIn(){
        /**
         * id van het personeelsfeest, lijst van alle dagonderdelen
         */
        $personeelsfeestId = $this->input->post('personeelsfeestId');   
        $dagonderdelen = $this->DagOnderdeel_model->getAllByStartTijdWithOpties($personeelsfeestId);
        
        /**
         * Voor elk dagonderdeel inschrijven
         */
        foreach($dagonderdelen as $dagonderdeel){
            $this->schrijfOptieIn($dagonderdeel);
        }
        
        /**
         * Overzicht inschrijving
         */
        $this->inschrijfBevestiging();
    }
    
    /**
     * Inschrijven voor de gekozen optie in een dagonderdeel
     * @param $dagonderdeel het dagonderdeel waarvoor we willen inschrijven
     */
    private function schrijfOptieIn($dagonderdeel){
        /**
         * gebruiker die we inschrijven
         */
        $gebruiker = $this->authex->getDeelnemerInfo();
        $alIngeschrevenBijDagonderdeel = false;
        $ingeschrevenOptie = 0;
        
        /**
         * De waarden opvragen
         */
        $inschrijfOptie = new stdClass();
        
        $inputOptie = $this->input->post("optie[$dagonderdeel->id]");
        $optie = intval($inputOptie);
        $inschrijfOptie->optieId = $optie;
        $inschrijfOptie->deelnemerId = $gebruiker->id;
        $inschrijfOptie->commentaar = $this->input->post("commentaar[$optie]");
           
        /**
         * Checken of de gebruiker al ingeschreven is bij dit dagonderdeel
         */
        foreach($dagonderdeel->opties as $optieBijOnderdeel){
            if($optieBijOnderdeel->isAllIngeschreven){
                $alIngeschrevenBijDagonderdeel = true;
                $ingeschrevenOptie = $optieBijOnderdeel->id;
            }
        }
        
        if($alIngeschrevenBijDagonderdeel){
            /**
             * Als dit zo is schrijven we hem eerst uit
             */
            $this->InschrijvingsOptie_model->schrijfUit($ingeschrevenOptie, $gebruiker->id);
            /**
             * Als de optie niet 0 is, dus "Geen" => deelnemer inschrijven voor de gekozen optie
             */
            if($optie != 0){
                $this->InschrijvingsOptie_model->schrijfIn($inschrijfOptie);
                array_push($this->ingeschrevenOpties, $inschrijfOptie);
            }
        }
        else{
            if($optie != 0){
                $this->InschrijvingsOptie_model->schrijfIn($inschrijfOptie);
                array_push($this->ingeschrevenOpties, $inschrijfOptie);
            }
        }
    }
    
    /**
     * Pagina met overzicht van de inschrijving weergeven
     */
    private function inschrijfBevestiging(){
        /**
         * gebruiker die is ingeschreven, id van het personeelsfeest, dagonderdelen met opties en ingeschreven opties meegeven
         */
        $gebruiker = $this->authex->getDeelnemerInfo();
        $personeelsfeestId = $this->input->post('personeelsfeestId');  
        $data['dagonderdelen'] = $this->DagOnderdeel_model->getAllByStartTijdWithOpties($personeelsfeestId);
        $data['ingeschrevenOpties'] = $this->ingeschrevenOpties;
        $data['gebruiker'] = $gebruiker;
        $data['personeelsfeest'] = $personeelsfeestId;
        $data['titel']  = 'Inschrijven';
        
        $partials = array('inhoud' => 'Inschrijven/overzicht', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
}
