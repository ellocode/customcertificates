<?php
// Standard GPL and phpdocs
namespace block_customcertificates;

use moodle_url;
use stdClass;

class renderable_certificate_modules
{
    var $certificateid;

    public function __construct($certificateid)
    {
        $this->certificateid = $certificateid;
    }
    public function get_certificate_modules()
    {

        global $DB;
        $certificate = new stdClass();

        $certificate_result = $DB->get_record("block_customcertificates", array("id" => $this->certificateid));

        if (is_null($certificate_result)) return null;

        $moduleids = explode("|", $certificate_result->moduleids);
        $modules = $DB->get_records("block_custommodules");

        $certificate->id = $certificate_result->id;
        $certificate->module_name = $certificate_result->fullname;
        $certificate->page_url = new moodle_url('/blocks/customcertificates/certificatemodules.php', ["id" => $certificate->id]);
        $certificate->label_save = get_string('title_btn_edit_certificate', 'block_customcertificates');
        $certificate->label_cancel = get_string('title_btn_cancel_certificates', 'block_customcertificates');
        $certificate->selected_modules = [];
        $certificate->available_modules = [];

        foreach ($modules as $module) {
            if (in_array($module->id, $moduleids, true)) {
                $certificate->selected_modules[] = ["moduleid" => $module->id, "modulename" => $module->fullname, "checked" => "checked"];
            } else {
                $certificate->available_modules[] = ["moduleid" => $module->id, "modulename" => $module->fullname, "checked" => ""];
            }
        }
        return $certificate;
    }
}
