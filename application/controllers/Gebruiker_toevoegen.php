<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gebruiker_Toevoegen extends CI_Controller {


    // +----------------------------------------------------------
    // | Personeelsfeest 
    // +----------------------------------------------------------
    // | Gebruiker toevoegen controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

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
        $this->load->model('Deelnemer_model');
        date_default_timezone_set('Europe/Brussels');
        
        /**
         * Kijken of de gebruiker de juiste rechten heeft
         */
        if (!$this->authex->isAangemeld()) {
            redirect('Home/index');
        } else {
            $gebruiker = $this->authex->getDeelnemerInfo();
            if ($gebruiker->soortId < 3) {
                redirect('Home/toonStartScherm');
            }
        }
    }
    
    /**
    * beginscherm om gebruiker toe te voegen
    */
    public function index($personeelsfeestId) {
        $data['titel']  = 'Gebruiker toevoegen';
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        $data['personeelsfeest'] = $personeelsfeestId;

        $partials = array('inhoud' => 'Gebruiker toevoegen/gebruiker_toevoegen', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * registeren
     */
    public function registreer()
    {
        /**
         * Variabelen
         */
        $deelnemer = new stdClass();
        $soortId = 0;
        $personeelsfeestId = $this->input->post('personeelsfeestId');
        $email = $this->input->post('email');
        $voornaam = $this->input->post('voornaam');
            
        /**
         * Waarden om weg te schrijven ophalen
         */
        $deelnemer->naam = $this->input->post('naam');
        $deelnemer->voornaam = $voornaam;
        $deelnemer->email = $email;
        $deelnemer->personeelsfeestId = $personeelsfeestId;
        
        /**
         * Wachtwoord generen en toevoegen aan deelnemer
         */
        $wachtwoord = $this->wachtwoordGenereren();        
        $deelnemer->wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);  
            
        if($this->input->post('knopPersoneelslid')) { 
            $soortId = 2;
        } else {
            $soortId = 1;
        }
        
        $deelnemer->soortId = $soortId;
        
        /**
         * Mail sturen
         */
        $this->stuurMail($email, "Hey $voornaam \n\nU bent nu geregistreerd op de applicatie Personeelsfeest.\nInloggen kan met deze gegevens\n\nemail: $email \nwachtwoord: $wachtwoord", "Registratie personeelfeest");
            
        $this->deelnemer_model->insert($deelnemer);
        $this->index($personeelsfeestId);
    }
    
    private function stuurMail($geadresseerde, $boodschap, $titel) {
        $this->load->library('email');

        $this->email->from('teamachtien@gmail.com', 'Team 18');
        $this->email->to($geadresseerde);
        $this->email->cc('');
        $this->email->subject($titel);
        $this->email->message($boodschap);

        if (!$this->email->send()) {
            show_error($this->email->print_debugger());
            return false;
        } else {
            return true;
        }
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