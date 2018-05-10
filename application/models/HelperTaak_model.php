<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class HelperTaak_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function countAllTaak($id) {
        $this->db->where('id',$id);
        $query = $this->db->count_all_results('helperTaak');
        return $query;
    }
    
    function countAllShift($id) {
        $this->db->where('taakShiftId',$id);
        $query = $this->db->count_all_results('helperTaak');
        return $query;
    }
    
    /**
     * Helper bij een bepaalde shift vinden
     * @param $deelnemerId id van de helper
     * @return de taken waarvoor deze vrijwilliger is
     */
    function getByDeelnemerWithTaakShift($deelnemerId){
        $this->db->where('deelnemerId', $deelnemerId);
        $query = $this->db->get('helperTaak');
        $helperTaken = $query->result();
        
        $this->load->model('TaakShift_model');
        foreach($helperTaken as $helperTaak){
            $helperTaak->taakShift = $this->TaakShift_model->getWithTaak($helperTaak->taakShiftId);
        }
        
        return $helperTaken;
    }
    
    function getAllWithTaakAndDeelnemer() {
        $query = $this->db->get('helperTaak');
        $helperTaken = $query->result();
        
        $this->load->model('TaakShift_model');
        $this->load->model('Deelnemer_model');
        
        foreach($helperTaken as $helperTaak) {
            $helperTaak->deelnemer = $this->Deelnemer_model->get($helperTaak->deelnemerId);
            $helperTaak->taakShift = $this->TaakShift_model->getWithTaken($helperTaak->taakShiftId);
        }
        
        return $helperTaken;
    }
}


