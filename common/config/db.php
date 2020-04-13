<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=payment',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    'tablePrefix'=> 'p_',
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
