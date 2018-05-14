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
         */
        if (!$this->authex->isAangemeld()) {
            redirect('Home/index');
        }
        /**
         * Modellen laden
         */
        $this->load->model('HelperTaak_model');
        $this->load->model('DagOnderdeel_model');
    }

    public function index($personeelsfeestId)
    {
        /**
         * Data opvullen en doorsturen naar de pagina
         */
        $data['titel'] = 'Hulp aanbieden';
        $data['personeelsfeest'] = $personeelsfeestId;
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        $data['dagonderdelen'] = $this->DagOnderdeel_model->getAllByStartTijdWithOptiesWithTakenWithShiften($personeelsfeestId);
        $partials = array('inhoud' => 'Hulp aanbieden/hulpAanbieden', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function shiftenTonen()
    {
        $id = $this->input->get('id');
        $personeelsfeestId = $this->input->get('personeelsfeestId');

        $geselecteerddagonderdeel = $this->DagOnderdeel_model->getDagonderdeelByStartTijdWithOptiesWithTakenWithShiften($personeelsfeestId, $id);
        echo json_encode($geselecteerddagonderdeel);
    }

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
}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
