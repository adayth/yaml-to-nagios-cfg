Author: Aday Talavera at <aday.talavera@gmail.com>
Copyright: Aday Talavera 2013
License: GNU GPL v2

##############
# Introduction
##############

This script transform YML files into Nagios configuration files, so this:

COMMANDS:
  check_ssh_alt: $USER1$/check_ssh $ARG1$ $HOSTADDRESS$ -p 2222
SERVICES:
  HTTP:
    description: HTTP Server
    check_command: check_http
    use: local-service
HOSTS:
  server1.domain.com:
    name: server1
    alias: server1
    address: 192.168.0.1
    use: local-host
    services:
      HTTP
      SSH

Will be turned into this:

define command{
        command_name    check_ssh_alt
        command_line    $USER1$/check_ssh $ARG1$ $HOSTADDRESS$ -p 2222
        }

define host{
        use                     local-host
        host_name               server1
        alias                   server1
        address                 192.168.0.1
        }

define service{
        use                             local-service
        host_name                       server1
        service_description             HTTP Server
        check_command                   check_http
        }

define service{
        use                             generic-service
        host_name                       server1
        service_description             SSH
        check_command                   check_ssh
        }

##############
# Requirements
##############

* Some Nagios knowledge
* Nagios server
* PHP

##############
# Installation
##############

Put script nagios-config.php and includes directory wherever you want. I will suggest you to put it along with nagios
config files in /etc/nagios or /usr/local/nagios/etc and also store the YML file with the script.

You have an example configuration file distributed with the script with the name config-example.yml. The file has comments
and provide examples to define commands, services and hosts. Hostgroups are dinamically created grouping hosts by the nagios
template (use directive).

#######
# Usage
#######

Go to script directory in a console and run: php nagios-yml.php FILE.yml
Where FILE:yml is the YML config file that you created.

The script will output Nagios configuration file format to standard output, so if you want to create a file just do a redirection
with: php nagios-yml.php FILE.yml > generated.cfg

Then you should load that file in your nagios.cfg file.