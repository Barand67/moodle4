<?php
defined('MOODLE_INTERNAL')|| die;
if($hassiteconfig){
     $ADMIN->add('root', new admin_category('havaDurumu', get_string('pluginname','local_havaDurumu')));
     $ADMIN->add('havaDurumu', new admin_externalpage('userdata', get_string('userdata','local_havaDurumu'),
                  new moodle_url('/local/havaDurumu/userdata.php')));
    

    $ADMIN->add('havaDurumu', new admin_externalpage('usermetadata', get_string('usermetadata','local_havaDurumu'),
                  new moodle_url('/local/havaDurumu/metadata.php')));

}
