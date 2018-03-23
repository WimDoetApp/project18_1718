<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class DagOnderdeel_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    /**
    * id ophalen van dagonderdeel
    */
    function get($id) 
    {
        $this->db->where('id', $id);
        $query = $this->db->get('personeelsfeest_dagonderdeel');
        return $query->row();  
    }
    /**
    * alle namen van dagonderdeel ophalen 
    */
    function getAllesBijDagonderdeel()
    {
        $this->db->select('*');
        $this->db->group_by('naam');
        
        $query = $this->db->get('personeelsfeest_dagonderdeel');
        return $query->result();                
    }
}


