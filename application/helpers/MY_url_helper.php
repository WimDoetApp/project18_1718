<?php

    // +----------------------------------------------------------
    // | TV Shop
    // +----------------------------------------------------------
    // | 2ITF - 201x-201x
    // +----------------------------------------------------------
    // | MY url helper
    // |
    // +----------------------------------------------------------
    // | Thomas More
    // +----------------------------------------------------------

    function divAnchor($uri = '', $title = '', $attributes = '') 
    {
        return "<div>" . anchor($uri, $title, $attributes) . "</div>\n";
    }
      function smallDivAnchor($uri = '', $title = '', $attributes = '') 
    {
        return "<div style='margin-top: 4px'>". 
                anchor($uri, $title, $attributes) . "</div>\n";
    }
  

?>
