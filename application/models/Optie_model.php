<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class Optie_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    /**
    * id ophalen van optie
    */
    function get($id) 
    {
        $this->db->where('id', $id);
        $query = $this->db->get('optie');
        return $query->row();  
    }
    /**
    * Zorgen dat je de data in optie kan sturen
    */
    function insert($info)
    {
        $this->db->insert('optie', $info);
        return $this->db->insert_id();
    }
    
    function getAllByDagOnderdeel($dagOnderdeelId){
        $this->db->where('dagOnderdeelId', $dagOnderdeelId);
        $query = $this->db->get('optie');
        $opties = $query->result();
        
        /**
         * Per optie ophalen hoeveel mensen er zijn ingeschreven
         */
        $gebruiker = $this->authex->getDeelnemerInfo();
        $this->load->model('InschrijvingsOptie_model');
        foreach($opties as $optie){
            $optie->aantalIngeschreven = $this->InschrijvingsOptie_model->countInschrijvingenByOptie($optie->id);
            
            /**
             * Checken of de gebruiker al is ingeschreven voor een optie
             */
            $isAlIngeschreven = $this->InschrijvingsOptie_model->isAlIngeschreven($gebruiker->id, $optie->id);
            
            if(!empty($isAlIngeschreven)){
                $optie->isAllIngeschreven = true;
                $optie->commentaar = $isAlIngeschreven[0]->commentaar;
            }else{
                $optie->isAllIngeschreven = false;
            }
        }
        
        return $opties;
    }
    
    function getAllByDagOnderdeelWithTaken($dagOnderdeelId){
        $this->db->where('dagOnderdeelId', $dagOnderdeelId);
        $query = $this->db->get('optie');
        $opties = $query->result();
        
        /**
         * Per optie ophalen hoeveel mensen er zijn ingeschreven
         */
        $this->model->load('Taak_model');
        foreach($opties as $optie){
            $optie->taak = $this->Taak_model->getAllByOptieIdWithShiften($optie->id);
        }
    }
    
    function getAllByIds($ids) {
        //aanmaken tussen array
        $titels = array();
        
        //ophalen alle titels
        foreach ($ids as $id) {
            $this->load->model('CRUD_Model');
            $titel = $this->CRUD_Model->get($id, 'optie');
            array_push($titels, $titel->naam);
        }
        
        return $titels;
    }
}


