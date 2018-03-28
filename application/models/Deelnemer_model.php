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
     * Haalt een specifieke deelnemer op
     * @param $id het id van de deelnemer
     * @return deelnemer
     */
    function get($id) 
    {
        $this->db->where('id', $id);
        $query = $this->db->get('deelnemer');
        return $query->row();  
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
    
    /**
     * Een bepaalde deelnemer uit de databank halen aan de hand van zijn emailadres (om in te loggen)
     * @param $email email van de gebruiker
     * @param $wachtwoord wachtwoord van de gebruiker
     * @param $personeelsfeestId id van het huidige personeelsfeest
     * @return deelnemer
     */
    function getDeelnemer($email, $wachtwoord, $personeelsfeestId) {
        $this->db->where('email', $email);
        $this->db->where('personeelsfeestId', $personeelsfeestId);
        $query = $this->db->get('deelnemer');
        
        if ($query->num_rows() == 1) {
            $deelnemer = $query->row();

            if ($wachtwoord == $deelnemer->wachtwoord ){  //password_verify($wachtwoord, $deelnemer->wachtwoord)
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
    function insert($deelnemer)
    {
        $this->db->insert('deelnemer', $deelnemer);
        return $this->db->insert_id();
    }
}


