<?php
/*
 * Nagios config template
 * This is the starting template
 */
?>
###############################################################################
# Nagios config generated using nagios-config.php script
# Generation date: <?php nagios_echo(date('Y-m-d H:m')); ?>
###############################################################################

###############################################################################
# Custom commands
###############################################################################

<?php
foreach ($this->commands as $command) {
    $command->out();
}
?>

<?php
foreach ($this->hostgroups as $hostgroup) {
    $hostgroup->out();
}
?>