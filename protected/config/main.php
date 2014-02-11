<?php

// This is the main Web application configuration. Any writable
// application properties can be configured here.
return array(
    'basePath'          => __DIR__ . DIRECTORY_SEPARATOR . '..',
    'name'              => 'Hospital Demo',
    'defaultController' => 'Site/test',
    'import'            => [
        'application.models.*',
        'application.models.Doctor.*',
        'application.models.Sickness.*',
        'application.components.*',
    ]
);
