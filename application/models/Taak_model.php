<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class Taak_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function getAllByDagOnderdeel($id) {
        $this->db->where('dagOnderdeelId', $id);
        $query = $this->db->get('taak');
        return $query->result();
    }
    
    function getAllByoptieId($id) {
        $this->db->where('optieId', $id);
        $query = $this->db->get('taak');
        return $query->result();
    }
    
    function getAllByOptieIdWithShiften($optieId){
        $this->db->where('optieId', $optieId);
        $query = $this->db->get('taak');
        $taken = $query->result();
        
        $this->load->model('TaakShift_model');
        foreach($taken as $taak){
            $taak->shiften = $this->TaakShift_model->getAllByTaak($taak->id);
        }
        
        return $taken;
    }
    
    function getAllByDagonderDeelWithShiften($dagonderdeelId){
        $this->db->where('dagOnderdeelId', $dagonderdeelId);
        $query = $this->db->get('taak');
        $taken = $query->result();
        
        $this->load->model('TaakShift_model');
        foreach($taken as $taak){
            $taak->shiften = $this->TaakShift_model->getAllByTaak($taak->id);
        }
        
        return $taken;
    }
}


