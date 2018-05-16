<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class HulpAanbieden extends CI_Controller
{

    // +----------------------------------------------------------
    // | Personeelsfeest - Bram
    // +----------------------------------------------------------
    // | Hulp aanbieden controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------


    public function __construct()
    {
        parent::__construct();
        /**
         * Laad de helper voor formulieren
         */
        $this->load->helper('form');

        /**
         * Kijken of de gebruiker de juiste rechten heeft
         * @see Authex::isAangemeld()
         * @see Authex::getDeelnemerInfo()
         */
        if (!$this->authex->isAangemeld()) {
            redirect('Home/index');
        }
        /**
         * Benodigde models inladen
         * @see HelperTaak_model.php
         * @see DagOnderdeel_model.php
         */
        $this->load->model('HelperTaak_model');
        $this->load->model('DagOnderdeel_model');
    }

    /**
     * Admin panel weergeven
     * @param $personeelsfeestId id van het huidige personeelsfeest
     * @see CRUD_Model.php
     * @see DagOnderdeel_model.php
     * @see Hulp Aanbieden/hulpAanbieden.php
     */
    public function index($personeelsfeestId)
    {
        $data['titel'] = 'Hulp aanbieden';
        $data['personeelsfeest'] = $personeelsfeestId;
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        $this->load->model('CRUD_Model');
        $data['feest'] = $this->CRUD_Model->get($personeelsfeestId, 'personeelsfeest');
        $data['dagonderdelen'] = $this->DagOnderdeel_model->getAllByStartTijdWithOptiesWithTakenWithShiften($personeelsfeestId);
        $partials = array('inhoud' => 'Hulp aanbieden/hulpAanbieden', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Alle shiften van de taken en opties van het huidige personeelsfeest weergeven
     * @see DagOnderdeel_model.php
     * @see Hulp Aanbieden/hulpAanbieden.php
     */
    public function shiftenTonen()
    {
        $id = $this->input->get('id');
        $personeelsfeestId = $this->input->get('personeelsfeestId');

        $geselecteerddagonderdeel = $this->DagOnderdeel_model->getDagonderdeelByStartTijdWithOptiesWithTakenWithShiften($personeelsfeestId, $id);
        echo json_encode($geselecteerddagonderdeel);
    }

    /**
     * Controleer of de ingelogde gebruiker al is ingeschreven voor shiften
     * @see HelperTaak_model.php
     * @see Hulp Aanbieden/hulpAanbieden.php
     */
    public function controleIngeschreven()
    {
        $deelnemer = $this->authex->getDeelnemerInfo();
        $taakShiftId = $this->input->get('taakShiftId');
        $overeenkomsten = $this->HelperTaak_model->getAllWithTaakWhereDeelnemer($deelnemer->id, $taakShiftId);
        $aantal = count($overeenkomsten);
        if ($aantal > 0) {
            echo json_encode(true);
        }
        else {
            echo json_encode(false);
        }
    }

    /**
     * Schrijf de gebuiker in als vrijwilliger
     * @see HelperTaak_model.php
     * @see Hulp Aanbieden/hulpAanbieden.php
     */
    public function inschrijven()
    {
        $vrijwilliger = new stdClass();

        $deelnemer = $this->authex->getDeelnemerInfo();
        $vrijwilliger->deelnemerId = $deelnemer->id;
        $vrijwilliger->taakShiftId = $this->input->get('id');
        $vrijwilliger->commentaar = "";


        $this->HelperTaak_model->insertVrijwilliger($vrijwilliger);

        $personeelsfeestId = $this->input->get('personeelsfeestId');
        redirect("Vrijwilliger/HulpAanbieden/index/" . $personeelsfeestId);
    }

    /**
     * Schrijf de gebruiker uit als vrijwilliger
     * @see HelperTaak_model_model.php
     * @see Hulp Aanbieden/hulpAanbieden.php
     */
    public function uitschrijven()
    {
        $deelnemer = $this->authex->getDeelnemerInfo();

        $vrijwilliger = new stdClass;

        $vrijwilliger->deelnemerId = $deelnemer->id;
        $vrijwilliger->taakShiftId = $this->input->get('id');

        $this->HelperTaak_model->deleteVrijwilliger($vrijwilliger);

        $personeelsfeestId = $this->input->get('personeelsfeestId');
        redirect("Vrijwilliger/HulpAanbieden/index/" . $personeelsfeestId);
    }
}