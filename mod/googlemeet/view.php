<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Prints an instance of mod_googlemeet.
 *
 * @package     mod_googlemeet
 * @copyright   2020 Rone Santos <ronefel@hotmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use mod_googlemeet\client;

require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');

$config = get_config('googlemeet');

$id = optional_param('id', 0, PARAM_INT);

if ($id) {
    $cm = get_coursemodule_from_id('googlemeet', $id, 0, false, MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $googlemeet = $DB->get_record('googlemeet', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($g) {
    $googlemeet = $DB->get_record('googlemeet', array('id' => $n), '*', MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $googlemeet->course), '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('googlemeet', $googlemeet->id, $course->id, false, MUST_EXIST);
} else {
    throw new moodle_exception('missingidandcmid', 'mod_googlemeet');
}

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/googlemeet:view', $context);

$PAGE->set_url('/mod/googlemeet/view.php', array('id' => $cm->id));
$PAGE->set_context($context);

if (has_capability('mod/googlemeet:editrecording', $context)) {
    $client = new client();
    $logout = optional_param('logout', 0, PARAM_BOOL);
    if ($logout) {
        $client->logout();
    }
    $sync = optional_param('sync', 0, PARAM_BOOL);
    if ($sync) {
        $client->syncrecordings($googlemeet);
    }
}

// Make sure URL exists before generating output - some older sites may contain empty urls
// Do not use PARAM_URL here, it is too strict and does not support general URIs!
$url = trim($googlemeet->url);
$pattern = "/^https:\/\/meet.google.com\/[-a-zA-Z0-9@:%._\+~#=]{3}-[-a-zA-Z0-9@:%._\+~#=]{4}-[-a-zA-Z0-9@:%._\+~#=]{3}$/";
if (!preg_match($pattern, $url)) {
    googlemeet_print_header($googlemeet, $cm, $course);
    googlemeet_print_heading($googlemeet, $cm, $course);
    googlemeet_print_intro($googlemeet, $cm, $course);
    notice(get_string('invalidstoredurl', 'googlemeet'), new moodle_url('/course/view.php', array('id' => $cm->course)));
    die;
}
unset($url);

// Completion and trigger events.
googlemeet_view($googlemeet, $course, $cm, $context);

googlemeet_print_header($googlemeet, $cm, $course);
googlemeet_print_heading($googlemeet, $cm, $course, true);
googlemeet_print_intro($googlemeet, $cm, $course, true);

echo html_writer::link($googlemeet->url,
    get_string('entertheroom', 'googlemeet'),
    ['class' => 'btn btn-primary', 'target' => '_blank', 'title' => get_string('entertheroom', 'googlemeet')]);

if (has_capability('mod/googlemeet:editrecording', $context)) {
    if ($googlemeet->eventid != null) {
        echo html_writer::link('https://calendar.google.com/calendar/u/0/r/eventedit/'.$googlemeet->eventid,
            get_string('eventdetails', 'googlemeet'),
            ['class' => 'btn btn-outline-primary ml-2', 'target' => '_blank', 'title' => get_string('eventdetails', 'googlemeet')]);
    }
}

echo $OUTPUT->render_from_template('mod_googlemeet/upcomingevents', googlemeet_get_upcoming_events($googlemeet->id));

googlemeet_print_recordings($googlemeet, $cm, $context);

echo $OUTPUT->footer();
