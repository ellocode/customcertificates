<?php
// Standard GPL and phpdocs
namespace block_customcertificates\output;

use renderable;
use renderer_base;
use moodle_url;
use stdClass;

class main_page implements renderable
{
    /** @var stdClass $sometext Some text to show how to pass data to a template. */
    var $pageObject = null;

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
        $data->view_url = new moodle_url('/blocks/customcertificates/certificateuser.php');
        return $data;
    }
}
