<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 * @class InschrijvingsOptie_model
 */

class InschrijvingsOptie_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Telt hoeveel personen al zijn ingeschreven voor een optie
     * @param -$optieId id van de optie
     * @return het aantal
     */
    function countInschrijvingenByOptie($optieId){
        $this->db->where('optieId', $optieId);
        return $this->db->count_all_results('inschrijfOptie');
    }
    
    /**
     * Bij een opgegeven optie alle deelnemers vinden
     * @param $optieId optie van welke we de inschrijving willen vinden
     * @return de inschrijfoptie met de deelnemer
     */
    function getIngeschrevenBijOptie($optieId){
        $this->db->where('optieId', $optieId);
        $query = $this->db->get('inschrijfOptie');
        $inschrijfOpties = $query->result();
        
        $this->load->model('Deelnemer_model');
        foreach($inschrijfOpties as $inschrijfOptie){
            $inschrijfOptie->deelnemer = $this->Deelnemer_model->get($inschrijfOptie->deelnemerId);
        }
        
        return $inschrijfOpties;
    }
    
    /**
     * Inschrijvingen van bepaalde gebruiker met de optie waarvoor is ingeschreven
     * @param $deelnemerId id van de deelnemer
     * @return de inschrijvingen
     */
    function getBijGebruikerWithOpties($deelnemerId){
        $this->db->where('deelnemerId', $deelnemerId);
        $query = $this->db->get('inschrijfOptie');
        $inschrijfOpties = $query->result();
        
        $this->load->model('Optie_model');
        foreach($inschrijfOpties as $inschrijfOptie){
            $inschrijfOptie->optie = $this->Optie_model->get($inschrijfOptie->optieId);
        }
        
        return $inschrijfOpties;
    }
    
    /**
     * Kijkt of een bepaalde gebruiker als is ingeschreven in een bepaalde optie
     * @param $gebruikerId de gebruiker
     * @param $optieId de optie
     * @return 1 als de gebruiker al is ingeschreven, 0 als dit nog niet zo is
     */
    function isAlIngeschreven($gebruikerId, $optieId){
        $this->db->where('optieId', $optieId);
        $this->db->where('deelnemerId', $gebruikerId);
        $query = $this->db->get('inschrijfOptie');
        return $query->result();
    }
    
    /**
     * Kijkt of een bepaalde gebruiker al is ingeschreven voor eender welke optie
     * @param $gebruikerId Id van de gebruiker die we zoeken
     * @return alle inschrijfopties voor deze gebruiker, als dit niet null is, weten we dat hij is ingeschreven
     */
    function IsReedsIngeschreven($gebruikerId){
        $this->db->where('deelnemerId', $gebruikerId);
        $query = $this->db->get('inschrijfOptie');
        return $query->result();
    }
    
    /**
     * Een gebruiker inschrijven
     * @param $inschrijfOptie object met de nodige parameters
     * @return het id van de nieuwe inschrijving
     */
    function schrijfIn($inschrijfOptie){
       $this->db->insert('inschrijfOptie', $inschrijfOptie);
        return $this->db->insert_id();
    }
    
    /**
     * Een bepaalde gebruiker uitschrijven voor een bepaalde optie
     * @param $optieId de optie
     * @param $gebruikerId de gebruiker
     */
    function schrijfUit($optieId, $gebruikerId){
        $this->db->where('optieId', $optieId);
        $this->db->where('deelnemerId', $gebruikerId);
        $this->db->delete('inschrijfOptie');
    }
}


