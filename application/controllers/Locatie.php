<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Locatie extends CI_Controller {
    
    /**
     * Controller Locatie beheren
     * Verantwoordelijke: Yen Aarts
     */


    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
    }
    
    public function index() {
        /*Inladen van pagina*/
        $data['titel'] = 'Locaties Beheren';
        
        $this->load->model('crud_model');
        $data['locaties'] = $this->crud_model->getAll('locatie');
        
        $partials = array('inhoud' => 'LocatieBeheren/locatie_scherm', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function wijzig() {
        /*Stuur gewijzigde data naar database om de database te wijzigen*/
        $id = $this->input->post('id');
        $locatie['naam'] = $this->input->post('naam');
        $locatie['beschrijving'] = $this->input->post('beschrijving');
        
        $this->load->model('crud_model');
        $this->crud_model->update($id, $locatie, $db);
        
        $this->index();
    }
    
    public function verwijder() {
        /*Stuurt naar database id om te verwijderen*/
        $id = $this->input->post('id');
        
        $this->load->model('crud_model');
        $this->crud_model->delete($id, $db);
        
        $this->index();
    }
    
    public function voegToe() {
        /*Stuurt leeg Locatie object naar database om toe te voegen*/
        $locatie = new stdClass();
        
        $locatie->naam = "";
        $locatie->beschrijving = "";
        
        $this->load->model('crud_model');
        $this->lcrud_model->add($locatie);
        
        $this->index();
    }
    
    public function knopInput() {
        //Verwijst de actie door naar juiste methode
        //Van het formulier kan het veld (name="action") maar twee mogelijkheden hebben: "wijzig" of "verwijder"
        //ALS (name="action") -> "wijzig" IS wordt Locatie->wijzig() uitgevoerd
        //ALS (name="action") -> NIET "wijzig" IS wordt Locatie->verwijder() uitgevoerd
        $knop = $this->input->post('action');
        
        if ($knop == "wijzig") {
            $this->wijzig();
        } else {
            $this->verwijder();
        }
    }
}

