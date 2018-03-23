<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authex {

    /**
     * Author: Wim Naudts
     */

    public function __construct() {
        $CI = & get_instance();

        $CI->load->model('deelnemer_model');
    }
    
    function meldAan($email, $wachtwoord) {
        // gebruiker aanmelden met opgegeven email en wachtwoord
        $CI = & get_instance();

        $deelnemer = $CI->deelnemer_model->getDeelnemer($email, $wachtwoord);

        if ($deelnemer == null) {
            return false;
        } else {
            $CI->session->set_userdata('deelnemer_id', $deelnemer->id);
            return true;
        }
    }

    function getDeelnemerInfo() {
        // geef gebruiker-object als gebruiker aangemeld is
        $CI = & get_instance();

        if (!$this->isAangemeld()) {
            return null;
        } else {
            $id = $CI->session->userdata('deelnemer_id');
            return $CI->deelnemer_model->get($id);
        }
    }

    function isAangemeld() {
        // gebruiker is aangemeld als sessievariabele deelnemer_id bestaat
        $CI = & get_instance();

        if ($CI->session->has_userdata('deelnemer_id')) {
            return true;
        } else {
            return false;
        }
    }

    function meldAf() {
        // afmelden, dus sessievariabele wegdoen
        $CI = & get_instance();

        $CI->session->unset_userdata('deelnemer_id');
    }

    function registreer($naam, $email, $wachtwoord) {
        // nieuwe gebruiker registreren als email nog niet bestaat
        $CI = & get_instance();

        if ($CI->gebruiker_model->controleerEmailVrij($email)) {
            $id = $CI->deelnemer_model->registreer($naam, $email, $wachtwoord);
            return $id;
        } else {
            return 0;
        }
    } 
}
