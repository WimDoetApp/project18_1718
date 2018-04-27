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
    }

    public function index($personeelsfeestId)
    {
        /**
         * Modellen laden
         */
        $this->load->model('DagOnderdeel_model');

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
    public function inschrijven() {

    }
}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
