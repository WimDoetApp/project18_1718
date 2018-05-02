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
        $doTable = "optie";
        
        //Klaarzetten differentie variabelen
        if ($isD) {
            $doTable = "dagonderdeel";
        }
        
         //Laden van alle shiften van deze taak
        $this->load->model('CRUD_Model');
        $shiftenIC = $this->CRUD_Model->getAllByColumn($taakId, 'taakId', 'TaakShift');
        
        //Aantal inschrijvingen voor elke shift in elk shift object zetten
        $this->load->model('HelperTaak_model');
        foreach ($shiftenIC as $shift) {
            $aantal = $this->HelperTaak_model->countAllShift($shift->id);
            $shift->aantalInschrijvingen = $aantal;
            array_push($shiften, $shift);
        }
        
        //Laden van taak
        $this->load->model('CRUD_Model');
        $taak = $this->CRUD_Model->get($taakId, 'taak');
        $data['taak'] = $taak;
        $do = $this->CRUD_Model->get($doId, $doTable);
        $data['titel'] = $do->naam;
        
        $data['shiften'] = $shiften;
        
        $data['doId'] = $doId;
        $data['isD'] = $isD;
        
        $row = $this->CRUD_Model->getLast('id', 'personeelsfeest');
        $data['personeelsfeest'] = $row->id;
        
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        $partials = array('inhoud' => 'Taak beheren/overzichtShift', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    function wijzigen() {
        $id = $this->input->post('id');
        $shift['begintijd'] = $this->input->post('begintijd');
        $shift['eindtijd'] = $this->input->post('eindtijd');
        $shift['aantalPlaatsen'] = $this->input->post('aantalPlaatsen');
        
        $this->model->load('CRUD-Model');
        $this->CRUD_Model->update($id, $shift, 'taakShift');
        
        $this->index($this->input->post('taakId'), $this->input->post('doId'), $this->input->post('isD'));
    }
    
    function verwijderen() {
        echo "FUC";
    }
    
    function wijzigenT() {
        $taakId = $this->input->post('taakId');
        $this->model->load('CRUD_Model');
        $taakI = $this->CRUD_Model->get($taakId, 'taak');
        
        $taak['dagOnderdeelId'] = $taakI->dagOnderdeel;
        $taak['optieId'] = $taakI->optieId;
        $taak['naam'] = $this->input->post('naam');
        $taak['beschrijving'] = $this->input->post('beschrijving');
        
        print_r($taak);
        $this->CRUD_Model->update($taakId, $taak, 'taak');
        
        //$this->index($this->input->post('taakId'), $this->input->post('doId'), $this->input->post('isD'));
    }
    
    function inputRouting() {
        $knop = $this->input->post('action');
        echo $knop;
        $TYPE = $this->input->post('TYPE');
        echo $TYPE;
        if ($knop == "Wijzig") {
            if ($TYPE == "T") {
                $this->wijzigenT();
            } elseif ($TYPE == "S") {
                $this->wijzigen();
            }
        } else {
            $this->verwijderen();
        }
    }
}
