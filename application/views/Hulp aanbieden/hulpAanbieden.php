<input type="hidden" id="personeelsfeestId" data-id="<?php echo $personeelsfeest ?>"/>
<br/>
<table class='table-striped table'>
    <thead>
    <tr>
        <th>Dagonderdeel</th>
        <th>Inschrijven als helper</th>
        <th>Aantal ingeschreven</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($dagonderdelen as $dagonderdeel) {
        $ingeschreven = 0;
        $maxAantal = 0;
        $soort = "";
        echo "<tr>";
        /**
         * Contoleren of het dagonderdeel een taak heeft.
         * Indien dit het geval is wordt het aantal plaatsen en het maximum aantal plaatsen geteld en wordt de taak teruggegeven.
         * Indien dit niet het geval is wordt de optie weergegeven
         */
        if ($dagonderdeel->heeftTaak == "1") {
            foreach ($dagonderdeel->taken as $taak) {
                foreach ($taak->shiften as $shift) {
                    $ingeschreven += $shift->aantalIngeschreven;
                    $maxAantal += $shift->aantalPlaatsen;
                    $soort = "taak";
                }
            }
            echo "<td>$dagonderdeel->naam</td>";
        } else {
            foreach ($dagonderdeel->opties as $optie) {
                foreach ($optie->taak as $taak) {
                    foreach ($taak->shiften as $shift) {
                        $ingeschreven += $shift->aantalIngeschreven;
                        $soort = "optie";
                    }
                }
                echo "<td>$optie->naam</td>";
                $maxAantal = $optie->maximumAantalPlaatsen;
            }
        }

        /**
         * Controleren hoeveel personen er zijn ingeschreven
         */
        if ($maxAantal != 0) {
            if ($ingeschreven >= $maxAantal) {
                echo "<td><button type='submit' href='' class='btn btn-danger' disabled='true'>Volzet</button></td>";
            } else if ((($ingeschreven / $maxAantal) * 100) > 75) {
                echo "<td><button type='submit' value='$dagonderdeel->id' data-toggle='modal' data-target='#modalInschrijven' class='buttonInschrijven btn btn-warning $soort $dagonderdeel->id'>Hulp aanbieden</input></td>";
            } else {
                echo "<td><button type='submit' value='$dagonderdeel->id' data-toggle='modal' data-target='#modalInschrijven' class='buttonInschrijven btn btn-success $soort $dagonderdeel->id'>Hulp aanbieden</input></td>";
            }
            echo "<td>" . $ingeschreven . "/" . $maxAantal . "</td></tr>";
        }  else {
            echo "<td><button type='submit' value='$dagonderdeel->id' data-toggle='modal' data-target='#modalInschrijven' class='buttonInschrijven btn btn-success $soort $dagonderdeel->id'>Hulp aanbieden</input></td>";
            echo "<td>Geen plaatsbeperking</td></tr>";
        }

    }
    ?>
    </tbody>
</table>
<?php
echo smallDivAnchor('home/index', "Terug", 'class="btn btn-info"');
?>

<!-- Modal -->
<div class="modal fade" id="modalInschrijven" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Taak</th>
                        <th>Omschrijving</th>
                        <th>Shift</th>
                        <th>Bied je hulp aan</th>
                    </tr>
                    </thead>
                    <tbody id="body">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Annuleren</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(".buttonInschrijven").click(function () {
        var id = $(this).val();
        var personeelsfeestId = $('#personeelsfeestId').attr('data-id');
        haalKnopOp(id, personeelsfeestId);

    });

    /**
     * Kijkt op welke knop er geklikt is en opent een venster waarop je kan inschrijven voor een shift indien deze nog niet volzet is.
     * @param id Het id van de knop waarop geklikt werd.
     */
    function haalKnopOp(id, personeelsfeestId) {
        $.ajax({
            type: "GET",
            url: site_url + "/Vrijwilliger/HulpAanbieden/shiftenTonen",
            data: {
                id: id,
                personeelsfeestId: personeelsfeestId
            },
            success: function (result) {
                try {
                    $("#body").empty();
                    var dagonderdeel = jQuery.parseJSON(result);
                    var body = document.getElementById("body");
                    $("#modalTitle").append(dagonderdeel.naam);

                    if ($("." + id).hasClass("taak")) {
                        $.each(dagonderdeel, function (index, obj) {
                            $.each(obj.taken, function (index, taken) {
                                $.each(taken.shiften, function (index, shiften) {
                                    var tr = document.createElement('tr');
                                    var tdTaken = document.createElement('td');
                                    var tdOmschrijving = document.createElement('td');
                                    var tdShiften = document.createElement('td');
                                    var tdInschrijven = document.createElement('td');
                                    var knopInschrijven = document.createElement("button");
                                    var shift = shiften.begintijd.substr(0, 5) + " - " + shiften.eindtijd.substr(0, 5);

                                    knopInschrijven.type = 'button';
                                    knopInschrijven.value = shiften.id;
                                    knopInschrijven.name = "inschrijven";
                                    knopInschrijven.className = "btn btn-default inschrijven";
                                    knopInschrijven.append("Inschrijven");
                                    tdShiften.append(shift);
                                    tdTaken.append(taken.naam);
                                    tdOmschrijving.append(taken.beschrijving);
                                    tdInschrijven.append(knopInschrijven);

                                    tr.appendChild(tdTaken);
                                    tr.appendChild(tdOmschrijving);
                                    tr.appendChild(tdShiften);
                                    tr.appendChild(tdInschrijven);
                                    body.appendChild(tr);
                                });
                            });
                        });
                    }
                    else if ($("." + id).hasClass("optie")) {
                        $.each(dagonderdeel, function (index, obj) {
                            $.each(obj.opties, function (index, opties) {
                                $.each(opties.taak, function (index, taken) {
                                    $.each(taken.shiften, function (index, shiften) {
                                        var tr = document.createElement('tr');
                                        var tdTaken = document.createElement('td');
                                        var tdOmschrijving = document.createElement('td');
                                        var tdShiften = document.createElement('td');
                                        var tdInschrijven = document.createElement('td');
                                        var knopInschrijven = document.createElement("button");
                                        var shift = shiften.begintijd.substr(0, 5) + " - " + shiften.eindtijd.substr(0, 5);

                                        knopInschrijven.type = 'button';
                                        knopInschrijven.value = shiften.id;
                                        knopInschrijven.name = "inschrijven";
                                        knopInschrijven.className = "btn btn-default inschrijven";
                                        knopInschrijven.append("Inschrijven");
                                        tdShiften.append(shift);
                                        tdTaken.append(taken.naam);
                                        tdOmschrijving.append(taken.beschrijving);
                                        tdInschrijven.append(knopInschrijven);

                                        tr.appendChild(tdTaken);
                                        tr.appendChild(tdOmschrijving);
                                        tr.appendChild(tdShiften);
                                        tr.appendChild(tdInschrijven);
                                        body.appendChild(tr);
                                    });
                                });
                            });
                        });
                    }
                } catch (error) {
                    alert("-- ERROR IN JSON -- \n" + result);
                }
            }, error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX -- \n\n" + xhr.responseText);
            }
        });
    }

    $("#body").on("click", ".inschrijven", function () {
        var id = $(this).val();
        var personeelsfeestId = $('#personeelsfeestId').attr('data-id');
        $('#modalInschrijven .close').click();
        window.location.href = site_url + "/Vrijwilliger/HulpAanbieden/inschrijven?id=" + id + "&personeelsfeestId=" + personeelsfeestId;
    });
</script>