<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 * @class EmailSjabloon_model
 */

class EmailSjabloon_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function get($id) 
    {
        $this->db->where('id', $id);
        $query = $this->db->get('emailsjabloon');
        return $query->row();  
    }
}


