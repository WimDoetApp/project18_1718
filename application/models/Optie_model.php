<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class Optie_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    /**
    * id ophalen van optie
    */
    function get($id) 
    {
        $this->db->where('id', $id);
        $query = $this->db->get('optie');
        return $query->row();  
    }
    /**
     * Naam ophalen aan de hand van dagOnderdeelId
     */
    function getOptieDagOnderdeelId($dagOnderdeelId) {
        $this->db->where('dagOnderdeelId', $dagOnderdeelId);
        $query = $this->db->get('optie');
        return $query->result();
    }

    /**
    * Zorgen dat je de data in optie kan sturen
    */
    function insert($info)
    {
        $this->db->insert('optie', $info);
        return $this->db->insert_id();
    }
}


