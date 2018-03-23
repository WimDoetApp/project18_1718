<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class Personeelsfeest_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * nog niet gebruikt 
     */
    
    function getLaatsteId()
    {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('personeelsfeest');
        return $query->result();                
    }   
}


