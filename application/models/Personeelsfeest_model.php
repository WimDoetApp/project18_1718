<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class Personeelsfeest_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getLaatstePersoneelsfeest()
    {
        $this->db->select('*');
        $this->db->from('personeelsfeest');
        $this->db->where('id=(SELECT max(id) FROM personeelsfeest)');
        $query = $this->db->get();
        return $query->row();
    }

    function getAllesVanPersoneelsfeest()
    {
        $this->db->select('*');
        $this->db->from('personeelsfeest');
        $query = $this->db->get();
        return $query->result();
    }

    function getJarenPersoneelsfeest()
    {
        $this->db->select('id, YEAR(datum) as Jaar, inschrijfDeadline');
        $this->db->from('personeelsfeest');
        $query = $this->db->get();
        return $query->result();
    }

    function insertPersoneelsfeest($personeelsfeest)
    {
        $this->db->insert('personeelsfeest', $personeelsfeest);
        return $this->db->insert_id();
    }

    function insertDagonderdeel($dagonderdeel)
    {
        $this->db->insert('dagonderdeel', $dagonderdeel);
        return $this->db->insert_id();
    }

    function insertOrganisatoren($organisator)
    {
        $this->db->insert('deelnemer', $organisator);
        return $this->db->insert_id();
    }

    function getDagonderdelenVanPersoneelsfeest($id)
    {
        $this->db->select('starttijd, eindtijd, naam, personeelsfeestId, heeftTaak, vrijwilligerMeeDoen,locatieId');
        $this->db->where('personeelsfeestId', $id);
        $this->db->from('dagonderdeel');
        $query = $this->db->get();
        return $query->result();
    }

    function getOrganisatorenVanPersoneelsfeest($id)
    {
        $this->db->select('naam, voornaam, email, wachtwoord, soortId, personeelsfeestId');
        $this->db->where('personeelsfeestId', $id);
        $this->db->from('deelnemer');
        $query = $this->db->get();
        return $query->result();
    }

    function getLaatsteId()
    {
        return $this->db->select('id')->order_by('id', "desc")->limit(1)->get('personeelsfeest')->row();
    }

    function setDatumPersoneelsfeest($id, $datum)
    {
        $this->db->where('id', $id);
        $this->db->set('datum', $datum);
        $this->db->update('personeelsfeest', 'datum');
    }

    function setDeadlinePersoneelsfeest($id, $deadline)
    {
        $this->db->where('id', $id);
        $this->db->set('inschrijfDeadline', $deadline);
        $this->db->update('personeelsfeest', 'inschrijfDeadline');
    }
}


