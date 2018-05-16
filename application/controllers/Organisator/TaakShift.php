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
        
        $this->load->model('HelperTaak_model');
        $shiftAP = $this->HelperTaak_model->countAllShift($id);
        
        $this->load->model('CRUD_Model');
        
        if ($shiftAP < $shift['aantalPlaatsen']) {
            $deelnemers = $this->CountPlaatsenTeVeel($shift['aantalPlaatsen'] - $shiftAP, $id);
            //@WIM@ stuur een mail naar de deelnemers in de variabele $deelnemers
            
            foreach ($deelnemers as $deelnemer) {
                $this->CRUD_Model->delete($deelnemer->id, 'HelperTaak');
            }
        }
        
        $this->CRUD_Model->update($id, $shift, 'taakShift');
        
        $this->index($this->input->post('taakId'), $this->input->post('doId'), $this->input->post('isD'));
    }
    
    function verwijderen() {
        echo "FUCC you double BB";
    }
    
    function wijzigenT() {
        $taakId = $this->input->post('taakId');
        
        $this->load->model('CRUD_Model');
        $taakI = $this->CRUD_Model->get($taakId, 'taak');
        
        if ($taakI->dagOnderdeelId != null) {
            $taak['dagOnderdeelId'] = $taakI->dagOnderdeelId;
        } else { $taak['dagOnderdeelId'] = null; }
        
        if ($taakI->optieId != null) {
            $taak['optieId'] = $taakI->optieId;
        } else { $taak['optieId'] = null; }
        
        $taak['naam'] = $this->input->post('naam');
        $taak['beschrijving'] = $this->input->post('beschrijving');
        
        $this->CRUD_Model->update($taakId, $taak, 'taak');
        
        $doId = $this->input->post('doId');
        $isD = $this->input->post('isD');
        
        $this->index($taakId, $doId, $isD);
    }
    
    public function knopInput() {
        //Verwijst de actie door naar juiste methode
        //Van het formulier kan het veld (name="action") maar twee mogelijkheden hebben: "wijzig" of "verwijder"
        //ALS (name="action") -> "wijzig" IS wordt Locatie->wijzig() uitgevoerd
        //ALS (name="action") -> NIET "wijzig" IS wordt Locatie->verwijder() uitgevoerd
        $knop = $this->input->post('action');
        
        if ($knop == "Wijzig") {
            $this->wijzigen();
        } else {
            $this->verwijderen();
        }
    }
    
    function CountPlaatsenTeVeel($aantal, $id) {
        //Vraag alle deelnemers op die zich hebben ingeschreven voor deze shift
        $deelnemers = $this->pl_TaakShift($id);
        
        //Return array
        $deelnemersOut = array();
        
        //Haal elke deelnemer die te veel is uit de array van deelnemers en stop die in de return array
        //$i < $aantal -> laatste index van $deelnemers -> $deelnemersOut
        for ($i = 0; $i < $aantal; $i++) {
            array_push($deelnemersOut, array_pop($deelnemers));
        }
        
        return $deelnemersOut;
    }
    
    function VoegToe()
}
