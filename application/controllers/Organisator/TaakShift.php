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
    
    function index($taakId, $doId) {
        echo $taakId . $doId;
    }
    
    function opslaan($doId) {
        redirect("/taak/index/$doId");
    }
    
    function annuleren($doId) {
        redirect("/taak/index/$doId");
    }
}
