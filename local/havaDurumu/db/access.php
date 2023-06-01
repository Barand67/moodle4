<?php
defined('MOODLE_INTERNAL') || die();

$capabilities= array(
    'local/havaDurumu:viewpages' => array(
        'captype' => 'read',
        'contexlevel' => CONTEXT_SYSTEM,
        'legacy' => array(
            'guest' => CAP_PREVENT,
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'coursecreator' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
        ),
        'local/havaDurumu:managepages' => array(
            'captype' => 'read',
            'contexlevel' => CONTEXT_SYSTEM,
            'legacy' => array(
             'guest' => CAP_PREVENT,
             'student' => CAP_PREVENT,
             'teacher' => CAP_PREVENT,
             'editingteacher' => CAP_ALLOW,
             'coursecreator' => CAP_ALLOW,
             'manager' => CAP_ALLOW


        )




)