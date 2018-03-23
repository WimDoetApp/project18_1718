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
     * @param $personeelsfeestId id van het huidige personeelsfeest
     * @return de opgevraagde records
     */ 
    function getAllPersoneelsleden($personeelsfeestId)
    {
        $this->db->where('personeelsfeestId', $personeelsfeestId);
        $this->db->where("(soortId='2' OR soortId='3')");
        $query = $this->db->get('deelnemer');
        return $query->result();
    }
    
    /**
     * Deelnemer aanpassen
     * @param $deelnemer de deelnemer die we willen aanpassen
     */
    function update($deelnemer)
    {
        $this->db->where('id', $deelnemer->id);
        $this->db->update('deelnemer', $deelnemer);
    }
    
    function getDeelnemer($email, $wachtwoord) {
        $this->db->where('email', $email);
        $query = $this->db->get('deelnemer');
        
        if ($query->num_rows() == 1) {
            $deelnemer = $query->row();

            if (password_verify($wachtwoord, $deelnemer->wachtwoord)) {
                return $deelnemer;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    
    /**
     * Jari - nieuwe gegevens in deelnemers zetten
     */
    function insert($info)
    {
        $this->db->insert('deelnemer', $info);
        return $this->db->insert_id();
    }
}


