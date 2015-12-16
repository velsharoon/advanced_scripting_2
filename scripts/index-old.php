<?php
    require_once('socket.php');
    require('structure.php');
    
    $structure = new Structure();
?>
    <?= $structure->header('Advanced Scripting 2'); ?>
    <div class='main'>
        <h1> Car Order Form </h1>
        <form class='ajax-fun' method='post' enctype='multipart/form-data'>
            <select id="makes"></select>
            <select id="models"></select>
            <select id="engines"></select>
            
            <input type="submit" value="Order Car" />
        </form>
    </div>
    <div id='orderStatus'>
        
    </div>
    <?= $structure->footer(); ?>