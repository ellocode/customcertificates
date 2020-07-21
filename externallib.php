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

class block_customcertificates_external extends external_api
{

    //Associa cursos ao módulo 
    public static function associate_modules_with_certificate_parameters()
    {
        return new external_function_parameters(array(
            "certificateid" => new external_value(PARAM_INT, VALUE_REQUIRED),
            "moduleids" => new external_value(PARAM_RAW, VALUE_OPTIONAL)
        ));
    }
    public static function associate_modules_with_certificate($certificateid, $moduleids)
    {
        global $DB;

        $certificate = new stdclass;
        $certificate->id = $certificateid;
        $certificate->moduleids = $moduleids;

        $result = $DB->update_record("block_customcertificates", $certificate);
        if (!$result) {
            return "Error update certificate";
        }
        return "Success update certificate";
    }
    public static function associate_modules_with_certificate_returns()
    {
        return new external_value(PARAM_TEXT, 'Result update certificate');
    }
    //Exclui certificate
    public static function delete_certificate_parameters()
    {
        return new external_function_parameters(array(
            "certificateid" => new external_value(PARAM_INT, VALUE_REQUIRED)
        ));
    }

    public static function delete_certificate($certificateid)
    {
        global $DB;

        $result = $DB->delete_records("block_customcertificates", array("id" => $certificateid));
        if (!$result) {
            return "Error delete certificate";
        }
        return "Success delete certificate";
    }
    public static function delete_certificate_returns()
    {
        return new external_value(PARAM_TEXT, 'Result delete certificate');
    }
}
