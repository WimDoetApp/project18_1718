<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EmailadressenRaadplegen extends CI_Controller {

    // +----------------------------------------------------------
    // | Personeelsfeest - Jari
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
        $data['titel']  = 'E-mail adressen';

        $partials = array('inhoud' => 'Emailadressen raadplegen/emailadressenRaadplegen', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
} 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
