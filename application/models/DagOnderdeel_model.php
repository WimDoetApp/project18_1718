<?php

/**
 * Team 18 - Project APP 2APP-BIT - Thomas More
 */

class DagOnderdeel_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }

     /**
     * Haalt een dagonderdeel met een bepaald id op.
     * @param $id id van het dagonderdeel
     * @return het opgevraagde record
     */
    function get($id) 
    {
        $this->db->where('id', $id);
        $query = $this->db->get('dagOnderdeel');
        return $query->row();  
    }
    /**
    * alle namen van dagonderdeel ophalen 
    */
    function getAllesBijDagonderdeel()
    {
        $this->db->select('*');
        $this->db->group_by('naam');
        
        $query = $this->db->get('dagOnderdeel');
        return $query->result();                
    }
    /**
     * Haalt alle dagonderdelen op, gesorteerd op starttijd.
     * @param $personeelsfeestId id van het huidige personeelsfeest
     * @return de opgevraagde records
     */
    function getAllByStartTijd($personeelsfeestId)
    {
        $this->db->where('personeelsfeestId', $personeelsfeestId);
        $this->db->order_by('starttijd', 'asc');
        $query = $this->db->get('dagOnderdeel');
        return $query->result();
    }
    
    /**
     * Haalt alle dagonderdelen op, met bijhorende opties, gesorteerd op starttijd
     * @param $personeelsfeesetId id van het huidige personeelsfeest
     * @return de opgevraagde recordss
     */
    function getAllByStartTijdWithOpties($personeelsfeesetId){
        $this->db->where('personeelsfeestId', $personeelsfeesetId);
        $this->db->order_by('starttijd', 'asc');
        $query = $this->db->get('dagOnderdeel');
        $dagonderdelen = $query->result();
        
        /**
         * Opties toewijzen per dagonderdeel
         */
        $this->load->model('Optie_model');
        foreach($dagonderdelen as $dagonderdeel){
            $dagonderdeel->opties = $this->Optie_model->getAllByDagOnderdeel($dagonderdeel->id);
        }
        
        return $dagonderdelen;
    }
    
    function getAllByStartTijdWithOptiesWithTakenWithShiften($personeelsfeesetId){
        $this->db->where('personeelsfeestId', $personeelsfeesetId);
        $this->db->order_by('starttijd', 'asc');
        $query = $this->db->get('dagOnderdeel');
        $dagonderdelen = $query->result();
        
        /**
         * Opties toewijzen per dagonderdeel
         */
        $this->load->model('Optie_model');
        foreach($dagonderdelen as $dagonderdeel){
            $dagonderdeel->opties = $this->Optie_model->getAllByDagOnderdeelWithTaken($dagonderdeel->id);
        }
        
        return $dagonderdelen;
    }
    
    /**
     * (leeg) dagonderdeel toevoegen
     * @param $dagonderdeel dagonderdeel dat we gaan toevoegen
     * @return het id van hat record dat toegevoegd is
     */
    function insert($dagonderdeel)
    {
        $this->db->insert('dagOnderdeel', $dagonderdeel);
        return $this->db->insert_id();
    }
    
    /**
     * Dagonderdeel aanpassen
     * @param $dagonderdeel dagonderdeel dat we gaan aanpassen
     */
    function update($dagonderdeel)
    {
        $this->db->where('id', $dagonderdeel->id);
        $this->db->update('dagOnderdeel', $dagonderdeel);
    }
    
    /**
     * Dagonderdeel verwijderen
     * @param $id id van het dagonderdeel dat we willen verwijderen
     */
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('dagOnderdeel');
    }
}


