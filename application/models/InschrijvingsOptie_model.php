<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class InschrijvingsOptie_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function countInschrijvingenByOptie($optieId){
        $this->db->where('optieId', $optieId);
        return $this->db->count_all_results('inschrijfOptie');
    }
}


