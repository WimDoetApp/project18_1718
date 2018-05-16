<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class InformatieVersturen extends CI_Controller {

    // +----------------------------------------------------------
    // | Informatie versturen - Jari
    // +----------------------------------------------------------
    // | Foto's beheren controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

    /**
     * Controller Informatie versturen
     * @author Jari Mathé, Wim Naudts
     */

    public function __construct() {
        parent::__construct();
        /**
         * Laad de helper voor formulieren
        */
        $this->load->helper('form');
        $this->load->helper('html');
        date_default_timezone_set('Europe/Brussels');
        
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
    * Open de index pagina en laat informatie zien van emailsjabloon 
    */
    public function index() {
        $data['titel']  = "Informatie versturen";
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Personeelsfeest_model');
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;

       
        $this->load->model('CRUD_Model');
        $data['mails'] = $this->CRUD_Model->getAll('emailsjabloon');
        
        $partials = array('inhoud' => 'Informatie versturen/emailOverzicht' , 'header' => 'main_header', 'footer' => 'main_footer');
        $error = array('error' => ' ' );
        $this->template->load('main_master', $partials, $data, $error);
    }
    
    /**
    * Pagina met overzicht van alle mails in de database
    */
    public function emailOpstellenPagina() {
        $data['titel']  = "Email opstellen";
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Personeelsfeest_model');
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;
        
        $this->load->model('CRUD_Model');
        $data['soorten'] = $this->CRUD_Model->getAll('soort');
        
        $partials = array('inhoud' => 'Informatie versturen/emailOpstellen' , 'header' => 'main_header', 'footer' => 'main_footer');
        $error = array('error' => ' ' );
        $this->template->load('main_master', $partials, $data, $error);
    }
    
    /**
    * registreer de mail in de database en roep stuurMail functie op
    */
    public function registreerMail(){
        $info = new stdClass();
            
        $onderwerp = $this->input->post('onderwerp');
        $mail = $this->input->post('mail');
        $soort = $this->input->post('filteren');
        
        $info->onderwerp = $onderwerp;
        $info->sjabloon = $mail;
        $info->soortId = $soort;
       
        
        $this->load->model('CRUD_Model');
        $this->CRUD_Model->add($info, 'emailsjabloon');

        redirect("Organisator/InformatieVersturen/verzondenPagina");
    }
    
    /**
    * Stuur een mail 
    */
    public function stuurMail($id) {
        $this->load->model('EmailSjabloon_model');
        $mail = $this->EmailSjabloon_model->get($id);
        $onderwerp = $mail->onderwerp;
        $sjabloon = $mail->sjabloon;
        $soort = $mail->soortId;
        
        $this->load->model('Deelnemer_model');

        $deelnemers = $this->Deelnemer_model->getBySoort($soort);
        $lijst[] = "";
        
        foreach($deelnemers as $deelnemer){
            array_push($lijst, $deelnemer->email);
        }
        $lijst = implode(",", $lijst);
        
        $this->load->library('email');
        $this->email->from('teamachtien@gmail.com', 'Team 18');
        $this->email->to($lijst);
        $this->email->cc('');
        $this->email->subject($onderwerp);
        $this->email->message($sjabloon);
                    
        if (!$this->email->send()) {
            show_error($this->email->print_debugger());
            return false;
        } else {
            $this->index();
            return true;
        }
    }
    /**
    * Verwijst naar de pagina email verzonden
    */
    public function verzondenPagina() {
        $data['titel']  = "Email verzonden";
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Personeelsfeest_model');
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;

        
        $partials = array('inhoud' => 'Informatie versturen/emailVerzonden' , 'header' => 'main_header', 'footer' => 'main_footer');
        $error = array('error' => ' ' );
        $this->template->load('main_master', $partials, $data, $error);
    }
    
    /**
    * Verwijzen naar de pagina met een waarschuwing
    */
    public function verwijderenPagina() {
        $data['titel']  = "Email verwijderen?";
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Personeelsfeest_model');
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;
        
        $id = $this->input->get('id');
        $this->load->model('CRUD_Model');
        $data['mail'] = $this->CRUD_Model->get($id,'emailsjabloon');
       
        $partials = array('inhoud' => 'Informatie versturen/emailVerwijderd' , 'header' => 'main_header', 'footer' => 'main_footer');
        $error = array('error' => ' ' );
        $this->template->load('main_master', $partials, $data, $error);
    }
    
    /**
    * De aangeduide id verwijderen  
    */
    public function verwijderMail() {
        $id = $this->input->get('id');
        $this->load->model('CRUD_Model'); 
        $this->CRUD_Model->delete($id, 'emailsjabloon');

        /**
        * Terug sturen naar de index pagina van informatie versturen
        */
        redirect('Organisator/InformatieVersturen/index');
    }
    
    /**
    * Open de pagina wijzigPagina en toon de informatie van emailsjabloon op de pagina
    */
    public function wijzigPagina() {
        $data['titel']  = "Email wijzigen";
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        
        $this->load->model('Personeelsfeest_model');
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;
        
        $id = $this->input->get('id');
        $this->load->model('CRUD_Model');
        $data['mail'] = $this->CRUD_Model->get($id,'emailsjabloon');
        
    //    $data['soorten'] = $this->CRUD_Model->get($id,'soort');
        
        $partials = array('inhoud' => 'Informatie versturen/emailWijzig' , 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
    * Wijzig de informatie
    */
    public function wijzigMail() {
        $id = $this->input->get('id');
        $this->load->model('CRUD_Model'); 
        
        $info['onderwerp'] = $this->input->post('onderwerp');
        $info['sjabloon'] = $this->input->post('mail');
        
        $this->CRUD_Model->update($id, $info, 'emailsjabloon');

        /**
        * Terug sturen naar de index pagina van informatie versturen
        */
        redirect('Organisator/InformatieVersturen/index');
    }
} 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
