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
     * Haalt een dagonderdeel met een bepaald id op.
     * @param type $id
     * @return type
     */
    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('personeelsfeest_dagonderdeel');
        return $query->row();
    }
    
    /**
     * Haalt alle dagonderdelen op, met bijhorende locaties, gesorteerd op starttijd.
     * @param int $personeelsfeestId (id van het huidige personeelsfeest)
     */
    function getAllByStartTijd($personeelsfeestId)
    {
        $this->db->where('personeelsfeestId', $personeelsfeestId);
        $this->db->order_by('starttijd', 'asc');
        $query = $this->db->get('personeelsfeest_dagonderdeel');
        return $query->result();
    }
    
    /**
     * (leeg) dagonderdeel toevoegen
     * @param type $dagonderdeel
     * @return type
     */
    function insert($dagonderdeel)
    {
        $this->db->insert('personeelsfeest_dagonderdeel', $dagonderdeel);
        return $this->db->insert_id();
    }
    
    /**
     * Dagonderdeel aanpassen
     * @param int $dagonderdeel
     */
    function update($dagonderdeel)
    {
        $this->db->where('id', $dagonderdeel->id);
        $this->db->update('personeelsfeest_dagonderdeel', $dagonderdeel);
    }
    
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('personeelsfeest_dagonderdeel');
    }
}


