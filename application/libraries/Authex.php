<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authex {

    /**
     * @author: Wim Naudts
     */

    public function __construct() {
        $CI = & get_instance();

        $CI->load->model('Deelnemer_model');
    }
    
    function meldAan($email, $wachtwoord, $personeelsfeestId) {
        $CI = & get_instance();

        $deelnemer = $CI->Deelnemer_model->getDeelnemer($email, $wachtwoord, $personeelsfeestId);

        if ($deelnemer == null) {
            return false;
        } else {
            $CI->session->set_userdata('deelnemer_id', $deelnemer->id);
            return true;
        }
    }

    function getDeelnemerInfo() {
        $CI = & get_instance();

        if (!$this->isAangemeld()) {
            return null;
        } else {
            $id = $CI->session->userdata('deelnemer_id');
            return $CI->Deelnemer_model->get($id);
        }
    }

    function isAangemeld() {
        $CI = & get_instance();

        if ($CI->session->has_userdata('deelnemer_id')) {
            return true;
        } else {
            return false;
        }
    }

    function meldAf() {
        $CI = & get_instance();

        $CI->session->unset_userdata('deelnemer_id');
    }
}
