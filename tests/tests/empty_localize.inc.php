<?php
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Calendar\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');
    $site->setEmail(''); // Email goes here
    $site->setRoot('');   // Site root goes here
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=', // dbname should be netid
        '',       // Database user
        '',     // Database password
        'regulator_test_');            // Table prefix
};