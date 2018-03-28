<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FotosBeheren extends CI_Controller {

    // +----------------------------------------------------------
    // | Personeelsfeest - Jari
    // +----------------------------------------------------------
    // | Foto's beheren controller
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
        $this->load->helper('html');
    }
    
    /**
    * 
    */
    public function index() {
        $data['titel']  = "Foto's beheren";

        $this->load->model('crud_model');
        $data['jaartallen'] = $this->crud_model->getAll('personeelsfeest');
        
        $this->load->model('crud_model');
        $data['fotos'] = $this->crud_model->getAll('foto');

        $partials = array('inhoud' => 'fotos beheren/fotosBeheren', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
} 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
