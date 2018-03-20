<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class OrganisatorenBeheren extends CI_Controller {

    // +----------------------------------------------------------
    // | Personeelsfeest
    // +----------------------------------------------------------
    // | Organisatoren controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------


    public function __construct() {
        parent::__construct();
        
        $this->load->helper('form');
    }
    
    /**
     * Ophalen lijst van alle personeelsleden
     * @param $personeelsfeestId id van het huidige personeelsfeest
     */
    public function toonPersoneelsleden($personeelsfeestId){
        $data['titel']  = 'Organisatoren beheren';
        $data['personeelsfeest'] = $personeelsfeestId;
        
        $this->load->model('deelnemer_model');
        
        $data['personeelsleden'] = $this->deelnemer_model->getAllPersoneelsleden($personeelsfeestId);
        
        $partials = array('inhoud' => 'organisatorenbeheren/organisatoren', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Personeelslid veranderen in organisator of terug in personeelslid veranderen
     */
    public function wijzig(){
        /**
         * declareren variabelen
         */
        $personeelsfeestId = $this->input->post('personeelsfeestId');
        $this->load->model('deelnemer_model');        
        /**
         * deelnemer wegschrijven
         */
        $ids = $this->input->post("ids");
        
        foreach($ids as $id){
            $personeelslid = new stdClass();
            
            $personeelslid->id = $id;
            $soortId = $this->input->post("organisator[$id]");
            
            if ($soortId == "") {
                $personeelslid->soortId = 2;
            }else{
                $personeelslid->soortId = 3;
            }
            
            $this->deelnemer_model->update($personeelslid);
        }
        
        /**
         * Teruggaan naar de pagina om organisatoren te beheren
         */
        $this->toonPersoneelsleden($personeelsfeestId); 
    }
}