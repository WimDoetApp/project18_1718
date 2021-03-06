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

    /**
     * Controller Fotos Beheren
     * @author Jari Mathé
     */

    public function __construct() {
        parent::__construct();
        /**
         * Laad de helper voor formulieren
        */
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper(array('form', 'url'));
        
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
    * Index pagina openen met een lege error
    */
    public function index($error = "") {
        $data['titel']  = "Foto's beheren";
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Personeelsfeest_model');
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;

        $this->load->model('CRUD_Model');
        $data['jaartallen'] = $this->CRUD_Model->getAll('personeelsfeest');
        
        $data['error'] = $error;

        $partials = array('inhoud' => 'Fotos beheren/fotosBeheren' , 'header' => 'main_header', 'footer' => 'main_footer');
        
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
    * Deel van de pagina veranderen via ajax
    */
    public function loadFotosAjax() {
        
        $personeelsfeestId = $this->input->get('personeelsfeestId');
        
        $this->load->model('Foto_model');
        $data['fotos'] = $this->Foto_model->getAlleFotosZoalsPersoneelsfeestId($personeelsfeestId);
        
        $this->load->view('Fotos beheren/fotosBeherenAjax', $data);
    }
    
    /**
    * Functie oproepen waarmee je de gekozen foto in de folder en database zet.
    * Error en de configuratie worden hier ook meegedeeld
    */
    public function do_upload()
        {
                $config['upload_path']          = './assets/images/';
                $config['allowed_types']        = 'jpg|png';
            //    $config['max_size']             = 100;
            //    $config['max_width']            = 1920;
            //    $config['max_height']           = 1080;

                $this->load->library('upload', $config);

                /**
                * Error melding geven wanneer er iets fout gaat
                */
                if (!$this->upload->do_upload('userfile'))
                {
                    $error = $this->upload->display_errors('','');

                    $this->index($error);
                }else {
                   /**
                    * upload in database en in de folder
                   */
                   $info = new stdClass();

                   $info->foto = $this->upload->data('file_name');

                   $this->load->model('Personeelsfeest_model');
                   $personeelsfeestId = $this->Personeelsfeest_model->getLaatstePersoneelsfeest();
                   $info->personeelsfeestId = $personeelsfeestId->id;

                   $this->load->model('CRUD_Model');
                   $this->CRUD_Model->add($info, 'foto');
                   
                   redirect('Organisator/FotosBeheren/index');                                      
                }
        }
        
        /**
        * Functie oproepen waarmee je de gekozen foto uit de database en folder verwijderd
        */
         public function delete_image()
        {
            $id = $this->input->get('id');

            $this->load->model('CRUD_Model');               
            /**
            * Verwijder afbeelding uit de folder
            */
            $afbeelding = $this->CRUD_Model->get($id, 'foto');
            $naam = $afbeelding->foto;
            unlink("assets/images/".$naam);
            /**
            * Verwijder afbeelding uit de database
            */
            $this->CRUD_Model->delete($id, 'foto');           
            
            redirect('Organisator/FotosBeheren/index');
        }
} 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
