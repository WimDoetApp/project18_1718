<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PersoneelsfeestBeheren extends CI_Controller
{

    /**
     * Controller Personeelsfeest Beheren
     * @author Bram Van Bergen, Wim Naudts
     */


    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');

        /**
         * Kijken of de gebruiker de juiste rechten heeft
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
     */
    public $error = false;
    public $errorMessage = "";

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
        date_default_timezone_set("Europe/Brussels");
        $personeelsfeestId = $this->input->post('personeelsfeestId');
        /**
         * Nieuw personeelsfeest aanmaken
         */

        $strdatum = $_POST['datum'];
        $datum = date('Y-m-d', strtotime($strdatum));

        $strdeadline = $_POST['deadline'];
        $deadline = date('Y-m-d', strtotime($strdeadline));
        
        if(strtotime($strdatum) < time()){
            $this->error = true;
            $this->errorMessage = 'Datum van het personeelsfeest kan niet in het verleden liggen!';
        }
        
        if(strtotime($strdeadline) > strtotime($strdatum)){
            $this->error = true;
            $this->errorMessage = 'Datum van de deadline voor inschrijven kan niet na het personeelfeest liggen!';
        }
        
        if(!$this->error){
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
                        $nieuwDagonderdeel->personeelsfeestId = $id+1;
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
                        $nieuweOrganisator->personeelsfeestId = $id+1;
                        $this->Personeelsfeest_model->insertOrganisatoren($nieuweOrganisator);
                    }
                }

                $hoofdorganisatoren = $this->Personeelsfeest_model->getHoofdOrganisatorenVanPersoneelfeest($id);
                $nieuweHoofdOrganisator = new stdClass();

                foreach($hoofdorganisatoren as $hoofdorganisator){
                    $nieuweHoofdOrganisator->naam = $hoofdorganisator->naam;
                    $nieuweHoofdOrganisator->voornaam = $hoofdorganisator->voornaam;
                    $nieuweHoofdOrganisator->email = $hoofdorganisator->email;
                    $nieuweHoofdOrganisator->wachtwoord = $hoofdorganisator->wachtwoord;
                    $nieuweHoofdOrganisator->soortId = $hoofdorganisator->soortId;
                    $nieuweHoofdOrganisator->personeelsfeestId = $id+1;
                    $this->Personeelsfeest_model->insertOrganisatoren($nieuweHoofdOrganisator);
                }
            } 
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
                    $startpositienaam = strpos($data, ' ', $startpositiesubstring);
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
