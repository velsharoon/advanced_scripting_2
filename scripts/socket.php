<?php
        $servername = getenv('IP');
        $username = getenv('C9_USER');
        $password = "";
        $database = "anthonyDatabase";
        $dbport = 3306;
    
        // Create connection
        $db = mysqli_connect($servername, $username, $password, $database, $dbport);
?>