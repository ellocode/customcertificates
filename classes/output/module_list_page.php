<?php
// Standard GPL and phpdocs
namespace block_custommodules\output;

use renderable;
use renderer_base;
use stdClass;

class module_list_page implements renderable
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
        $data->pageUrl = $this->pageObject->pageUrl;
        $data->createUrl = $this->pageObject->createUrl;
        $data->modules = $this->pageObject->modules;

        return $data;
    }
}
