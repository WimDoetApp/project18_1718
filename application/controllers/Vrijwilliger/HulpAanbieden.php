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
        $this->load->model('Taak_model');
        $this->load->model('TaakShift_model');
        $this->load->model('Optie_model');

        $dagonderdelen = $this->DagOnderdeel_model->getAllByStartTijd($personeelsfeestId);

        /**
         * Arrays voor juiste taken en aantal plaatsen aanmaken
         */
        $dagonderdelenTaak = array();
        $taken = array();
        $taakShiften = array();
        $opties = array();

        /**
         * Controleren welke gegevens voldoen
         */
        foreach ($dagonderdelen as $dagonderdeel) {
            var_dump($dagonderdeel);
            if ($dagonderdeel->heeftTaak === "1") {
                array_push($opties, $this->Optie_model->getOptieDagOnderdeelId($dagonderdeel->id));
                array_push($dagonderdelenTaak, $dagonderdeel);
                array_push($taken, $this->Taak_model->getAllByDagOnderdeel($dagonderdeel->id));
            }
        }
        foreach ($taken as $taak) {
            array_push($taakShiften, $this->TaakShift_model->getAantalPlaatsen($taak->id));
        }
        var_dump($dagonderdelenTaak, $taken, $taakShiften, $opties);
        /**
         * Data opvullen en doorsturen naar de pagina
         */
        $data['titel'] = 'Hulp aanbieden';
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        $data['dagonderdelenTaken'] = $dagonderdelenTaak;
        $data['taken'] = $taken;
        $data['taakShiften'] = $taakShiften;
        $data['opties'] = $opties;
        $partials = array('inhoud' => 'Hulp aanbieden/hulpAanbieden', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
