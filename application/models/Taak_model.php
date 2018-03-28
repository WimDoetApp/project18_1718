<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class Taak_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function getAll() {
        $query = $this->db->get('taak');
        return $query->results();
    }
    
    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('taak');
        return $query->row();
    }
    
    function getAllByDagOnderdeel($id) {
        $this->db->where('dagOnderdeelId', $id);
        $query = $this->db->get('taak');
        return $query->results();
    }
    
    function getAllByoptieId($id) {
        $this->db->where('optieId', $id);
        $query = $this->db->get('taak');
        return $query->results();
    }
    
    function add($taak) {
        $this->db->insert('taak', $taak);
    }
    
    function delete($id) {
        $this->db->where('id', id);
        $this->db->delete('taak');
    }
}


