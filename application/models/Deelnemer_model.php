<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class Deelnemer_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Alle personeelsleden ophalen
     * @param int $personeelsfeestId (id van het huidige personeelsfeest)
     * @return type
     */ 
    function getAllPersoneelsleden($personeelsfeestId)
    {
        $this->db->where('personeelsfeestId', $personeelsfeestId);
        $this->db->where("(soortId='2' OR soortId='3')");
        $query = $this->db->get('personeelsfeest_deelnemer');
        return $query->result();
    }
    
    /**
     * Deelnemer aanpassen
     * @param type $deelnemer
     */
    function update($deelnemer)
    {
        $this->db->where('id', $deelnemer->id);
        $this->db->update('personeelsfeest_deelnemer', $deelnemer);
    }
}


