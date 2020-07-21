<?php
// Standard GPL and phpdocs
namespace block_custommodules\output;

use renderable;
use block_custommodules\module_info;
use renderer_base;
use moodle_url;
use stdClass;

class home_page implements renderable
{
    private $output = null;

    public function __construct()
    {
    }

    /**                                                                                                                             
     * Export this data so it can be used as the context for a mustache template.                                                   
     *                                                                                                                              
     * @return stdClass
     *                                                                                                              
     */
    public function export_for_template(renderer_base $output)
    {
        $data = new stdClass();
        $this->output = $output;
        $data->modules = $this->list_modules();

        return $data;
    }
    function list_modules()
    {
        global $DB, $USER;
        $defaultimage = $this->output->image_url('previa-default', 'block_custommodules')->out();
        $list_modules = [];
        $modules = $DB->get_records("block_custommodules");

        foreach ($modules as $module) {
            $module_info = new module_info($USER->id, $module);

            if (!$module_info->has_courses()) continue;

            $moduleimage = $module_info::image_module($module->id);

            if (is_null($moduleimage)) {
                $moduleimage = $defaultimage;
            }

            $moduleObj = new stdClass();
            $moduleObj->id = $module->id;
            $moduleObj->modulename = $module->fullname;
            $moduleObj->moduleimage = $moduleimage;
            $moduleObj->viewurl = new moodle_url('/blocks/custommodules/view.php', ["id" => $module->id]);
            $moduleObj->progress = $module_info->progress();

            $list_modules[] = $moduleObj;
        }
        return $list_modules;
    }
}
