<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EmailadressenRaadplegen extends CI_Controller
{

    // +----------------------------------------------------------
    // | Personeelsfeest - Jari
    // +----------------------------------------------------------
    // | emailadressen raadplegen controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------


    /**
     * Controller Emailadressen raadplegen
     * @author Jari Mathé
     */
    
    public function __construct()
    {
        parent::__construct();
        /**
         * Laad de helper voor formulieren
         */
        $this->load->helper('form');
        
        if (!$this->authex->isAangemeld()) {
            redirect('Home/index');
        } 
    }
    
    /**
    * Index pagina openen
    */
    public function index() {
        $data['titel']  = 'E-mail adressen';
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Personeelsfeest_model');
        $personeelsfeest = $this->Personeelsfeest_model->getLaatsteId()->id;
        $data['personeelsfeest'] = $personeelsfeest;
        
        $this->load->model('HelperTaak_model');
        $helperTaken = $this->HelperTaak_model->getAllWithTaakAndDeelnemer();
        
        $takenMetDeelnemers = "";
        
        /**
        * Zorgen dat de vrijwilligers onder hun taak komen
        */
        foreach($helperTaken as $helperTaak) {
            if($helperTaak->deelnemer->soortId == 1 && $helperTaak->deelnemer->personeelsfeestId == $personeelsfeest) {
                $takenMetDeelnemers[$helperTaak->taakShift->taak->naam][] = $helperTaak->deelnemer;
            }
        }
        $data['takenMetDeelnemers'] = $takenMetDeelnemers;
        
        $this->load->model('Deelnemer_model');
        $data['organisatoren'] = $this->Deelnemer_model->getAllOrganisatoren();

        $partials = array('inhoud' => 'Emailadressen raadplegen/emailadressenRaadplegen', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
