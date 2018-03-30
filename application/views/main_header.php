<?php $soort = $gebruiker->soortId; ?>

<header id="#header">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <a class="navbar-brand" href="#">Personeelsfeest</a>
            </div>
            <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo base_url("index.php/"); ?>">Inschrijven</a></li>
                <li><a href="<?php echo base_url("index.php/"); ?>">Hulp aanbieden</a></li>
                <?php if ($soort == 1 || $soort == 2) {?>
                <li><a href="<?php echo base_url("index.php/"); ?>">Foto's bekijken</a></li>
                <?php } ?>
                
                <?php if ($soort == 2) { ?>
                <li><a href="<?php echo base_url("index.php/"); ?>">Vrijwilligers toevoegen</a></li>
                <?php } ?>
                
                <?php if ($soort == 3 || $soort == 4) { ?>
                <li><a href="<?php echo base_url("index.php/"); ?>">Overzichten</a></li>
                <li><a href="<?php echo base_url("index.php/"); ?>">Mails sturen</a></li>
                <li><a href="<?php echo base_url("index.php/"); ?>">Personeelsfeest beheren</a></li>
                <li><a href="<?php echo base_url("index.php/"); ?>">Foto's beheren</a></li>
                <?php } ?>
                
                <li><a href="<?php echo base_url("index.php/"); ?>">Adressen raadplegen</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><?php echo anchor("Home/toonStartScherm", "<span class='glyphicon glyphicon-user'></span> Welkom $gebruiker->voornaam") ?></li>
                <li><?php echo smallDivAnchor("home/afmelden", "<span class='glyphicon glyphicon-log-out'></span> Afmelden", 'class="btn btn-danger navButton"') ?></li>
            </ul>
            </div>
        </div>
    </nav>
</header>