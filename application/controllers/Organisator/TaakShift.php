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
class TaakShift extends CI_Controller {

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
        $shiftenIC = $this->CRUD_Model->getAllByColumn($taakId, 'taakId', 'taakShift');

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
        $deelnemers = array();

        $id = $this->input->post('id');
        $shift['begintijd'] = $this->input->post('begintijd');
        $shift['eindtijd'] = $this->input->post('eindtijd');
        $shift['aantalPlaatsen'] = $this->input->post('aantalPlaatsen');

        $this->load->model('HelperTaak_model');
        $shiftAP = $this->HelperTaak_model->countAllShift($id);

        $this->load->model('CRUD_Model');

        $tS = $this->CRUD_Model->get($id, 'taakShift');
        $taak = $this->CRUD_Model->get($tS->taakId, 'taak');

        if ($shiftAP > $shift['aantalPlaatsen']) {
            $deelnemers = $this->CountPlaatsenTeVeel($shift['aantalPlaatsen'] - $shiftAP, $id);


            foreach ($deelnemers as $deelnemer) {
                $geadresseerde = $deelnemer->email;
                $boodschap = "Beste " . $deelnemer->voornaam . " " . $deelnemer->naam . ",\n u inschrijving bij de taak \"" . $taak->naam . "\" van $shift[begintijd] tot $shift[eindtijd] werd geannuleerd.";
                $titel = "Annulatie inschrijving";

                $this->load->library('email');
                $this->email->from('teamachtien@gmail.com', 'Team 18');
                $this->email->to($geadresseerde);
                $this->email->cc('');
                $this->email->subject($titel);
                $this->email->message($boodschap);

                $this->CRUD_Model->delete($deelnemer->id, 'helperTaak');
            }
        }

        $this->CRUD_Model->update($id, $shift, 'taakShift');

        $this->index($this->input->post('taakId'), $this->input->post('doId'), $this->input->post('isD'));
    }

    function verwijderen($id, $doId, $isD, $taakId) {
        date_default_timezone_set('Europe/Brussels');
        $shiften = array();
        ///Get everything ready
        $this->load->model('Pipeline_Model');

        ///Get Array from Pipeline
        $stuurArray = $this->Pipeline_Model->pl_Mail(1, $id);

        $taken = $stuurArray["taken"];
        $shiften = $stuurArray["shiften"];
        $helpers = $stuurArray["helpers"];
        $vrijwilligers = $stuurArray["vrijwilligers"];

        $this->load->model('CRUD_Model');
        $taak = $this->CRUD_Model->get($taken, 'taak');
        $shift = $this->CRUD_Model->get($shiften, 'taakShift');
        foreach ($helpers as $helper) {
            $geadresseerde = $vrijwilligers["$helper->deelnemerId"]->email;
            $boodschap = "Beste " . $vrijwilligers["$helper->deelnemerId"]->voornaam . " " . $vrijwilligers["$helper->deelnemerId"]->naam . ",\n u inschrijving bij de taak \"" . $taak->naam . "\" van $shift->begintijd tot $shift->eindtijd werd geannuleerd.";
            $titel = "Annulatie inschrijving";

            $this->load->library('email');
            $this->email->from('teamachtien@gmail.com', 'Team 18');
            $this->email->to($geadresseerde);
            $this->email->cc('');
            $this->email->subject($titel);
            $this->email->message($boodschap);

            $this->CRUD_Model->delete($helper->id, 'helperTaak');
        }

        $this->CRUD_Model->delete($shift->id, 'taakShift');

        $this->index($taakId, $doId, $isD);
    }

    function wijzigenT() {
        $taakId = $this->input->post('taakId');

        $this->load->model('CRUD_Model');
        $taakI = $this->CRUD_Model->get($taakId, 'taak');

        if ($taakI->dagOnderdeelId != null) {
            $taak['dagOnderdeelId'] = $taakI->dagOnderdeelId;
        } else {
            $taak['dagOnderdeelId'] = null;
        }

        if ($taakI->optieId != null) {
            $taak['optieId'] = $taakI->optieId;
        } else {
            $taak['optieId'] = null;
        }

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
        $deelnemers = array();
        $this->load->model('CRUD_Model');
        $helpers = $this->CRUD_Model->getAllByColumn($id, 'taakShiftId', 'helperTaak');
        foreach ($helpers as $helper) {
            array_push($deelnemers, $this->CRUD_Model->get($helper->deelnemerId, 'deelnemer'));
        }

        //Return array
        $deelnemersOut = array();

        //Haal elke deelnemer die te veel is uit de array van deelnemers en stop die in de return array
        //$i < $aantal -> laatste index van $deelnemers -> $deelnemersOut
        for ($i = 0; $i < $aantal; $i++) {
            array_push($deelnemersOut, array_pop($deelnemers));
        }

        return $deelnemersOut;
    }

    function VoegToe($taakId, $doId, $isD) {
        //Toevoegen van een niewe taak aan een bepaald dagonderdeel
        //Nieuw (standaard leeg) object taak aanmaken
        $shift = new stdClass();

        //Het object taak opvullen met standaard informatie, het dagonderdeelid wordt opgevuld met de veriabele doId
        $shift->begintijd = "00:00:00";
        $shift->eindtijd = "00:00:00";
        $shift->taakId = $taakId;
        $shift->aantalPlaatsen = "0";

        //De methode add van het Crud Model oproepen om het object taak toe te voegen aan de tabel taak
        $this->load->model('CRUD_Model');
        $this->CRUD_Model->add($shift, 'taakShift');

        $this->index($taakId, $doId, $isD);
    }

}
