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
    
    function index($taakId, $doId) {
        //Laden van shift overzicht per taak
        //Aanmaken variabele(n) en/of array(s)
        $shiften = array();
        
        //Laden van alle shiften van deze taak
        $this->load->model('TaakShift_model');
        $shiftenIC = $this->TaakShiftModel->getAllByTaakId($taakId);
        
        //Aantal inschrijvingen voor elke shift in elk shift object zetten
        $this->load->model('HelperTaak_model');
        foreach ($shiftenIC as $shift) {
            $shift->AantalInschrijvingen = $this->HelperTaak_model->countAllShift($shift->id);
            array_push($shiften, $shift);
        }
        
        //Laden van taak
        $this->load->model('CRUD_Model');
        $data['taak'] = $this->CRUD_Model->get($taakId, 'taak');
        
        $data['doId'] = $doId;
        
        $partials = array('inhoud' => 'TaakBeheren/overzichtShift', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    function opslaan($doId) {
        redirect("/taak/index/$doId");
    }
    
    function annuleren($doId) {
        redirect("/taak/index/$doId");
    }
}
