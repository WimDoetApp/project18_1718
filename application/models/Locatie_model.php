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
    
    function getAll() {
        /*Haal alle records op*/
        $query = $this->db->get('personeelsfeest_Locatie');
        return $query->result();
    }
    
    function update($id, $data) {
        /*Wijzig een record met het id ($id), met de data die moet gewijzigd worden ($data[ArrayList])*/
        $this->db->where('id', $id);
        $this->db->update('personeelsfeest_Locatie', $data);
    }
    
    function delete($id) {
        /*Verwijderd een record met het id ($id)*/
        $this->db->where('id', $id);
        $this->db->delete('personeelsfeest_Locatie');
    }
    
    function add($locatie) {
        /*Voegt een nieuwe (lege) record toe*/
        $this->db->insert('personeelsfeest_Locatie', $locatie);
    }
}