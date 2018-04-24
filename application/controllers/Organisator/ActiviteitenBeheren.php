<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ActiviteitenBeheren extends CI_Controller {


    // +----------------------------------------------------------
    // | Personeelsfeest - Jari
    // +----------------------------------------------------------
    // | Activiteiten beheren controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

    /**
     * Controller Dagonderdelen beheren
     * @author Jari Mathé
     */



    public function __construct() {
        parent::__construct();
        /**
         * Laad de helper voor formulieren
        */
        $this->load->helper('form');
        
        /**
         * Kijken of de gebruiker de juiste rechten heeft
         */
        if (!$this->authex->isAangemeld()) {
            redirect('home/index');
        } else {
            $gebruiker = $this->authex->getDeelnemerInfo();
            if ($gebruiker->soortId < 3) {
                redirect('home/toonStartScherm');
            }
        }
    }
    
    /**
    * Open de pagina met connectie tot de data van personeelsfeest_locatie en personeelsfeest_dagonderdeel
    */
    public function index() {
        $data['titel']  = 'Leveranciers';
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Locatie_model');
        $data['locaties'] = $this->Locatie_model->getAllesBijLocatie();
        
        $this->load->model('Personeelsfeest_model');
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;
        
        $this->load->model('DagOnderdeel_model');
        $data['dagonderdelen'] = $this->DagOnderdeel_model->getAllesBijDagonderdeel();
        
        $partials = array('inhoud' => 'Activiteiten beheren/nieuweActiviteit', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Alle ingevulde data doorsturen naar de database personeelsfeest_optie
     */
    public function registreer()
	{
            $info = new stdClass();
            
            $info->naam = $this->input->post('naam');
            $info->beschrijving = $this->input->post('beschrijving');
            $info->minimumAantalPlaatsen = $this->input->post('minimumAantalPlaatsen');
            $info->maximumAantalPlaatsen = $this->input->post('maximumAantalPlaatsen');
            

            /**
     * add id van locatie
     */
            $locatieId = $this->input->post('locatie');
            $info->locatieId = $locatieId;

            /**
     * add id van dagonderdeel
     */
            $dagOnderdeelId = $this->input->post('dagonderdeel');
            $info->dagOnderdeelId = $dagOnderdeelId;
            
             /**
     * zorgen dat het naar de optie database wordt gestuurrd
     */   
            $this->load->model('Optie_model');
            $id = $this->Optie_model->insert($info);
     /**
     * herlaad de pagina
     */
            redirect('ActiviteitenBeheren/index');
	}
}


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

