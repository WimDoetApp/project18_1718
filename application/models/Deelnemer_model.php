<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class Deelnemer_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Haalt een specifieke deelnemer op
     * @param $id het id van de deelnemer
     * @return deelnemer
     */
    function get($id) 
    {
        $this->db->where('id', $id);
        $query = $this->db->get('deelnemer');
        return $query->row();  
    }
    
    /**
     * Deelnemer met alle opties en hulpshiften waarvoor hij is ingeschreven
     * @param $id id van de deelnemer
     * @return een deelnemer met al zijn inschrijvingen
     */
    function getWithAll($id){
        $this->db->where('id', $id);
        $query = $this->db->get('deelnemer');
        $deelnemer = $query->row();
        
        $this->load->model('InschrijvingsOptie_model');
        $this->load->model('HelperTaak_model');
        $this->load->model('Soort_model');
        $inschrijfOpties = $this->InschrijvingsOptie_model->getBijGebruikerWithOpties($deelnemer->id);
        $helperTaken = $this->HelperTaak_model->getByDeelnemerWithTaakShift($deelnemer->id);
        $deelnemer->soort = $this->Soort_model->get($deelnemer->soortId);
        
        if($helperTaken != null){
            $deelnemer->helperTaken = $helperTaken;
        }else{
            $deelnemer->helperTaken = "";
        }
        
        if($inschrijfOpties != null){
            $deelnemer->inschrijfOpties = $inschrijfOpties;
        }else{
            $deelnemer->inschrijfOpties = "";
        }
        
        return $deelnemer;
    }
    
    /**
     * Haalt alle deelnemers met dezelfde email op
     * @param $email de email waarop we zoeken
     * @return deelnemers
     */
    function getGebruikerByEmail($email){
        $this->db->where('email', $email);
        $query = $this->db->get('deelnemer');
        return $query->result();
    }
    
    /**
     * Alle deelnemers bij een personeelsfeest ophalen
     * @param $personeelsfeestId
     * @return de deelnemers
     */
    function getAll($personeelsfeestId){
        $this->db->where('personeelsfeestId', $personeelsfeestId);
        $query = $this->db->get('deelnemer');
        return $query->result();
    }
    
    /**
     * Alle personeelsleden ophalen
     * @param $personeelsfeestId id van het huidige personeelsfeest
     * @return de opgevraagde records
     */ 
    function getAllPersoneelsleden($personeelsfeestId)
    {
        $this->db->where('personeelsfeestId', $personeelsfeestId);
        $this->db->where("(soortId='2' OR soortId='3')");
        $query = $this->db->get('deelnemer');
        return $query->result();
    }
    
    /**
     * Deelnemer aanpassen
     * @param $deelnemer de deelnemer die we willen aanpassen
     */
    function update($deelnemer)
    {
        $this->db->where('id', $deelnemer->id);
        $this->db->update('deelnemer', $deelnemer);
    }
    
    /**
     * Een bepaalde deelnemer uit de databank halen aan de hand van zijn emailadres (om in te loggen)
     * @param $email email van de gebruiker
     * @param $wachtwoord wachtwoord van de gebruiker
     * @param $personeelsfeestId id van het huidige personeelsfeest
     * @return deelnemer
     */
    function getDeelnemer($email, $wachtwoord, $personeelsfeestId) {
        $this->db->where('email', $email);
        $this->db->where('personeelsfeestId', $personeelsfeestId);
        $query = $this->db->get('deelnemer');
        
        if ($query->num_rows() == 1) {
            $deelnemer = $query->row();

            if (password_verify($wachtwoord, $deelnemer->wachtwoord)){ 
                return $deelnemer;
            } else if ($wachtwoord == $deelnemer->wachtwoord){
                return $deelnemer;
            } else{
                return null;
            }
        } else {
            return null;
        }
    }
    
    /**
     * nieuwe gegevens in deelnemers zetten
     */
    function insert($deelnemer)
    {
        $this->db->where('email', $deelnemer->email);
        $this->db->where('personeelsfeestId', $deelnemer->personeelsfeestId);
        $query = $this->db->get('deelnemer');
        
        if($query->row() == null){
            $this->db->insert('deelnemer', $deelnemer);
            return $this->db->insert_id();
        }
    }
    
    /**
     * Alle vrijwilligers laten zien
     */
    function getAllVrijwilligers()
    {
        $this->db->where("(soortId='1')");
        $query = $this->db->get('deelnemer');
        return $query->result();
    }
    
    function getAllOrganisatoren()
    {
        $this->db->where("(soortId='3' OR soortId='4')");
        $query = $this->db->get('deelnemer');
        return $query->result();
    }
}


