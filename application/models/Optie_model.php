<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 * @class Optie_model
 */

class Optie_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * id ophalen van optie
     * @param $id het id van de gewenste optie
     * @return de gewenste optie
     */
    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('optie');
        return $query->row();
    }

    /**
     * Naam ophalen aan de hand van dagOnderdeelId
     * @param $dagOnderdeelId het id van het gewenste dagonderdeel
     * @return het gewenste dagonderdeel
     */
    function getOptieDagOnderdeelId($dagOnderdeelId)
    {
        $this->db->where('dagOnderdeelId', $dagOnderdeelId);
        $query = $this->db->get('optie');
        return $query->result();
    }

    /**
     * Zorgen dat je de data in optie kan sturen
     * @param $info de optie die toegevoegd moet worden
     * @return het id van de toegevoegde optie
     */
    function insert($info)
    {
        $this->db->insert('optie', $info);
        return $this->db->insert_id();
    }

    /**
     * Alle opties ophalen aan de hand van het gevraagde dagonderdeel
     * @param $dagOnderdeelId , het id van het gevraagde dagonderdeel
     * @return mixed
     */
    function getAllByDagOnderdeel($dagOnderdeelId)
    {
        $this->db->where('dagOnderdeelId', $dagOnderdeelId);
        $query = $this->db->get('optie');
        $opties = $query->result();

        /**
         * Per optie ophalen hoeveel mensen er zijn ingeschreven
         */
        $gebruiker = $this->authex->getDeelnemerInfo();
        $this->load->model('InschrijvingsOptie_model');
        foreach ($opties as $optie) {
            $optie->aantalIngeschreven = $this->InschrijvingsOptie_model->countInschrijvingenByOptie($optie->id);

            /**
             * Checken of de gebruiker al is ingeschreven voor een optie
             */
            $isAlIngeschreven = $this->InschrijvingsOptie_model->isAlIngeschreven($gebruiker->id, $optie->id);

            if (!empty($isAlIngeschreven)) {
                $optie->isAllIngeschreven = true;
                $optie->commentaar = $isAlIngeschreven[0]->commentaar;
            } else {
                $optie->isAllIngeschreven = false;
            }
        }

        return $opties;
    }

    /**
     * Alle opties ophalen met bijhorende taken op basis van het dagonderdeel
     * @param $dagOnderdeelId het id van het dagonderdeel waarvan je de overeenkomende opties wilt verkrijgen
     * @return de opties met bijhorende taken waarvan het daonderdeel gelijk is aan het gevraagde dagonderdeel
     */
    function getAllByDagOnderdeelWithTaken($dagOnderdeelId)
    {
        $this->db->where('dagOnderdeelId', $dagOnderdeelId);
        $query = $this->db->get('optie');
        $opties = $query->result();

        /**
         * Per optie ophalen hoeveel mensen er zijn ingeschreven
         */
        $this->load->model('Taak_model');
        foreach ($opties as $optie) {
            $optie->taak = $this->Taak_model->getAllByOptieIdWithShiften($optie->id);
        }
        return $opties;
    }

    /**
     * Alle opties ophalen waarvan de IDs gelijk zijn aan de gevraagde IDs
     * @param $ids de gevraagde IDs waarmee de opties moeten overeenkomen
     * @return array de opties waarvan de IDs overeenkomen met de gewenste IDs
     */
    function getAllByIds($ids)
    {
        /**
         * aanmaken tussen array
         */
        $titels = array();

        /**
         * ophalen alle titels
         */
        foreach ($ids as $id) {
            $this->load->model('CRUD_Model');
            $titel = $this->CRUD_Model->get($id, 'optie');
            array_push($titels, $titel->naam);
        }

        return $titels;
    }

    /**
     * tabel updaten
     * @param $optie de optie de we updaten
     */
    function update($optie)
    {
        $this->db->where('id', $optie->id);
        $this->db->update('optie', $optie);
    }

    /**
     * optie verwijderen
     * @param $id id van de optie die we willen verwijderen
     */
    function delete($id)
    {
        $this->db->where('optieId', $id);
        $this->db->delete('inschrijfOptie');

        $this->db->where('id', $id);
        $this->db->delete('optie');
    }
}


