<?php

abstract class Template {
    public $out_template;

    public function out() {
        include dirname(__FILE__) . '/templates/' . $this->out_template . '.php';
    }
}

/*
 * Nagios objects definitions
 */
class NagiosConfig extends Template {
    public $commands = array();
    public $hostgroups = array();
    public $out_template = 'nagios-config';
}

class Command extends Template {
    public $name;
    public $line;
    public $out_template = 'command';
}

class HostGroup extends Template {
    public $name;
    public $alias;
    public $hosts = array();
    public $out_template = 'hostgroup';
}

class Host extends Template {
    public $use;
    public $name;
    public $alias;
    public $address;
    public $services = array();
    public $out_template = 'host';
}

class Service extends Template {
    public $use;
    public $host_name;
    public $description;
    public $check_command;
    public $out_template = 'service';
}

?>