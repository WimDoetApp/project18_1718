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
}


