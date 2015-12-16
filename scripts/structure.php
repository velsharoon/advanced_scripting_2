<?php
    class Structure
    {
        public function header($title)
        {
            $result = 
            '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>'.$tltle.'</title>
                <link href="css/style.css" rel="stylesheet"/>
                <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBiaN6so44HSbgB3kjOvFeUdUQcfjyAW94"></script>
            </head>
            <body>';
            
            return $result;
        }
        
        public function footer()
        {
            $result = 
            '
            </body>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="scripts/myjquery.js" type="text/javascript"></script>
            </html>';
            
            return $result;
        }
    }
?>