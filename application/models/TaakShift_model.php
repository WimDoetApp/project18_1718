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
        $this->db->where('taakId', $id);
        $this->db->select_min('begintijd');
        $query = $this->db->get('taakShift');
        return $query->row();
    }
    
    function getLaatsteTijd($id) {
        $this->db->where('taakId', $id);
        $this->db->select_max('eindtijd');
        $query = $this->db->get('taakShift');
        return $query->row();
    }
    
    function getEEL($id) {
        $tijd = null;
        $tijd->begin = $this->getEersteTijd($id);
        $tijd->einde = $this->getLaatsteTijd($id);
        return $tijd;
    }
    
    function getSUM($id) {
        $this->db->where('taakId', 'id');
        $this->db->select_sum('aantalPLaatsen');
        $query = $this->db->get('taakShift');
        return $query->row();
    }
}


