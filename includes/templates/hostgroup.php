<?php
/*
 * Hostgroup nagios template
 */
?>
<?php
$hostnames = array();
foreach ($this->hosts as $host) {
    $hostnames[] = $host->name;
    $host->out();
}
?>

###############################################################################
# HOST GROUP
###############################################################################

define hostgroup{
        hostgroup_name  <?php nagios_echo($this->name); ?>
        alias           <?php nagios_echo($this->alias); ?>
        members         <?php nagios_echo(implode(',', $hostnames)); ?>
        }
