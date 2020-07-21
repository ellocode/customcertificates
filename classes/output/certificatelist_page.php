<?php
// Standard GPL and phpdocs
namespace block_customcertificates\output;

use renderable;
use renderer_base;
use moodle_url;
use stdClass;

class certificatelist_page implements renderable
{
    /** @var stdClass $sometext Some text to show how to pass data to a template. */

    public function __construct()
    {
    }

    /**                                                                                                                             
     * Export this data so it can be used as the context for a mustache template.                                                   
     *                                                                                                                              
     * @return stdClass                                                                                                             
     */
    public function export_for_template(renderer_base $output)
    {
        $data = new stdClass();
        $data->pageUrl = "";
        $data->createUrl =  new moodle_url('/blocks/customcertificates/certificate.php');
        $data->certificates = $this->list_certificates();

        return $data;
    }
    function list_certificates()
    {
        global $DB;
        $list = [];
        $certificates = $DB->get_records("block_customcertificates");
        foreach ($certificates as $certicate) {
            $list[] = [
                'id' => $certicate->id,
                'fullname' => $certicate->fullname,
                'timecreated' => gmdate("d-m-Y", $certicate->timecreated),
                'editUrl' => new moodle_url('/blocks/customcertificates/certificate.php?id=' . $certicate->id),
                'modulesUrl' => new moodle_url('/blocks/customcertificates/certificatemodules.php?id=' . $certicate->id),
                'viewUrl' => str_replace('&amp;', '&', new moodle_url('/blocks/customcertificates/view.php', array("id" => $certicate->id, "print" => 0)))
            ];
        }
        return $list;
    }
}
