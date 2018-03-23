<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DagOnderdeelBeheren extends CI_Controller {

    // +----------------------------------------------------------
    // | Personeelsfeest
    // +----------------------------------------------------------
    // | DagOnderdeel controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------


    public function __construct() {
        parent::__construct();
        
        $this->load->helper('form');
    }
    
    /**
     * Ophalen lijst van alle dagonderdelen
     * @param $personeelsfeestId id van het huidige personeelsfeest
     */
    public function toonDagonderdelen($personeelsfeestId)
    {
        $data['titel']  = 'Dagonderdelen beheren';

        $this->load->model('dagonderdeel_model');
        $this->load->model('locatie_model');
        $data['dagonderdelen'] = $this->dagonderdeel_model->getAllByStartTijd($personeelsfeestId);
        $data['locaties'] = $this->locatie_model->getAll();
        $data['personeelsfeest'] = $personeelsfeestId;

        $partials = array('inhoud' => 'dagonderdelenbeheren/dagonderdelen', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Aanpassen van een dagonderdeel of
     * Nieuw dagonderdeel maken of
     * dagonderdeel verwijderen
     */
    public function wijzig(){
        /**
         * declareren variabelen
         */
        $personeelsfeestId = $this->input->post('personeelsfeestId');
        $this->load->model('dagonderdeel_model');
        
        /**
         * Bepalen op welke knop er gedrukt is
         */
        if (isset($_POST['buttonNieuw'])) {
            $this->getEmptyDagonderdeel($personeelsfeestId);
            $this->toonDagonderdelen($personeelsfeestId);
        }else{
            if (isset($_POST['buttonVerwijder'])) {
                $teller = $this->input->post('buttonVerwijder');
                
                $this->dagonderdeel_model->delete($this->input->post("id[$teller]"));
                $this->toonDagonderdelen($personeelsfeestId); 
            }else{
                $dagonderdeel = new stdClass();
            
                $teller = $this->input->post('buttonWijzig');
                $dagonderdeel->id = $this->input->post("id[$teller]");
                $dagonderdeel->naam = $this->input->post("naam[$teller]");
                $dagonderdeel->locatieId = $this->input->post("locatie[$teller]");
                $dagonderdeel->starttijd = $this->input->post("starttijd[$teller]");
                $dagonderdeel->eindtijd = $this->input->post("eindtijd[$teller]");
                $dagonderdeel->personeelsfeestId = $personeelsfeestId;
                
                $heeftTaak = $this->input->post("heeftTaak[$teller]");
                $vrijwilligerMeedoen = $this->input->post("vrijwilligerMeedoen[$teller]");
                
                if ($heeftTaak == "") {
                    $dagonderdeel->heeftTaak = 0;
                }else{
                    $dagonderdeel->heeftTaak = $heeftTaak;
                }
                
                if ($vrijwilligerMeedoen == "") {
                    $dagonderdeel->vrijwilligerMeedoen = 0;
                }else{
                    $dagonderdeel->vrijwilligerMeedoen = $vrijwilligerMeedoen;
                }
            
                $this->dagonderdeel_model->update($dagonderdeel);
                $this->toonDagonderdelen($personeelsfeestId); ;
            }
        }
    }
    
    /**
     * Nieuw dagonderdeel aanmaken
     * @param int $personeelsfeestId (id van het huidige personeelsfeest)
     */
    function getEmptyDagonderdeel($personeelsfeestId)
    {
        $dagonderdeel = new stdClass();
        $dagonderdeel->starttijd = '00:00:00';
        $dagonderdeel->eindtijd = '00:00:00';
        $dagonderdeel->naam = 'nieuw dagonderdeel';
        $dagonderdeel->personeelsfeestId = $personeelsfeestId;
        $dagonderdeel->heeftTaak = '0';
        $dagonderdeel->vrijwilligerMeeDoen = '0';
        $dagonderdeel->locatieId = 1;   

        $this->load->model('dagonderdeel_model');
        $this->dagonderdeel_model->insert($dagonderdeel);
    }
}
