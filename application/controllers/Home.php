<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    // +----------------------------------------------------------
    // | Personeelsfeest
    // +----------------------------------------------------------
    // | Home controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------


    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['titel'] = 'Personeelsfeest';

        $partials = array('inhoud' => 'homepage', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

}

