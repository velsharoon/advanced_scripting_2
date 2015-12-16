<?php
    require_once('scripts/socket.php');
    require('scripts/structure.php');
    $structure = new Structure();
?>
    <?= $structure->header("Velsharoon's Car Sales"); ?>
<h1> Welcome to Velsharoon's Car Sales! </h1>
<form id='sales-form'>
    <label> Full Name </label>
    <input class='full-name' type='text'/>
    <div id='error-name'><p> Error Please Use a Valid Name </p></div>
    <br>
    <label> Phone Number </label>
    <input class='phone-number' type='text'/>
    <div id='error-phone'><p> Error Please Use a Valid Phone Nmber </p></div>
    <br>
    <label> Email Address </label>
    <input class='email-address' type='text'/>
    <div id='error-email'><p> Error Please Use a Valid Email </p></div>
    <br>
    <label> Zip Code </label>
    <input class='zip-code' type='text'/>
    <div id='error-zip'><p> Error Please Use a Valid Zip Code </p></div>
    <br>
    <label> What is the best way to contact you? </label>
    <input class='best-contact' type='text'/>
    <div id='error-contact'><p> Please Use a Valid Contact Method </p></div>
    <br>
    <label> Car Make </label>
    <select id="makes"></select>
    <br>
    <label> Car Model </label>
    <select id="models"></select>
    <br>
    <label> Car Engine </label>
    <select id="engines"></select>
    <br>
    <input class='submit-data' type='submit'/>
</form>
<div class='success-message'></div>
<?= $structure->footer(); ?>