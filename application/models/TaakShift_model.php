<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class TaakShift_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function getEersteTijd($id) {
        $this->db->select_min('begintijd');
        $this->db->where('taakId', $id);
        $query = $this->db->get('taakShift');
        return $query->row();
    }
    
    function getLaatsteTijd($id) {
        $this->db->select_max('eindtijd');
        $this->db->where('taakId', $id);
        $query = $this->db->get('taakShift');
        return $query->row();
    }
    
    function getSUM($id) {
        $this->db->where('taakId', $id);
        $this->db->select_sum('aantalPlaatsen');
        $query = $this->db->get('taakShift');
        return $query->row();
    }
    
<<<<<<< HEAD
    function getAllByTaak($taakId){
        $this->db->where('taakId', $taakId);
        $query = $this->db->get('taakShift');
        $taakShiften = $query->result();
        
        $this->load->model('HelperTaak_model');
        foreach($taakShiften as $taakShift){
            $taakShift->aantalIngeschreven = $this->HelperTaak_model->countAllShift($taakShift->id);
        }
        
        return $taakShiften;
=======
    function getAllByTaakId($id) {
        $this->db->where('taakId', $id);
        $query = $this->db->get('taakShift');
        return $query->result();
>>>>>>> ???
    }
}


