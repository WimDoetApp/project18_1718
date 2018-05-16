<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class Taak_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function getAllByDagOnderdeel($id) {
        $this->db->where('dagOnderdeelId', $id);
        $query = $this->db->get('taak');
        return $query->result();
    }
    
    function getAllByoptieId($id) {
        $this->db->where('optieId', $id);
        $query = $this->db->get('taak');
        return $query->result();
    }
    
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
    
    function get($id){
        $this->db->where('id', $id);
        $query = $this->db->get('taak');
        return $query->row();
    }
    
    //TAAK-PIPELINE Taak<-TaakShift<-HelperTaak
    //Vraagt alle deelnemers op van een bepaalde taak en stuurt alleen de deelnemerIds en shiftIds door
    
    //pl_Taak heeft als: parent:: none, child:: pl_TaakShift
    //pl_TaakShift($taakId):: $taakId (INTEGER) - verwijst naar de id van de taak
    
    //Om deze functie te gebruiken in een andere controller gebruik:: <<START>>
    //$taak = new Taak();
    //...
    //$[VARIABELE] = $taak->pl_Taak(taakId); <<END>>
    
    //RETURN WAARDES: deelnamers['INTEGER' => 'ARRAY', (...), 'id' => 'ARRAY2']
                //INTEGER:: ID van de SHIFT
                //ARRAY:: ARRAY van DEELNEMER IDs die bij de SHIFT horen
                //ARRAY2:: ARRAY van SHIFT IDs in de volgorde van DEELNEMER IDs arrays
    public function pl_Taak($taakId) {
        //return Array
        $deelnemers = array();
        //variabelen
        $shiften = array();
        
        $this->load->model('CRUD_Model');
        
        //Vraag alle shiften op die bij taakId horen
        $shiftenB = $this->CRUD_Model->getAllByColumn($taakId, 'taakShift', 'taakId');
        
        //Steek alle shiftIds in de shiften array
        foreach ($shiftenB as $shiftB) {
            array_push($shiften, $shiftB);
        }
        
        //Vraag alle deelnemers op bij elke shiftId
        $this->load->model('TaakShift_model');
        
        foreach ($shiften as $shift) {
            $deelnemers[$shift->id] = $this->TaakShift_model->pl_TaakShift($shift->id);
        }
        
        //Steek alle shiftIds in de return array
        $deelnemers['id'] = $shiften;
        
        return $deelnemers;
    }
    
    public function pl_TaakDelete($taakId) {
        $this->load->model('CRUD_Model');
        
        $shiften = $this->CRUD_Model->getAllByColumn($taakId, 'taakShift', 'taakId');
        
        $this->load->model('TaakShift_model');
        
        foreach ($shiften as $shift) {
            $this->TaakShift_model->pl_TaakShiftDelete($shift->id);
        }
    }
}


