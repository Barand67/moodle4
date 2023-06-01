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
 * Global search block.
 *
 * @package    block_globalsearch
 * @copyright  Prateek Sachan {@link http://prateeksachan.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Global search block.
 *
 * @package    block_globalsearch
 * @copyright  Prateek Sachan {@link http://prateeksachan.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_globalsearch extends block_base {

    /**
     * Initialises the block.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_globalsearch');
    }

    /**
     * Gets the block contents.
     *
     * If we can avoid it better not check the server status here as connecting
     * to the server will slow down the whole page load.
     *
     * @return string The block HTML.
     */
    public function get_content() {
        global $OUTPUT;
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';

        if (\core_search\manager::is_global_search_enabled() === false) {
            $this->content->text = get_string('globalsearchdisabled', 'search');
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
            return $this->content;
        }

        $data = [
            'action' => new moodle_url('/search/index.php'),
            'inputname' => 'q',
            'searchstring' => get_string('search'),
        ];

        if ($this->page->context && $this->page->context->contextlevel !== CONTEXT_SYSTEM) {
            $data['hiddenfields'] = (object) ['name' => 'context', 'value' => $this->page->context->id];
        }

        $this->content->text = $OUTPUT->render_from_template('core/search_input', $data);

        return $this->content;
    }

    /**
     * This block shouldn't be added to a page if the global search advanced feature is disabled.
     *
     * @param moodle_page $page
     * @return bool
     */
    public function can_block_be_added(moodle_page $page): bool {
        global $CFG;

        return $CFG->enableglobalsearch;
    }
}
