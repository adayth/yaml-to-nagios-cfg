<?php
/*
 * Service nagios template
 */
?>
define service{
        use                             <?php nagios_echo($this->use); ?>
        host_name                       <?php nagios_echo($this->host_name); ?>
        service_description             <?php nagios_echo($this->description); ?>
        check_command                   <?php nagios_echo($this->check_command); ?>
        }
