<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 * @class Soort_model
 */

class Soort_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Zoek de gebruiker met het gewenste id
     * @param $id het id waarvan je de soort wilt verkrijgen
     * @return de soort waarvan het id overeenkomt met het gevraagde id
     */
    function get($id){
        $this->db->where('id', $id);
        $query = $this->db->get('soort');
        return $query->row();
    }
}


