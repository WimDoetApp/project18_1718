<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TaakShift
 *
 * @author yen
 */
class TaakShift extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
    }
    
    function index($taakId, $doId, $isD) {
        //Laden van shift overzicht per taak
        //Aanmaken variabele(n) en/of array(s)
        $shiften = array();
        
         //Laden van alle shiften van deze taak
        $this->load->model('CRUD_Model');
        $shiftenIC = $this->CRUD_Model->getAllByColumn($taakId, 'taakId', 'TaakShift');
        
        //Aantal inschrijvingen voor elke shift in elk shift object zetten
        $this->load->model('HelperTaak_model');
        foreach ($shiftenIC as $shift) {
            $aantal = $this->HelperTaak_model->countAllShift($shift->id);
            $shift->AantalInschrijvingen = $aantal;
            array_push($shiften, $shift);
        }
        
        //Laden van taak
        $this->load->model('CRUD_Model');
        $taak = $this->CRUD_Model->get($taakId, 'taak');
        $data['taak'] = $taak;
        $data['titel'] = $taak->naam;
        
        $data['shiften'] = $shiften;
        
        $data['doId'] = $doId;
        $data['isD'] = $isD;
        
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        $partials = array('inhoud' => 'Taak beheren/overzichtShift', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    function opslaan($doId) {
        redirect("/taak/index/$doId");
    }
    
    function annuleren($doId) {
        redirect("/taak/index/$doId");
    }
}
