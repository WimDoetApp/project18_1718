<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PersoneelsfeestBeheren extends CI_Controller
{

    /**
     * @class PersoneelsfeestBeheren
     * @brief Controller voor de usecase Personeelsfeest Beheren (admin-panel)
     * @author Bram Van Bergen, Wim Naudts
     */

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');

        /**
         * Kijken of de gebruiker de juiste rechten heeft
         * @see Authex::isAangemeld()
         * @see Authex::getDeelnemerInfo()
         */
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
     * Als deze variable true is, laten we een errormessage zien op de pagina personeelsfeest beheren
     * @param $error bool die bepaald of we een errormessage moeten laten zien
     * @param $errorMessage de message zelf
     */
    public $error = false;
    public $errorMessage = "";

    /**
     * Admin-panel weergeven
     * @see Personeelsfeest_model::getLaatstePersoneelsfeest()
     * @see Personeelsfeest_model::getJarenPersoneelsfeest()
     * @see Authex::getDeelnemerInfo()
     * @see Personeelsfeest_model::getLaatsteId()
     * @see Personeelsfeest beheren/personeelsfeesetBeheren.php
     */
    public function index()
    {
        $this->load->model('Personeelsfeest_model');

        $data['titel'] = 'Instellingen';
        $data['data'] = $this->Personeelsfeest_model->getLaatstePersoneelsfeest();
        $data['exporteren'] = $this->Personeelsfeest_model->getJarenPersoneelsfeest();
        $data['gebruiker'] = $this->authex->getDeelnemerInfo();
        $data['personeelsfeest'] = $this->Personeelsfeest_model->getLaatsteId()->id;
        $data['error'] = $this->error;
        $data['errorMessage'] = $this->errorMessage;


        $partials = array('inhoud' => 'Personeelsfeest beheren/personeelsfeestBeheren', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Een leeg dagonderdeel aanmaken
     * @param $personeelsfeestId id van het huidige personeelsfeest
     */
    function getEmptyDagonderdeel($personeelsfeestId)
    {
        /**
         * Leeg dagonderdeel aanmaken
         */
        $dagonderdeel = new stdClass();
        $dagonderdeel->starttijd = '00:00:00';
        $dagonderdeel->eindtijd = '00:00:00';
        $dagonderdeel->naam = 'nieuw dagonderdeel';
        $dagonderdeel->personeelsfeestId = $personeelsfeestId;
        $dagonderdeel->heeftTaak = '0';
        $dagonderdeel->vrijwilligerMeeDoen = '0';
        $dagonderdeel->locatieId = 1;

        $this->load->model('DagOnderdeel_model');
        $this->dagonderdeel_model->insert($dagonderdeel);
    }

    /**
     * Functie om een nieuwe personeelsfeest aan te maken
     * @param $id id van het huidige personeelsfeest
     * @see Personeelsfeest_model::insertPersoneelsfeest()
     * @see Personeelsfeest_model::getDagonderdelenVanPersoneelsfeest()
     * @see Personeelsfeest_model::insertDagonderdeel()
     * @see Personeelsfeest_model::getOrganisatorenVanPersoneelsfeest()
     * @see Personeelsfeest_model::insertOrganisatoren()
     * @see Personeelsfeest_model::getHoofdOrganisatorenVanPersoneelfeest()
     */
    public function nieuwPersoneelsfeest($id)
    {
        $this->load->model('Personeelsfeest_model');
        date_default_timezone_set("Europe/Brussels");
        $personeelsfeestId = $this->input->post('personeelsfeestId');
        /**
         * Nieuw personeelsfeest aanmaken
         */

        $strdatum = $_POST['datum'];
        $datum = date('Y-m-d', strtotime($strdatum));

        $strdeadline = $_POST['deadline'];
        $deadline = date('Y-m-d', strtotime($strdeadline));

        if (strtotime($strdatum) < time()) {
            $this->error = true;
            $this->errorMessage = 'Datum van het personeelsfeest kan niet in het verleden liggen!';
        }

        if (strtotime($strdeadline) > strtotime($strdatum)) {
            $this->error = true;
            $this->errorMessage = 'Datum van de deadline voor inschrijven kan niet na het personeelfeest liggen!';
        }

        if (!$this->error) {
            $personeelsfeest = new stdClass();
            $personeelsfeest->id = $personeelsfeestId;
            $personeelsfeest->datum = $datum;
            $personeelsfeest->inschrijfDeadline = $deadline;

            if (isset($_POST['knopDatum'])) {
                $this->Personeelsfeest_model->update($personeelsfeest);
            } else if (isset($_POST['knop'])) {
                $personeelsfeest = new stdClass();
                $personeelsfeest->id = $id + 1;
                $personeelsfeest->datum = $datum;
                $personeelsfeest->inschrijfDeadline = $deadline;

                $this->Personeelsfeest_model->insertPersoneelsfeest($personeelsfeest);

                $nieuwDagonderdeel = new stdClass();
                if (isset($_POST['nieuwDagonderdeel'])) {
                    $dagonderdelen = $this->Personeelsfeest_model->getDagonderdelenVanPersoneelsfeest($id);
                    foreach ($dagonderdelen as $dagonderdeel) {
                        $nieuwDagonderdeel->starttijd = $dagonderdeel->starttijd;
                        $nieuwDagonderdeel->eindtijd = $dagonderdeel->eindtijd;
                        $nieuwDagonderdeel->naam = $dagonderdeel->naam;
                        $nieuwDagonderdeel->heeftTaak = $dagonderdeel->heeftTaak;
                        $nieuwDagonderdeel->vrijwilligerMeeDoen = $dagonderdeel->vrijwilligerMeeDoen;
                        $nieuwDagonderdeel->locatieId = $dagonderdeel->locatieId;
                        $nieuwDagonderdeel->personeelsfeestId = $id + 1;
                        $this->Personeelsfeest_model->insertDagonderdeel($nieuwDagonderdeel);
                    }
                }

                $nieuweOrganisator = new stdClass();
                if (isset($_POST['nieuwOrganisatoren'])) {
                    $organisatoren = $this->Personeelsfeest_model->getOrganisatorenVanPersoneelsfeest($id);

                    foreach ($organisatoren as $organisator) {
                        $nieuweOrganisator->naam = $organisator->naam;
                        $nieuweOrganisator->voornaam = $organisator->voornaam;
                        $nieuweOrganisator->email = $organisator->email;
                        $nieuweOrganisator->wachtwoord = $organisator->wachtwoord;
                        $nieuweOrganisator->soortId = $organisator->soortId;
                        $nieuweOrganisator->personeelsfeestId = $id + 1;
                        $this->Personeelsfeest_model->insertOrganisatoren($nieuweOrganisator);
                    }
                }

                $hoofdorganisatoren = $this->Personeelsfeest_model->getHoofdOrganisatorenVanPersoneelfeest($id);
                $nieuweHoofdOrganisator = new stdClass();

                foreach ($hoofdorganisatoren as $hoofdorganisator) {
                    $nieuweHoofdOrganisator->naam = $hoofdorganisator->naam;
                    $nieuweHoofdOrganisator->voornaam = $hoofdorganisator->voornaam;
                    $nieuweHoofdOrganisator->email = $hoofdorganisator->email;
                    $nieuweHoofdOrganisator->wachtwoord = $hoofdorganisator->wachtwoord;
                    $nieuweHoofdOrganisator->soortId = $hoofdorganisator->soortId;
                    $nieuweHoofdOrganisator->personeelsfeestId = $id + 1;
                    $this->Personeelsfeest_model->insertOrganisatoren($nieuweHoofdOrganisator);
                }
            }
        }

        $this->index();
    }

    /**
     * Personeelsleden of vrijwilligers via een csv bestand toevoegen als gebruikers
     * @param $personeelsfeestId id van het huidige personeelsfeest
     */
    public function importeer($personeelsfeestId)
    {
        $this->load->model('Personeelsfeest_model');

        $target_dir = "./assets/uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $csvFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $message = "";

        /**
         * Check file extension
         */
        if ($csvFileType != "csv") {
            $message .= "Oeps, het lijkt erop dat je geen csv bestand uploadde.<br />";
            $uploadOk = 0;
        }

        /**
         * Check if $uploadOk is set to 0 by an error
         */
        if ($uploadOk == 0) {
            $message .= "Sorry, je bestand werd niet geupload.<br />";

        }

        /**
         * if everything is ok, try to upload file
         */
        else {
            $bestand = basename($_FILES["fileToUpload"]["name"]);
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $bestand)) {
                $message .= "Het bestand " . $bestand . " is succesvol geupload. \n";

                /**
                 *  Open and read file
                 */

                $cellen = str_replace("\n", ";", file_get_contents($bestand));
                $csv = explode(";", $cellen);
                $teller = 0;
                $voornamen = array();
                $namen = array();
                $emails = array();

                if (end($csv) == "") {
                    array_pop($csv);
                }

                foreach ($csv as $cel) {
                    switch ($teller) {
                        case 0:
                            array_push($voornamen, $cel);
                            $teller++;
                            break;
                        case 1:
                            array_push($namen, $cel);
                            $teller++;
                            break;
                        case 2:
                            array_push($emails, $cel);
                            $teller = 0;
                            break;
                    }
                }

                for ($i = 0; $i < count($voornamen); $i++) {
                    $deelnemer = new stdClass();
                    $deelnemer->soortId = $_POST['importeren'];
                    $deelnemer->naam = $namen[$i];
                    $deelnemer->voornaam = $voornamen[$i];
                    $deelnemer->email = $emails[$i];
                    $deelnemer->personeelsfeestId = $personeelsfeestId;
                    $this->registreer($deelnemer);
                }

                /**
                 * Succesmelding weergeven
                 */
                $data["titel"] = "Succes!";
                $data["gebruiker"] = $this->authex->getDeelnemerInfo();
                $data["message"] = "Alle gebruikers zijn succesvol toegevoegd!";
                $data['personeelsfeest'] = $personeelsfeestId;
                $data['refer'] = "Organisator/PersoneelsfeestBeheren/index/$personeelsfeestId";

                $partials = array('inhoud' => 'message', 'header' => 'main_header', 'footer' => 'main_footer');
                $this->template->load('main_master', $partials, $data);

                $message = "";
            } else {
                $message .= "Oeps, er was een fout tijdens het uploaden van je bestand.<br />";
            }
        }

        if ($message != "") {
            /**
             * Foutmelding weergeven
             */
            $data["titel"] = "Fout!";
            $data["gebruiker"] = $this->authex->getDeelnemerInfo();
            $data["message"] = $message;
            $data['personeelsfeest'] = $personeelsfeestId;
            $data['refer'] = "Organisator/PersoneelsfeestBeheren/index/$personeelsfeestId";

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
    private function stuurMail($geadresseerde, $boodschap, $titel)
    {
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
    function wachtwoordGenereren()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $wachtwoord = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $wachtwoord[] = $alphabet[$n];
        }
        return implode($wachtwoord);
    }

    /**
     * registeren
     */
    public function registreer($deelnemer)
    {
        /**
         * Wachtwoord generen en toevoegen aan deelnemer
         */
        $wachtwoord = $this->wachtwoordGenereren();
        $deelnemer->wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

        $id = $this->Deelnemer_model->insert($deelnemer);

        /**
         * Alleen als de gebruiker succesvol is toegevoegd sturen we een mail
         */
        if ($id != null) {
            $encryptedId = sha1($id);

            /**
             * Mail sturen
             */
            $this->stuurMail($deelnemer->email,
                "<p>Hey $deelnemer->voornaam</p><br/>
                <p>U bent nu geregistreerd op de applicatie Personeelsfeest.</p>
                <p>Inloggen kan met deze gegevens:</p><br/>
                <p>- email: $deelnemer->email</p><br/>
                <p>- wachtwoord: $deelnemer->wachtwoord</p><br/>
                <p>Klik op onderstaande link om in te loggen</p>"
                . "<br/><p>"
                . base_url()
                . "index.php/Home/aanmelden?id=$encryptedId&email=$deelnemer->email</p>",
                "Registratie personeelfeest");
        }
    }
}
