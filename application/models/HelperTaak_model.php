<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class HelperTaak_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function countAllTaak($id) {
        $this->db->where('id',$id);
        $query = $this->db->count_all_results('helperTaak');
        return $query->row();
    }
    
    function countAllShift($id) {
        $this->db->where('id',$id);
        $query = $this->db->count_all_results('helperTaak');
        return $query->row();
    }
}


