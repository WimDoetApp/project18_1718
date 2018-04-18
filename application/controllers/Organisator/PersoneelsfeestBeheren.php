<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PersoneelsfeestBeheren extends CI_Controller
{

    // +----------------------------------------------------------
    // | Personeelsfeest
    // +----------------------------------------------------------
    // | PersoneelsfeestBeheren controller
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------


    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');
    }

    public function index()
    {
        $this->load->model('Personeelsfeest_model');

        $data['titel'] = 'Instellingen';
        $data['data'] = $this->Personeelsfeest_model->getLaatstePersoneelsfeest();
        $data['exporteren'] = $this->Personeelsfeest_model->getJarenPersoneelsfeest();

        $partials = array('inhoud' => 'Personeelsfeest beheren/personeelsfeestBeheren', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function toonStartScherm($gebruiker)
    {
        $data['titel'] = 'Personeelsfeest';
        $data['gebruiker'] = $gebruiker;

        $partials = array('inhoud' => 'startScherm', 'header' => 'main_header', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    function getEmptyDagonderdeel($personeelsfeestId)
    {
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

    public function nieuwPersoneelsfeest($id)
    {
        $this->load->model('Personeelsfeest_model');

        /**
         * Nieuw personeelsfeest aanmaken
         */
        $personeelsfeest = new stdClass();
        $personeelsfeest->id = $id + 1;
        $personeelsfeest->datum = '00:00:00';
        $personeelsfeest->inschrijfDeadline = '00:00:00';

        $this->Personeelsfeest_model->insertPersoneelsfeest($personeelsfeest);

        if (isset($_POST['nieuwDagonderdeel'])) {
            $dagonderdelen = $this->Personeelsfeest_model->getDagonderdelenVanPersoneelsfeest($id);
            foreach ($dagonderdelen as $dagonderdeel) {
                $dagonderdeel->personeelsfeestId += 1;
                $this->Personeelsfeest_model->insertDagonderdeel($dagonderdeel);
            }
        } else {
            var_dump("leeg");
        }
        if (isset($_POST['nieuwOrganisatoren'])) {
            $organisatoren = $this->Personeelsfeest_model->getOrganisatorenVanPersoneelsfeest($id);

            foreach ($organisatoren as $organisator) {
                $organisator->personeelsfeestId += 1;
                $this->Personeelsfeest_model->insertOrganisatoren($organisator);
            }
        } else {
            var_dump("leeg");
        }

        $this->index();
    }

    public function importeer()
    {
        $target_dir = "../assets/uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $csvFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        /**
         * Check if file already exists
         */
        if (file_exists($target_file)) {
            echo "Sorry, deze bestandsnaam bestaat al";
            $uploadOk = 0;
        }

        /**
         * Check file size
         */
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        /**
         * Check file extension
         */
        if ($csvFileType != "csv") {
            echo "Sorry, gelieve enkel een csv bestand te uploaden.";
            $uploadOk = 0;
        }

        /**
         * Check if $uploadOk is set to 0 by an error
         */
        if ($uploadOk == 0) {
            echo "Sorry, je bestand werd niet geupload.";

        } /**
         * if everything is ok, try to upload file
         */
        else {
            $bestand = basename($_FILES["fileToUpload"]["name"]);
            var_dump($_FILES["fileToUpload"]["tmp_name"], $bestand);
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $bestand)) {
                echo "Het bestand " . $bestand . " is succesvol geupload.";

                /**
                 *  Open and read file
                 */
                $myfile = fopen($bestand, "r") or die("Unable to open file!");

                $data = fread($myfile, filesize("$bestand"));

                $aantalrecords = substr_count($data, ';');
                $startpositiesubstring = 0;
                for ($i = 1; $i < $aantalrecords; $i++) {

                    $startpositiemail = strpos($data, ';', $startpositiesubstring);
                    $naam = substr($data, $startpositiesubstring, $startpositiemail);
                    $startpositienaam = strpos($data, ' ',$startpositiesubstring);
                    $voornaam = substr($naam, 0, $startpositienaam);
                    $naam = substr($naam, $startpositienaam + 1, $startpositiemail - $startpositienaam);

                    var_dump($naam, $voornaam, $startpositiesubstring);
                    $startpositiesubstring = strpos($data, ' ', $startpositiemail);
                }



                var_dump($naam, $voornaam);

                fclose($myfile);
            } else {
                echo "Sorry, er was een fout tijdens het uploaden van je bestand.";
            }
        }


    }
}
