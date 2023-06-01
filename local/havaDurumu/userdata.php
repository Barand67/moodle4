<?php
require('.../../config.php')
require_once($CFG->libdir.'/adminlib.php');
$path = optional_param('path','',PARAM_PATH);
$pageparams = array();
if($path){
    $pageparams['path']=$path;
}

global $CFG,$USER,$DB,$OUTPUT,$PAGE;
$PAGE->set_url('/local/havaDurumu/userdata.php');
require_login();
$PAGE->set_pagelayout('admin');
$context = context_system::instance();
$PAGE->set_context($context);
admin_externalpage_setup('userdata','',$pageparams);
$header = $SITE->fullname;
$PAGE->set_title(get_string('pluginname','local_havaDurumu'));
$PAGE->set_heading($header);
echo $OUTPUT->header();
$api_key = '3b9bf25f82e7abc91060392053cd877c';

$url = "https://api.openweathermap.org/data/2.5/weather?q=bartin&appid=$api_key&units=metric";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response);

echo "Şehir: " . $data->name . "<br>";
echo "Sıcaklık: " . $data->main->temp . "°C<br>";
echo "Nem: " . $data->main->humidity . "%<br>";
echo "Hava durumu: " . $data->weather[0]->description;
echo $OUTPUT->footer();
