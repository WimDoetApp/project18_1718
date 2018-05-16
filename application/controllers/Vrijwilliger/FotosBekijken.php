<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FotosBekijken extends CI_Controller {

    // +----------------------------------------------------------
    // | Personeelsfeest - Jari
    // +----------------------------------------------------------
    // | Foto's bekijken controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------


    public function __construct() {
        parent::__construct();
        /**
         * Laad de helpers
        */
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper(array('form', 'url'));
        
        if (!$this->authex->isAangemeld()) {
            redirect('Home/index');
        } else {
            $gebruiker = $this->authex->getDeelnemerInfo();
            if ($gebruiker->soortId > 2) {
                redirect('Home/toonStartScherm');
            }
        }
    }
    
    /**
    * 
    */
    public function index() {
        $data['titel']  = "Foto's Bekijken";
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Personeelsfeest_model');
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;

        $this->load->model('CRUD_Model');
        $data['jaartallen'] = $this->CRUD_Model->getAll('personeelsfeest');

        $partials = array('inhoud' => 'Fotos bekijken/fotosBekijken' , 'header' => 'main_header', 'footer' => 'main_footer');
        $error = array('error' => ' ' );
        $this->template->load('main_master', $partials, $data, $error);
    }
    
    public function loadFotosAjax() {
        
        $personeelsfeestId = $this->input->get('personeelsfeestId');
        
        $this->load->model('Foto_model');
        $data['fotos'] = $this->Foto_model->getAlleFotosZoalsPersoneelsfeestId($personeelsfeestId);
        
        $this->load->view('Fotos bekijken/fotosBekijkenAjax', $data);
    }
}