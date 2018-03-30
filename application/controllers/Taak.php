<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Taak
 *
 * @author yen
 */
class Taak extends CI_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    function index($sw, $id) {
        $this->load->model('crud_model');
        $data['taken'] = $this->crud_model->getAll('taak');
        
        $data['titel'] = 'Tennis';
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        $partials = array('inhoud' => 'taakbeheren/overzichttaken', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
}
