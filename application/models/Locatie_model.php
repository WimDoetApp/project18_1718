<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class Locatie_model extends CI_Model {
    /*Alle volgende methodes haalt op/wijzigd records van de Tabel: personeelsfeest_Locatie*/
    
    function __construct()
    {
        parent::__construct();
    }
    /**
    * alle namen van locaties ophalen 
    */
    function getAllesBijLocatie()
    {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('locatie');
        return $query->result();                
    }
}