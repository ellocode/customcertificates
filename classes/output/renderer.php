<?php

namespace block_customcertificates\output;

defined('MOODLE_INTERNAL') || die;

use plugin_renderer_base;

class renderer extends plugin_renderer_base
{
    /**                                                                                                                             
     * Defer to template.                                                                                                           
     *                                                                                                                              
     * @param listcertificates_page $page                                                                                                      
     *                                                                                                                              
     * @return string html for the page                                                                                             
     */
    public function render_certificatelist_page($page)
    {
        $data = $page->export_for_template($this);
        return parent::render_from_template('block_customcertificates/certificatelist_page', $data);
    }
    public function render_certificatemodules_page($page)
    {
        $data = $page->export_for_template($this);
        return parent::render_from_template('block_customcertificates/certificatemodules_page', $data);
    }
    public function render_certificate_page($page)
    {
        $data = $page->export_for_template($this);
        return parent::render_from_template('block_customcertificates/certificate_page', $data);
    }
    public function render_view_page($page)
    {
        $data = $page->export_for_template($this);
        return parent::render_from_template('block_customcertificates/view_page', $data);
    }
    public function render_certificateuser_page($page)
    {
        $data = $page->export_for_template($this);
        return parent::render_from_template('block_customcertificates/certificateuser_page', $data);
    }
    public function render_main_page($page)
    {
        $data = $page->export_for_template($this);
        return parent::render_from_template('block_customcertificates/main_page', $data);
    }
}
