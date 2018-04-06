<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DagOnderdeelBeheren extends CI_Controller {

    /**
     * Controller Dagonderdelen beheren
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
     * Ophalen lijst van alle dagonderdelen
     * @param $personeelsfeestId id van het huidige personeelsfeest
     */
    public function toonDagonderdelen($personeelsfeestId)
    {
        $data['titel']  = 'Dagonderdelen beheren';
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();

        $this->load->model('Locatie_model');
        $data['dagonderdelen'] = $this->DagOnderdeel_model->getAllByStartTijd($personeelsfeestId);
        $data['locaties'] = $this->Locatie_model->getAllesBijLocatie();
        $data['personeelsfeest'] = $personeelsfeestId;

        $partials = array('inhoud' => 'Dagonderdelen beheren/dagonderdelen', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function getInput(){
        /**
         * id van het personeelsfeest
         */
        $personeelsfeestId = $this->input->post('personeelsfeestId');
        /**
         * Bepalen op welke knop er is gedrukt
         */
        if (isset($_POST['buttonNieuw'])) {
            /**
             * leeg dagonderdeel aanmaken
             */
            $this->getEmptyDagonderdeel($personeelsfeestId);
            $this->toonDagonderdelen($personeelsfeestId); 
        }else{
            if (isset($_POST['buttonVerwijder'])) {
                /**
                 * Dagonderdeel verwijderen
                 */
                $teller = $this->input->post('buttonVerwijder');
                $this->DagOnderdeel_model->delete($this->input->post("id[$teller]"));
                $this->toonDagonderdelen($personeelsfeestId); 
            }else{
                /**
                 * Dagonderdeel aanpassen
                 */
                $this->wijzig($personeelsfeestId);
            }
        }
    }

    /**
     * Aanpassen van een dagonderdeel
     */
    public function wijzig($personeelsfeestId){
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
            
        $this->DagOnderdeel_model->update($dagonderdeel);
        $this->toonDagonderdelen($personeelsfeestId); 
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

        $this->DagOnderdeel_model->insert($dagonderdeel);
    }
}
