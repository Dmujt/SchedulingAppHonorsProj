<?php
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Calendar\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');
    $site->setEmail('mujtabad@cse.msu.edu');
    $site->setRoot('/~mujtabad/honorsproj');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=mujtabad',
        'mujtabad',       // Database user
        'cse1285',     // Database password
        'htest_');            // Table prefix
};