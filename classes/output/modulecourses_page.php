<?php
// Standard GPL and phpdocs
namespace block_custommodules\output;;

use renderable;
use renderer_base;
use stdClass;

class modulecourses_page implements renderable
{
    /** @var stdClass $sometext Some text to show how to pass data to a template. */
    var $pageObject = null;

    public function __construct($pageObject)
    {
        $this->pageObject = $pageObject;
    }

    /**                                                                                                                             
     * Export this data so it can be used as the context for a mustache template.                                                   
     *                                                                                                                              
     * @return stdClass                                                                                                             
     */
    public function export_for_template(renderer_base $output)
    {
        $data = new stdClass();
        $data->id = $this->pageObject->id;
        $data->module_name = $this->pageObject->module_name;
        $data->label_save = $this->pageObject->label_save;
        $data->label_cancel = $this->pageObject->label_cancel;
        $data->page_url = $this->pageObject->page_url;
        $data->selected_courses = $this->pageObject->selected_courses;
        $data->available_courses = $this->pageObject->available_courses;

        return $data;
    }
}
