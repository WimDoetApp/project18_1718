<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class Locatie_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('personeelsfeest_locatie');
        return $query->row();
    }
    
    function getAllByNaam(){
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('personeelsfeest_locatie');
        return $query->result();
    }
}


