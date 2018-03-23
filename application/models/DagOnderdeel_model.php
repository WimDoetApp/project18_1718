<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 * Verantwoordelijke: Wim Naudts
 */

class DagOnderdeel_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }

     /**
     * Haalt een dagonderdeel met een bepaald id op.
     * @param $id id van het dagonderdeel
     * @return het opgevraagde record
     */
    function get($id) 
    {
        $this->db->where('id', $id);
        $query = $this->db->get('dagonderdeel');
        return $query->row();  
    }
    /**
    * alle namen van dagonderdeel ophalen 
    */
    function getAllesBijDagonderdeel()
    {
        $this->db->select('*');
        $this->db->group_by('naam');
        
        $query = $this->db->get('dagonderdeel');
        return $query->result();                
    }
    /**
     * Haalt alle dagonderdelen op, met bijhorende locaties, gesorteerd op starttijd.
     * @param $personeelsfeestId id van het huidige personeelsfeest
     * @return de opgevraagde records
     */
    function getAllByStartTijd($personeelsfeestId)
    {
        $this->db->where('personeelsfeestId', $personeelsfeestId);
        $this->db->order_by('starttijd', 'asc');
        $query = $this->db->get('dagonderdeel');
        return $query->result();
    }
    
    /**
     * (leeg) dagonderdeel toevoegen
     * @param $dagonderdeel dagonderdeel dat we gaan toevoegen
     * @return het id van hat record dat toegevoegd is
     */
    function insert($dagonderdeel)
    {
        $this->db->insert('dagonderdeel', $dagonderdeel);
        return $this->db->insert_id();
    }
    
    /**
     * Dagonderdeel aanpassen
     * @param $dagonderdeel dagonderdeel dat we gaan aanpassen
     */
    function update($dagonderdeel)
    {
        $this->db->where('id', $dagonderdeel->id);
        $this->db->update('dagonderdeel', $dagonderdeel);
    }
    
    /**
     * Dagonderdeel verwijderen
     * @param $id id van het dagonderdeel dat we willen verwijderen
     */
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('dagonderdeel');
    }
}


