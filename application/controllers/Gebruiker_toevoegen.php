<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gebruiker_Toevoegen extends CI_Controller {

    /**
     * Controller: Gebruiker toevoegen
     * @author Jari Mathé, Wim Naudts
     */


    public function __construct() {
        parent::__construct();
        /**
         * Laad de helper voor formulieren
        */
        $this->load->helper('form');
        $this->load->model('deelnemer_model');
        
        /**
         * Kijken of de gebruiker de juiste rechten heeft
         */
        if (!$this->authex->isAangemeld()) {
            redirect('home/index');
        } else {
            $gebruiker = $this->authex->getDeelnemerInfo();
            if ($gebruiker->soortId < 3) {
                redirect('home/toonStartScherm');
            }
        }
    }
    
    /**
    * beginscherm om gebruiker toe te voegen
    */
    public function index() {
        $data['titel']  = 'Gebruiker toevoegen';
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();

        $partials = array('inhoud' => 'Gebruiker toevoegen/gebruiker_toevoegen', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * registeren
     */
    public function registreer()
    {
        $deelnemer = new stdClass();
        $soortId = 0;
            
        $deelnemer->naam = $this->input->post('naam');
        $deelnemer->voornaam = $this->input->post('voornaam');
        $deelnemer->email = $this->input->post('email');
        $wachtwoord = $this->wachtwoordGenereren();
        
        $deelnemer->wachtwoord = password_hash($wachtwoord, PASSWORD_BCRYPT);
            
        if($this->input->post('knopPersoneelslid')) { 
            $soortId = 1;
        } else {
            $soortId = 2;
        }
            
        $this->deelnemer_model->insert($deelnemer);
        $this->index();
    }
    
    /**
     * Misschien nog naar een andere file verplaatsen
     */
    function wachtwoordGenereren() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $wachtwoord = "";
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $wachtwoord += $alphabet[$n];
        }
        return $wachtwoord;
    }
} 