<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class TaakShift_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function getAll() {
        $query = $this->db->get('taakShift');
        return $query->results();
    }
    
    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('taakShift');
        return $query->row();
    }
    
    function getEersteTijd($id) {
        $this->db->where('id', $id);
        $this->db->select_min('begintijd');
        $query = $this->db->get('taakShift');
        return $query->row();
    }
    
    function getLaatsteTijd($id) {
        $this->db->where('id', $id);
        $this->db->select_max('eindtijd');
        $query = $this->db->get('taakShift');
        return $query->row();
    }
    
    function getEEL($id) {
        $tijd->begin = $this->getEersteTijd($id);
        $tijd->einde = $this->getLaatsteTijd($id);
        return $tijd;
    }
    
    function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('locatie', $data);
    }
}


