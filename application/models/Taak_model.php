<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 * @class Taak_model
 */

class Taak_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Alle taken opvragen aan de hand van een dagonderdeel
     * @param $id het id van het dagonderdeel waaraan alle taken moeten voldoen
     * @return alle taken waarbij het dagonderdeel overeenkomt met het gevraagde dagonderdeel
     */
    function getAllByDagOnderdeel($id) {
        $this->db->where('dagOnderdeelId', $id);
        $query = $this->db->get('taak');
        return $query->result();
    }

    /**
     * Alle taken waarbij het optieId gelijk is aan het gevraagde optieId
     * @param $id het gevraagde optieId
     * @return alle taken waarbij het optieId overeenkomt met het gevraagde optieId
     */
    function getAllByoptieId($id) {
        $this->db->where('optieId', $id);
        $query = $this->db->get('taak');
        return $query->result();
    }

    /**
     * Alle taken met bijhorende shiften waarbij het optieId gelijk is aan het gevraagde optieId
     * @param $optieId het gevraagde optieId
     * @return alle taken met bijhorende shiften waarbij het optieId overeenkomt met het gevraagde optieId
     */
    function getAllByOptieIdWithShiften($optieId){
        $this->db->where('optieId', $optieId);
        $query = $this->db->get('taak');
        $taken = $query->result();
        
        $this->load->model('TaakShift_model');
        foreach($taken as $taak){
            $taak->shiften = $this->TaakShift_model->getAllByTaak($taak->id);
        }
        
        return $taken;
    }

    /**
     * Alle taken met bijhorende shiften waarbij het dagonderdeelId gelijk is aan het gevraagde dagonderdeelId
     * @param $dagonderdeelId het gevraagde dagonderdeelId
     * @return alle taken met bijhorende shiften waarbij het dagonderdeelId overeenkomt met het gevraagde dagonderdeelId
     */
    function getAllByDagonderDeelWithShiften($dagonderdeelId){
        $this->db->where('dagOnderdeelId', $dagonderdeelId);
        $query = $this->db->get('taak');
        $taken = $query->result();
        
        $this->load->model('TaakShift_model');
        foreach($taken as $taak){
            $taak->shiften = $this->TaakShift_model->getAllByTaak($taak->id);
        }

        return $taken;
    }

    /**
     * De taak waarvan het id overeenkomt met het gevraagde id
     * @param $id het gevraagde id
     * @return de taak waarvan het id gelijk is aan het gevraagde id
     */
    function get($id){
        $this->db->where('id', $id);
        $query = $this->db->get('taak');
        return $query->row();
    }
}


