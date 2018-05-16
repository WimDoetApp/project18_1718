<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authex {

    /**
     * @class Authex
     * @brief Klasse om tijdens een sessie een gebruiker in te loggen en ingelogd te houden
     * @author: Wim Naudts
     */

    public function __construct() {
        $CI = & get_instance();

        $CI->load->model('Deelnemer_model');
    }
    
    /**
     * Aanmelden van een gebruiker
     * @param $email ingegeven email
     * @param $wachtwoord ingegeven wacthwoord
     * @param $personeelsfeestId id van het huidige personeelsfeest
     * @see Deelnemer_model::getDeelnemer()
     * @return boolean true als de deelnemer succesvol is ingelogd, anders false
     */
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

    /**
     * Info ophalen over de gebruiker die op dit moment is ingelogd
     * @see Deelnemer_model::get()
     * @return de gebruiker, null als er niemand is ingelogd
     */
    function getDeelnemerInfo() {
        $CI = & get_instance();

        if (!$this->isAangemeld()) {
            return null;
        } else {
            $id = $CI->session->userdata('deelnemer_id');
            return $CI->Deelnemer_model->get($id);
        }
    }

    /**
     * Checkt of er iemand is aangemeld
     * @return boolean true als er iemand is aangemeld, anders false
     */
    function isAangemeld() {
        $CI = & get_instance();

        if ($CI->session->has_userdata('deelnemer_id')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Meld de aangemelde gebruiker af
     */
    function meldAf() {
        $CI = & get_instance();

        $CI->session->unset_userdata('deelnemer_id');
    }
}
