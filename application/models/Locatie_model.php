<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class Locatie_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    /**
    * id ophalen van locatie
    */
    function get($id) 
    {
        $this->db->where('id', $id);
        $query = $this->db->get('personeelsfeest_locatie');
        return $query->row();  
    }
    /**
    * alle namen van locaties ophalen 
    */
    function getAllesBijLocatie()
    {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('personeelsfeest_locatie');
        return $query->result();                
    }
}
