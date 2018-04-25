<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    /**
     * Controller contactpagina
     * @author: Wim Naudts
     */
    public function __construct() {
        parent::__construct();
        
        $this->load->helper('form');
        $this->load->model('Personeelsfeest_model');
        date_default_timezone_set('Europe/Brussels');
        
        /**
         * Kijken of de gebruiker de juiste rechten heeft
         */
        if (!$this->authex->isAangemeld()) {
            redirect('Home/index');
        }
    }

    /**
     * naar de contactpagina gaan
     */
    public function contact(){
        if($this->authex->isAangemeld()){
            $data['titel'] = 'Contact';
            $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;
            $data['gebruiker'] = $this->authex->getDeelnemerInfo();

            $partials = array('inhoud' => 'contact', 'header' => 'main_header', 'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
        }
    }
    
    /**
     * Gestelde vraag versturen naar de juiste persoon
     */
    public function stuurVraag(){
        $adres = $this->input->post('email');
        $onderwerp = $this->input->post('onderwerp');
        $vraag = $this->input->post('vraag');
        $ontvanger = $this->input->post('ontvanger');
        
        if($ontvanger == 'ontwikkelaar'){
            $ontvanger = 'wimnaudts@yahoo.com'; //tijdelijke mail
        }
        
        if($ontvanger == 'organisator'){
            $ontvanger = 'r0655395@student.thomasmore.be'; //tijdelijke mail
        }
        
        $boodschap = "<p>Van: $adres</p><p>$vraag</p>";
        
        $this->stuurMail($ontvanger, $boodschap, $onderwerp);
        
        /**
         * Melding weergeven
         */
        $data["titel"] = "Succes!";
        $data["gebruiker"] = $this->authex->getDeelnemerInfo();
        $data["message"] = "U vraag is succesvol verstuurd!";
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;
        $data['refer'] = "Contact/contact";
            
        $partials = array('inhoud' => 'message', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
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
}