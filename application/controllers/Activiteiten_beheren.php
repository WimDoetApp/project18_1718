<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Activiteiten_Beheren extends CI_Controller {

    // +----------------------------------------------------------
    // | Personeelsfeest
    // +----------------------------------------------------------
    // | Activiteiten beheren controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------


    public function __construct() {
        parent::__construct();
        /**
         * Laad de helper voor formulieren
        */
        $this->load->helper('form');
    }
    
    /**
    * Open de pagina met connectie tot de data van personeelsfeest_locatie en personeelsfeest_dagonderdeel
    */
    public function index() {
        $data['titel']  = 'Leveranciers';
        
        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAllesBijLocatie();
        
        $this->load->model('dagonderdeel_model');
        $data['dagonderdelen'] = $this->dagonderdeel_model->getAllesBijDagonderdeel();
        
        $partials = array('inhoud' => 'Activiteiten beheren/nieuwe_activiteit', 'header' => 'main_header', 'footer' => 'main_footer');
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
            
            $this->load->model('optie_model');
            $id = $this->optie_model->insert($info);
     /**
     * herlaad de pagina
     */
            redirect('activiteiten_beheren/index');
	}
}


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

