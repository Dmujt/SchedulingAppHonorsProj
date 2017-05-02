<?php
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Calendar\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');
    $site->setEmail('');
    $site->setRoot('');
    $site->dbConfigure('',
        '',       // Database user
        '',     // Database password
        'honorsproj_');            // Table prefix
};
