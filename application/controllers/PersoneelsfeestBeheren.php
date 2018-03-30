<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PersoneelsfeestBeheren extends CI_Controller
{

    // +----------------------------------------------------------
    // | Personeelsfeest
    // +----------------------------------------------------------
    // | PersoneelsfeestBeheren controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------


    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');
    }

    public function index()
    {
        $this->load->model('Personeelsfeest_model');

        $data['titel'] = 'Instellingen';
        $data['data'] = $this->Personeelsfeest_model->getLaatstePersoneelsfeest();
        $data['exporteren'] = $this->Personeelsfeest_model->getJarenPersoneelsfeest();

        $partials = array('inhoud' => 'personeelsfeestBeheren/personeelsfeestBeheren', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function toonStartScherm($gebruiker)
    {
        $data['titel'] = 'Personeelsfeest';
        $data['gebruiker'] = $gebruiker;

        $partials = array('inhoud' => 'startScherm', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

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

    public function nieuwPersoneelsfeest($id)
    {
        $this->load->model('Personeelsfeest_model');

        /**
         * Nieuw personeelsfeest aanmaken
         */
        $personeelsfeest = new stdClass();
        $personeelsfeest->id = $id + 1;
        $personeelsfeest->datum = '00:00:00';
        $personeelsfeest->inschrijfDeadline = '00:00:00';

        $this->Personeelsfeest_model->insertPersoneelsfeest($personeelsfeest);

        if (isset($_POST['nieuwDagonderdeel'])) {
            $dagonderdelen = $this->Personeelsfeest_model->getDagonderdelenVanPersoneelsfeest($id);
            foreach ($dagonderdelen as $dagonderdeel){
                $dagonderdeel->personeelsfeestId += 1;
                $this->Personeelsfeest_model->insertDagonderdeel($dagonderdeel);
            }
        } else {
            var_dump("leeg");
        }
        if (isset($_POST['nieuwOrganisatoren'])) {
            $organisatoren = $this->Personeelsfeest_model->getOrganisatorenVanPersoneelsfeest($id);

            foreach ($organisatoren as $organisator){
                $organisator->personeelsfeestId +=1;
                $this->Personeelsfeest_model->insertOrganisatoren($organisator);
        }
        } else {
            var_dump("leeg");
        }

        $this->index();
    }
}
