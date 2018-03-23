<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gebruiker_Toevoegen extends CI_Controller {

    // +----------------------------------------------------------
    // | Personeelsfeest
    // +----------------------------------------------------------
    // | Gebruiker toevoegen controller
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
    * 
    */
    public function index() {
        $data['titel']  = 'Gebruiker toevoegen';

        $partials = array('inhoud' => 'Gebruiker toevoegen/gebruiker_toevoegen', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function registreer()
	{
            $info = new stdClass();
            
            $info->naam = $this->input->post('naam');
            $info->voornaam = $this->input->post('voornaam');
            $info->email = $this->input->post('email');
            
            if($this->input->post('knopPersoneelslid')) { 
               $info->soortId = '1';
            } else {
               $info->soortId = '2';
            }
            
            

            $this->load->model('deelnemer_model');
            $id = $this->deelnemer_model->insert($info);
     /**
     * herlaad de pagina
     */
            redirect('gebruiker_toevoegen/index');
	}
} 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
