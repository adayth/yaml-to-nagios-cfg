<?php
/*
 * Host nagios template
 */
?>
###############################################################################
# HOST <?php nagios_echo($this->name); ?>
###############################################################################

define host{
        use                     <?php nagios_echo($this->use); ?>
        host_name               <?php nagios_echo($this->name); ?>
        alias                   <?php nagios_echo($this->alias); ?>
        address                 <?php nagios_echo($this->address); ?>
        }

<?php
foreach ($this->services as $service) {
    $service->host_name = $this->name;
    nagios_echo($service->out());
}
?>
