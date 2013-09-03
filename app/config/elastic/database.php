<?php
return array(
    'default' => 'mysql',
 
    'connections' => array(
        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => $_SERVER['RDS_HOSTNAME'],
            'port'      => $_SERVER['RDS_PORT'],
            'database'  => $_SERVER['RDS_DB_NAME'],
            'username'  => $_SERVER['RDS_USERNAME'],
            'password'  => $_SERVER['RDS_PASSWORD'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),
    ),
);