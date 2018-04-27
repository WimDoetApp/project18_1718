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
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        
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
        $data['jaartallen'] = $this->CRUD_Model->getAll('personeelsfeest');

        $partials = array('inhoud' => 'Fotos beheren/fotosBeheren' , 'header' => 'main_header', 'footer' => 'main_footer');
        $error = array('error' => ' ' );
        $this->template->load('main_master', $partials, $data, $error);
    }
    
    public function loadFotosAjax() {
        
        $personeelsfeestId = $this->input->get('personeelsfeestId');
        
        $this->load->model('Foto_model');
        $data['fotos'] = $this->Foto_model->getAlleFotosZoalsPersoneelsfeestId($personeelsfeestId);
        
        $this->load->view('Fotos beheren/fotosBeherenAjax', $data);
    }
    
     public function do_upload()
        {
                $config['upload_path']          = './assets/images/';
                $config['allowed_types']        = 'jpg|png';
            //    $config['max_size']             = 100;
            //    $config['max_width']            = 1920;
            //    $config['max_height']           = 1080;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    
                    redirect('Organisator/FotosBeheren/index', $error);
                }   
                else
                {
                   $data = array('upload_data' => $this->upload->data());
                  
                   /**
                    * upload in database
                   */
                   $info = new stdClass();

                   $info->foto = $this->input->post('userfile');

                   $this->load->model('Personeelsfeest_model');
                   $personeelsfeestId = $this->Personeelsfeest_model->getLaatstePersoneelsfeest();
                   $info->personeelsfeestId = $personeelsfeestId->id;

                   $this->load->model('CRUD_Model');
                   $id = $this->CRUD_Model->add($info, 'foto');
                   
                   redirect('Organisator/FotosBeheren/index', $data);
                }
        }
        
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
