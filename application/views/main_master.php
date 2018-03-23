<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $( function() {
                $( ".datepicker" ).datepicker();
            } );
        </script>
    </head>
    <body>
        <?php echo $header; ?>
        
        <div class="container">
            <?php
            echo "<h1>$titel</h1>";
            echo $inhoud; 
            ?>
        </div>
        
        <?php echo $footer; ?>
    </body>
</html>
