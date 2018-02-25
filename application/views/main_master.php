<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Personeelsfeest">
        <meta name="author" content="Wim Naudts, Jari Mathé, Yen Aarts, Bram Van Bergen">
        <title>Personeelsfeest</title>
        
        <!-- Bootstrap Core CSS -->
        <?php echo pasStylesheetAan("bootstrap.css"); ?>
        <!-- Custom CSS -->
        <?php echo pasStylesheetAan("heroic-features.css"); ?>
        <!-- Buttons CSS -->
        <?php echo pasStylesheetAan("buttons.css"); ?>

        <?php echo haalJavascriptOp("jquery-3.1.0.min.js"); ?>
        <?php echo haalJavascriptOp("bootstrap.js"); ?>

        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>
    </head>
    <body>
        <header>
            <div class="jumbotron">
                <?php echo $header; ?>
            </div>
        </header>
        
        <div>
            <?php echo $inhoud; ?>
        </div>
        
        <footer>
            <div class="jumbotron">
                <?php echo $footer; ?>
            </div>
        </footer>
    </body>
</html>
