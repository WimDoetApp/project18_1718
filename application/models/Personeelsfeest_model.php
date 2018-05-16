<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 * @class Personeelsfeest_model
 */

class Personeelsfeest_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Alle personeelsfeesten ophalen
     * @return Alle personeelsfeesten
     */
    function getAll(){
        $this->db->select('*'); 
        $query = $this->db->get('personeelsfeest');
        return $query->result();    
    }

    /**
     * Het laatste personeelsfeest ophalen
     * @return alle gegevens van het laatste personeelsfeest
     */
    function getLaatstePersoneelsfeest()
    {
        $this->db->select('*');
        $this->db->from('personeelsfeest');
        $this->db->where('id=(SELECT max(id) FROM personeelsfeest)');
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Alles ophalen van het personeelsfeest
     * @return alles van personeelsfeest
     */
    function getAllesVanPersoneelsfeest()
    {
        $this->db->select('*');
        $this->db->from('personeelsfeest');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Alle jaren ophalen van de vorige personeelsfeesten
     * @return alle jaren van de vorige personeelsfeesten
     */
    function getJarenPersoneelsfeest()
    {
        $this->db->select('id, YEAR(datum) as Jaar, inschrijfDeadline');
        $this->db->from('personeelsfeest');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Personeelsfeest toevoegen in de databank
     * @param $personeelsfeest het personeelsfeest dat toegevoegd moet worden in de databank
     * @return het id van het toegevoegde personeelsfeest
     */
    function insertPersoneelsfeest($personeelsfeest)
    {
        $this->db->insert('personeelsfeest', $personeelsfeest);
        return $this->db->insert_id();
    }

    /**
     * Dagonderdeel toevoegen in de databank
     * @param $dagonderdeel het dagonderdeel dat toegevoegd moet worden in de databank
     * @return het id van het toegevoegde dagonderdeel
     */
    function insertDagonderdeel($dagonderdeel)
    {
        $this->db->insert('dagonderdeel', $dagonderdeel);
        return $this->db->insert_id();
    }

    /**
     * Organisatoren toevoegen in de databank
     * @param $organisator de organisator die toegevoegd moet worden in de databank
     * @return het id van de toegevoegde organisator
     */
    function insertOrganisatoren($organisator)
    {
        $this->db->insert('deelnemer', $organisator);
        return $this->db->insert_id();
    }

    /**
     * Alle dagonderdelen van één bepaald personeelsfeest ophalen
     * @param $id het id van het personeelsfeest waarvan de dagonderdelen opgehaald moeten worden
     * @return alle dagonderdelen van het gewenste personeelsfeest
     */
    function getDagonderdelenVanPersoneelsfeest($id)
    {
        $this->db->select('starttijd, eindtijd, naam, personeelsfeestId, heeftTaak, vrijwilligerMeeDoen,locatieId');
        $this->db->where('personeelsfeestId', $id);
        $this->db->from('dagonderdeel');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Alle organisatoren van één bepaald personeelsfeest ophalen
     * @param  het id van het personeelsfeest waarvan de organisatoren opgehaald moeten worden
     * @return alle organisatoren van het gewenste personeelsfeest
     */
    function getOrganisatorenVanPersoneelsfeest($id)
    {
        $this->db->select('naam, voornaam, email, wachtwoord, soortId, personeelsfeestId');
        $this->db->where('personeelsfeestId', $id);
        $this->db->where('soortId', 3);
        $this->db->from('deelnemer');
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Hoofdorganistors bij een bepaald personeelsfeest vinden
     * @param $id id van het personeelfeest
     * @return de hoofdorganisators
     */
    function getHoofdOrganisatorenVanPersoneelfeest($id){
        $this->db->where('personeelsfeestId', $id);
        $this->db->where('soortId', 4);
        $query = $this->db->get('deelnemer');
        return $query->result();
    }

    /**
     * haal het id van het laatste personeelsfeest op
     * @return het id van het laatste personeelsfeest
     */
    function getLaatsteId()
    {
        return $this->db->select('id')->order_by('id', "desc")->limit(1)->get('personeelsfeest')->row();
    }

    /**
     * Verander de datum van het personeelsfeest
     * @param $id het id van het personeelsfeest waarvan je de datum wilt veranderen
     * @param $datum de nieuwe datum waarop het personeelsfeest plaatsvindt
     */
    function setDatumPersoneelsfeest($id, $datum)
    {
        $this->db->where('id', $id);
        $this->db->set('datum', $datum);
        $this->db->update('personeelsfeest', 'datum');
    }

    /**
     * Verander de deadline van het personeelsfeest
     * @param $id het id van het personeelsfeest waarvan je de deadline wilt veranderen
     * @param $deadline de nieuwe deadline waarvoor je je moet inschrijven voor het personeelsfeest
     */
    function setDeadlinePersoneelsfeest($id, $deadline)
    {
        $this->db->where('id', $id);
        $this->db->set('inschrijfDeadline', $deadline);
        $this->db->update('personeelsfeest', 'inschrijfDeadline');
    }

    /**
     * update het personeelsfeest in de databank
     * @param $personeelsfeest de nieuwe gegevens die in de databank moeten komen
     */
    function update($personeelsfeest){
        $this->db->where('id', $personeelsfeest->id);
        $this->db->update('personeelsfeest', $personeelsfeest);
    }
}


