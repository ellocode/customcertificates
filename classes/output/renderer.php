<?php

namespace block_custommodules\output;

defined('MOODLE_INTERNAL') || die;

use plugin_renderer_base;

class renderer extends plugin_renderer_base
{
    /**                                                                                                                             
     * Defer to template.                                                                                                           
     *                                                                                                                              
     * @param listmodules_page $page                                                                                                      
     *                                                                                                                              
     * @return string html for the page                                                                                             
     */
    public function render_home_page($page)
    {
        $data = $page->export_for_template($this);
        return parent::render_from_template('block_custommodules/dashboard-list-modules', $data);
    }
    public function render_view_page($page)
    {
        $data = $page->export_for_template($this);
        return parent::render_from_template('block_custommodules/view-list-courses', $data);
    }
    public function render_module_list_page($page)
    {
        $data = $page->export_for_template($this);
        return parent::render_from_template('block_custommodules/module-list-page', $data);
    }
    public function render_modulecourses_page($page)
    {
        $data = $page->export_for_template($this);
        return parent::render_from_template('block_custommodules/modulecourses_page', $data);
    }
}
