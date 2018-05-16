<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 * @class Foto_model
 */

class Foto_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    /**
    * Zoek de waarde die overeenkomt met personeelsfeestId uit de tabel 'foto'
     * @param $personeelsfeestId het id van het gewenste personeelsfeest
     * @return alle fotos waarbij het personeelsfeestId gelijk is aan het gewenste personeelfeestId
    */
    function getAlleFotosZoalsPersoneelsfeestId($personeelsfeestId)
    {
        $this->db->where('personeelsfeestId', $personeelsfeestId);
        $query = $this->db->get('foto');
        return $query->result();
    }
}


