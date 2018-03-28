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
        return $this->db->select('id')->order_by('id',"desc")->limit(1)->get('personeelsfeest')->row();
    }   
}


