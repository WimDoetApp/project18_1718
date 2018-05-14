<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GebruikerToevoegen extends CI_Controller {


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
     * @class GebruikerToevoegen
     */

    /**
     * Als deze variable true is, laten we een errormessage zien op de pagina om de gebruiker toe te voegen
     */
    public $error = false;

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
            if ($gebruiker->soortId < 2) {
                redirect('Home/toonStartScherm');
            }
        }
    }
    
    /**
    * beginscherm om gebruiker toe te voegen
    */
    public function index($personeelsfeestId) {
        $data['titel']  = 'Gebruiker toevoegen';
        $gebruiker = $this->authex->getDeelnemerInfo();
        $data['gebruiker'] = $gebruiker;
        $data['personeelsfeest'] = $personeelsfeestId;
        $data['errorMessage'] = "Er bestaat al een gebruiker met deze mail!";
        $data['error'] = $this->error;
        
        /**
         * checken of de gebruiker een organisator of personeelslid is
         */
        $data['soortId'] = $gebruiker->soortId;

        $partials = array('inhoud' => 'Gebruiker toevoegen/gebruikerToevoegen', 'header' => 'main_header', 'footer' => 'main_footer');
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
        $id = $this->Deelnemer_model->insert($deelnemer);
        
        /**
         * Alleen als de gebruiker succesvol is toegevoegd sturen we een mail
         */
        if($id != null){
            $encryptedId = sha1($id);
        
            /**
            * Mail sturen
            */
            $this->stuurMail($email, "<p>Hey $voornaam</p><br/><p>U bent nu geregistreerd op de applicatie Personeelsfeest.</p><p>Inloggen kan met deze gegevens:</p><br/><p>- email: $email</p><br/><p>- wachtwoord: $wachtwoord</p>"
                . "<br/><p>Klik op onderstaande link om in te loggen</p><br/><p>" . base_url() . "index.php/Home/aanmelden?id=$encryptedId&email=$email</p>", "Registratie personeelfeest");
            
            $this->error = false;
        }else{
            $this->error = true;
        }
        
        /**
         * Bij error geven we foutmelding, anders success melding
         */
        if($this->error){
            $this->index($personeelsfeestId);
        }else{
            /**
            * Melding weergeven
            */
            $data["titel"] = "Succes!";
            $data["gebruiker"] = $this->authex->getDeelnemerInfo();
            $data["message"] = "Gebruiker is toegevoegd!";
            $data['personeelsfeest'] = $personeelsfeestId;
            $data['refer'] = "Personeelslid/GebruikerToevoegen/index/$personeelsfeestId";
            
            $partials = array('inhoud' => 'message', 'header' => 'main_header', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
    }
    
    /**
     * Mail versturen
     * @param $geadresseerde
     * @param $boodschap
     * @param $titel
     * @return als de mail verstuurd is: true, als er problemen waren: false
     */
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
     * Wachtwoord genereren voor gebruikers
     */
    function wachtwoordGenereren() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $wachtwoord = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $wachtwoord[] = $alphabet[$n];
        }
        return implode($wachtwoord);
    }
    
    public function wachtwoordVeranderen(){
        $oud = $this->input->post('oud');
        $nieuw = $this->input->post('nieuw');
        $bevestig = $this->input->post('bevestig');
        $personeelsfeest = $this->input->post('personeelsfeestId');
        $gebruiker = $this->authex->getDeelnemerInfo();
        $error = 0;
        $errorMessage = "d";
        
        if($nieuw == $bevestig){
            if (password_verify($oud, $gebruiker->wachtwoord)){ 
                $gebruiker->wachtwoord = password_hash($nieuw, PASSWORD_DEFAULT); 
                $this->Deelnemer_model->update($gebruiker);
                
                $encryptedId = sha1($gebruiker->id);
                $this->stuurMail($gebruiker->email, "<p>Hey $gebruiker->voornaam</p><br/><p>U wachtwoord op de applicatie Personeelsfeest is verandert.</p><p>Inloggen kan vanaf nu met deze gegevens:</p><br/><p>- email: $gebruiker->email</p><br/><p>- wachtwoord: $nieuw</p>"
                . "<br/><p>Klik op onderstaande link om in te loggen</p><br/><p>" . base_url() . "index.php/Home/aanmelden?id=$encryptedId&email=$gebruiker->email</p>", "Registratie personeelfeest");
                
                $error = true;
                $errorMessage = "Wacthwoord verandert er is een mail met confirmatie verstuurd";
            }else{
                $error = true;
                $errorMessage = 'Wachtwoord klopt niet';
            }
        }else{
            $error = true;
            $errorMessage = 'Nieuwe wachtwoorden komen niet overeen';
        }
        
        redirect("Home/account/$personeelsfeest/$error/$errorMessage");
    }
} 