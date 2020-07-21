<?php
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
 * External Web Service Template
 *
 * @package    localwstemplate
 * @copyright  2011 Moodle Pty Ltd (http://moodle.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . "/externallib.php");

class blocks_custommodules_external extends external_api {

    //Associa cursos ao módulo 
    public static function associate_courses_with_module_parameters() {
        return new external_function_parameters(array(
            "moduleid"=>new external_value(PARAM_INT, VALUE_REQUIRED),
            "courseids"=>new external_value(PARAM_RAW, VALUE_OPTIONAL)
        ));
    }
    public static function associate_courses_with_module($moduleid,$courseids) {
        global $DB;

        $module = new stdclass;
        $module->id=$moduleid;
        $module->courseids=$courseids;

        $result=$DB->update_record("block_custommodules", $module);
        if(!$result){
            return "Error update module";
        }
        return "Success update module";
    }
    public static function associate_courses_with_module_returns() {
        return new external_value(PARAM_TEXT, 'Result update module');
    }
    //Exclui módulo
    public static function delete_module_parameters() {
        return new external_function_parameters(array(
            "moduleid"=>new external_value(PARAM_INT, VALUE_REQUIRED)
        ));
    }

    public static function delete_module($moduleid) {
        global $DB;

        $module = new stdclass;
        $module->id=$moduleid;

        $result=$DB->delete_records("block_custommodules", array("id"=>$moduleid));
        if(!$result){
            return "Error delete module";
        }
        return "Success delete module";
    }
     public static function delete_module_returns() {
        return new external_value(PARAM_TEXT, 'Result delete module');
    }
}