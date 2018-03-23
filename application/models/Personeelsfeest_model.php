<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class Personeelsfeest_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    function getLaatstePersoneelsfeest()
    {
        $this->db->select('*');
        $this->db->from('personeelsfeest');
        $this->db->where('id=(SELECT max(id) FROM personeelsfeest)');
        $query = $this->db->get();
        return $query->row();
    }
    
    function getAllesVanPersoneelsfeest()
    {
        $this->db->select('*');
        $this->db->from('personeelsfeest');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getJarenPersoneelsfeest() 
    {
        $this->db->select('id, YEAR(datum) as Jaar, inschrijfDeadline');
        $this->db->from('personeelsfeest');
        $query = $this->db->get();
        return $query->result();
    }

    function insertPersoneelsfeest($personeelsfeest)
    {
        $this->db->insert('personeelsfeest', $personeelsfeest);
        return $this->db->insert_id();
    }

    function insertDagonderdeel($dagonderdelen)
    {
        $this->db->insert('personeelsfeest', $dagonderdelen);
        return $this->db->insert_id();
    }

    function insertOrganisatoren($ids)
    {
        $this->db->insert('personeelsfeest', $personeelsfeest);
        return $this->db->insert_id();
    }

    function insertTaken($taken)
    {
        $this->db->insert('personeelsfeest', $taken);
        return $this->db->insert_id();
    }
    function getDagonderdelenVanPersoneelsfeest($id)
    {
        $this->db->where('personeelsfeestId', $id);
        $query = $this->db->get('dagonderdeel');
        return $query->row();
    }
}


