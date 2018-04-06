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
    }
    
    /**
    * 
    */
    public function index() {
        $data['titel']  = "Foto's beheren";

        $this->load->model('CRUD_Model');
        $data['jaartallen'] = $this->CRUD_Model->getAll('personeelsfeest');
        
        $this->load->model('CRUD_Model');
        $data['fotos'] = $this->CRUD_Model->getAll('foto');

        $partials = array('inhoud' => 'Fotos beheren/fotosBeheren' , 'header' => 'main_header', 'footer' => 'main_footer');
        $error = array('error' => ' ' );
        $this->template->load('main_master', $partials, $data, $error);
    }
    
     public function do_upload()
        {
                $config['upload_path']          = './assets/images/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1920;
                $config['max_height']           = 1080;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    
                    redirect('FotosBeheren/index', $error);
                }   
                else
                {
                    $data = array('upload_data' => $this->upload->data());

                    redirect('FotosBeheren/index', $data);
                }
        }
} 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
