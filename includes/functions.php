<?php

require_once 'spyc/Spyc.php';

/**
 * Takes config array and verifies that all config values are present
 * @param type $config
 */
function config_array_has_errors($config) {
    // Check config
    $config_error = false;
    $required_values = array('DEFAULT_HOST_USE', 'DEFAULT_SERVICE_USE', 'SERVICES', 'HOSTS');
    foreach ($required_values as $value) {
        if (!array_key_exists($value, $config)) {
            echo "Error: required config value $value not found in config file.\n";
            $config_error = true;
        }
    }
    return $config_error;
}

/**
 * Takes config array and return hostgroups array
 * @param type $config
 */
function nagios_read_config($config) {
    // Grab config values
    $DEFAULT_HOST_USE = $config['DEFAULT_HOST_USE'];
    $DEFAULT_SERVICE_USE = $config['DEFAULT_SERVICE_USE'];
    $COMMANDS = $config['COMMANDS'];
    $SERVICES = $config['SERVICES'];
    $HOSTS = $config['HOSTS'];

    // Return object
    $nagios_config = new NagiosConfig();

    // Process commands
    foreach ($COMMANDS as $command_name => $command_line) {
        $command = new Command();
        $command->name = $command_name;
        $command->line = $command_line;
        $nagios_config->commands[] = $command;
    }

    // Process services
    $services = array();
    foreach ($SERVICES as $service_id => $service_config) {
        $service = new Service();
        if (is_array($service_config)) {
            $service->description = $service_config['description'];
            $service->check_command = $service_config['check_command'];
            $service->use = isset($service_config['use']) ? $service_config['use'] : $DEFAULT_SERVICE_USE;
        } else {
            $service->description = $service_id;
            $service->check_command = $service_config;
            $service->use = $DEFAULT_SERVICE_USE;
        }
        $services[$service_id] = $service;
    }

    // Process hosts
    $hostgroups = array();
    foreach ($HOSTS as $server_id => $server_config) {
        // Instanciate host
        $host = new Host();
        $host->use = isset($server_config['use']) ? $server_config['use'] : $DEFAULT_HOST_USE;
        $host->name = isset($server_config['name']) ? $server_config['name'] : $server_id;
        $host->alias = isset($server_config['alias']) ? $server_config['alias'] : $host->name;
        $host->address = $server_config['address'];
        // Instanciate services
        foreach ($server_config['services'] as $service_id) {
            if (key_exists($service_id, $services)) {
                $host->services[] = $services[$service_id];
            } else {
                echo "Warning: undefined service $service_id used in host $host->name not processed. \n";
            }
        }
        //Store them as hostgroups by template/use definition
        if (key_exists($host->use, $hostgroups)) {
            $hostgroup = $hostgroups[$host->use];
        } else {
            $hostgroup = new HostGroup();
            $hostgroup->name = $host->use;
            $hostgroup->alias = $host->use;
            $hostgroups[$host->use] = $hostgroup;
        }
        $hostgroup->hosts[] = $host;
    }
    $nagios_config->hostgroups = $hostgroups;

    return $nagios_config;
}

/*
 * Utility functions
 */

function nagios_echo($string, $newline = true) {
    echo $string;
    if ($newline) {
        echo "\n";
    }
}

?>
