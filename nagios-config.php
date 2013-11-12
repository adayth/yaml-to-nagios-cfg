<?php

// Load libraries
require_once 'includes/classes.php';
require_once 'includes/functions.php';

// Check script input values
if ($argc > 1) {
    $filename = $argv[1];
} else {
    $filename = 'config.yml';
}

// Check config file existence
if (!is_file($filename)) {
    echo "Error: can't found $filename.\n";
    return 1;
}

// Parse config file
$CONFIG = Spyc::YAMLLoad($filename);

// Check config
if (config_array_has_errors($CONFIG)) {
    echo "Error: one or more config values were missing in config file.\n";
    return 1;
}

// Read config and create nagios objects
$nagios_config = nagios_read_config($CONFIG);
// Output nagios config
$nagios_config->out();