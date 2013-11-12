<?php
/*
 * Command nagios template
 */
?>
define command{
        command_name    <?php nagios_echo($this->name); ?>
        command_line    <?php nagios_echo($this->line); ?>
        }
