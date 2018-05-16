<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 * @class TaakShift_model
 */

class TaakShift_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Geeft de shift met bijhorende taak weer
     * @param $id het id van de gewenste shift
     * @return de shift met bijhorende taak
     */
    function getWithTaak($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('taakShift');
        $taakShift = $query->row();

        $this->load->model('Taak_model');
        $taakShift->taak = $this->Taak_model->get($taakShift->taakId);

        return $taakShift;
    }

    /**
     * Geeft shift weer waarbij de begintijd het laagste is en de taakId gelijk is aan de gevraagde taakId
     * @param $id de gevraagde taakId
     * @return de shift met de eerste begintijd waarvan de taakId gelijk is aan de gewenste taakId
     */
    function getEersteTijd($id)
    {
        $this->db->select_min('begintijd');
        $this->db->where('taakId', $id);
        $query = $this->db->get('taakShift');
        return $query->row();
    }

    /**
     * Geeft shift weer waarbij de eindtijd het hoogste is en de taakId gelijk is aan de gevraagde taakId
     * @param $id de gevraagde taakId
     * @return de shift met de laatste eindtijd waarvan de taakId gelijk is aan de gewenste taakId
     */
    function getLaatsteTijd($id)
    {
        $this->db->select_max('eindtijd');
        $this->db->where('taakId', $id);
        $query = $this->db->get('taakShift');
        return $query->row();
    }

    /**
     * Geeft de som van het aantal plaatsen van de verschillende shiften per taak weer
     * @param $id het id van de taak waarvan je de som van het aantal plaatsen van de shiften van wilt weten
     * @return de som van het aantal plaatsen van de shiften van de taak waarvan het id gelijk is aan het gewenste id
     */
    function getSUM($id)
    {
        $this->db->where('taakId', $id);
        $this->db->select_sum('aantalPlaatsen');
        $query = $this->db->get('taakShift');
        return $query->row();
    }

    /**
     * Geeft alle shiften weer waarvan het id overeenkomt met het gevraagde id
     * @param $id het gewenste taakid
     * @return alle shiften waarvan het taakId gelijk is aan het gewenste id
     */
    function getAllByTaakId($id)
    {
        $this->db->where('taakId', $id);
        $query = $this->db->get('taakShift');
        return $query->result();
    }

    /**
     * geef alle shiften met bijhorende taken weer
     * @param $id het id van de gewenste taakshift
     * @return alle shiften met bijhorende taken
     */
    function getWithTaken($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('taakShift');
        $taakShift = $query->row();


        $this->load->model('CRUD_Model');
        $taakShift->taak = $this->CRUD_Model->get($taakShift->taakId, 'taak');

        $this->load->model('Taak_model');
        $taakShift->taak = $this->Taak_model->get($taakShift->taakId);


        return $taakShift;
    }

    /**
     * Geeft alle taakshiften met hun overeenkomstige taken weer waar het taakId gelijk is aan het gewenste taakId
     * @param $taakId het gewenste taakId
     * @return alle taakshiften met overeenkomstige taken waarvan het taakId gelijk is aan het gewenste taakId
     */
    function getAllByTaak($taakId)
    {
        $this->db->where('taakId', $taakId);
        $query = $this->db->get('taakShift');
        $taakShiften = $query->result();

        $this->load->model('HelperTaak_model');
        foreach ($taakShiften as $taakShift) {
            $taakShift->aantalIngeschreven = $this->HelperTaak_model->countAllShift($taakShift->id);
        }

        return $taakShiften;
    }
    
    //TAAK-PIPELINE Taak<-TaakShift<-HelperTaak
    //Vraagt alle deelnemers op van een bepaalde shift en stuurt alleen de deelnemerIds door
   
    //pl_TaakShift heeft als: parent:: pl_Taak, child:: none
    //pl_TaakShift($shiftId):: $shiftId (INTEGER) - verwijst naar de id van de shift
    
    //Om deze functie te gebruiken in een andere controller gebruik:: <<START>>
    //$taakShift = new TaakShift();
    //...
    //$[VARIABELE] = $taakShift->pl_TaakShift($shiftId) <<END>>
    
    //RETURN WAARDES: helper['INTEGER', (...)] - [INTERGER]:: deelnemer Id
    public function pl_TaakShift($shiftId) {
        //Return array
        $helpers = Array();
        
        $this->load->model('CRUD_Model');
        
        $shiftHelpers = $this->CRUD_Model->getAllByColumn($shiftId, 'helperTaak', 'taakShiftId');
        
        //DeelnemerIds in return array zetten
        foreach ($shiftHelpers as $shiftRow) {
            array_push($helpers, $shiftRow->deelnemerId);
        }
        
        return $helpers;
    }
    
    public function pl_TaakShiftDelete($shiftId) {
        $this->load->model('CRUD_Model');
        
        $shiftHelpers = $this->CRUD_Model->getAllByColumn($shiftId, 'helperTaak', 'taakShiftId');
        
        foreach ($shiftHelpers as $shiftHelper) {
            $this->CRUD_Model->delete($shiftHelper->id, 'helperTaak');
        }
    }
}


