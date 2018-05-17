<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 * @class HelperTaak_model
 */

class HelperTaak_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Alle taken tellen
     * @param $id id van de taak die geteld moet worden
     * @return het aantal taken met de bepaalde id
     */
    function countAllTaak($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->count_all_results('helperTaak');
        return $query;
    }

    /**
     * Alle shiften tellen
     * @param $id id van de shift die geteld moet worden
     * @return het aantal shiften met de bepaalde id
     */
    function countAllShift($id)
    {
        $this->db->where('taakShiftId', $id);
        $query = $this->db->count_all_results('helperTaak');
        return $query;
    }

    /**
     * Helper bij een bepaalde shift vinden
     * @param $deelnemerId id van de helper
     * @return de taken waarvoor deze vrijwilliger is
     */
    function getByDeelnemerWithTaakShift($deelnemerId)
    {
        $this->db->where('deelnemerId', $deelnemerId);
        $query = $this->db->get('helperTaak');
        $helperTaken = $query->result();

        $this->load->model('TaakShift_model');
        foreach ($helperTaken as $helperTaak) {
            $helperTaak->taakShift = $this->TaakShift_model->getWithTaak($helperTaak->taakShiftId);
        }

        return $helperTaken;
    }

    /**
     * Alles uit de tabel ophalen met de bijhorende taak en deelnemer
     * @return Alles met bijhorende info over de taak en deelnemer
     */
    function getAllWithTaakAndDeelnemer()
    {
        $query = $this->db->get('helperTaak');
        $helperTaken = $query->result();

        $this->load->model('TaakShift_model');
        $this->load->model('Deelnemer_model');

        foreach ($helperTaken as $helperTaak) {
            $helperTaak->deelnemer = $this->Deelnemer_model->get($helperTaak->deelnemerId);
            $helperTaak->taakShift = $this->TaakShift_model->getWithTaken($helperTaak->taakShiftId);
        }

        return $helperTaken;
    }

    /**
     * Alle taken ophalen waar de deelnemer de gevraagde deelnemerId heeft en de taakshift het gevraagde taakshiftId heeft
     * @param $deelnemerId het id van de deelnemer
     * @param $taakShiftId het id van de taakshift
     * @return het resultaat van de query
     *
     */
    function getAllWithTaakWhereDeelnemer($deelnemerId, $taakShiftId)
    {
        $this->db->where("deelnemerId", $deelnemerId);
        $this->db->where("taakShiftId", $taakShiftId);
        $query = $this->db->get('helperTaak');

        return $query->result();
    }

    /**
     * Vrijwilliger toevoegen aan de databank
     * @param $vrijwilliger de vrijwilliger die toegevoegd moet worden
     * @return het id van de ingevoegde vrijwilliger
     */
    function insertVrijwilliger($vrijwilliger)
    {
        $this->db->insert('helperTaak', $vrijwilliger);
        return $this->db->insert_id();
    }

    /**
     * Verwijderd een vrijwilliger uit de database
     * @param $vrijwilliger de vrijwilliger die verwijderd moet worden
     */
    function deleteVrijwilliger($vrijwilliger)
    {
        $this->db->where("deelnemerId", $vrijwilliger->deelnemerId);
        $this->db->where("taakshiftId", $vrijwilliger->taakShiftId);
        $this->db->delete("helperTaak");
    }



}


