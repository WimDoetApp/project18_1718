<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class InformatieVersturen extends CI_Controller {

    // +----------------------------------------------------------
    // | Informatie versturen - Jari
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
        
        if (!$this->authex->isAangemeld()) {
            redirect('Home/index');
        } else {
            $gebruiker = $this->authex->getDeelnemerInfo();
            if ($gebruiker->soortId < 3) {
                redirect('Home/toonStartScherm');
            }
        }
    }
    
    /**
    * 
    */
    public function index() {
        $data['titel']  = "Foto's beheren";
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Personeelsfeest_model');
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;

       
        $this->load->model('CRUD_Model');
        $data['mails'] = $this->CRUD_Model->getAll('emailsjabloon');
        
        $partials = array('inhoud' => 'Informatie versturen/emailOverzicht' , 'header' => 'main_header', 'footer' => 'main_footer');
        $error = array('error' => ' ' );
        $this->template->load('main_master', $partials, $data, $error);
    }
    
    /**
    * Pagina met overzicht van alle mails in de database
    */
    public function emailOpstellenPagina() {
        $data['titel']  = "Foto's beheren";
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Personeelsfeest_model');
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;
        
        $this->load->model('CRUD_Model');
        $data['soorten'] = $this->CRUD_Model->getAll('soort');
        
        $partials = array('inhoud' => 'Informatie versturen/emailOpstellen' , 'header' => 'main_header', 'footer' => 'main_footer');
        $error = array('error' => ' ' );
        $this->template->load('main_master', $partials, $data, $error);
    }
    
    
    public function registreerMail(){
        $info = new stdClass();
            
        $info->onderwerp = $this->input->post('onderwerp');
        $info->sjabloon = $this->input->post('mail');
        $info->soortId = $this->input->post('filteren');
       
        
        $this->load->model('CRUD_Model');
        $this->CRUD_Model->add($info, 'emailsjabloon');
        
        redirect("Organisator/InformatieVersturen/verzondenPagina");
    }
    
    /**
    * Verwijzen naar de pagina met een waarschuwing
    */
    public function verwijderenPagina() {
        $data['titel']  = "Foto's beheren";
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Personeelsfeest_model');
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;
        
        $id = $this->input->get('id');
        $this->load->model('CRUD_Model');
        $data['mail'] = $this->CRUD_Model->get($id,'emailsjabloon');
       
        $partials = array('inhoud' => 'Informatie versturen/emailVerwijderd' , 'header' => 'main_header', 'footer' => 'main_footer');
        $error = array('error' => ' ' );
        $this->template->load('main_master', $partials, $data, $error);
    }
    
    /**
    * De aangeduide id verwijderen  
    */
    public function verwijderMail()
        {
            $id = $this->input->get('id');
            $this->load->model('CRUD_Model'); 
            $this->CRUD_Model->delete($id, 'emailsjabloon');
            
            /**
            * Terug sturen naar de index pagina van informatie versturen
            */
            redirect('Organisator/InformatieVersturen/index');
        }
    
    /**
    * Verwijst naar de pagina email verzonden
    */
    public function verzondenPagina() {
        $data['titel']  = "Foto's beheren";
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Personeelsfeest_model');
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;

        
        $partials = array('inhoud' => 'Informatie versturen/emailVerzonden' , 'header' => 'main_header', 'footer' => 'main_footer');
        $error = array('error' => ' ' );
        $this->template->load('main_master', $partials, $data, $error);
    }
    
    
} 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
