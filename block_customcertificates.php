<?php
include_once($CFG->dirroot . '/course/lib.php');

class block_customcertificates extends block_base
{
    public function init()
    {
        $this->title = get_string('pluginname', 'block_customcertificates');
    }
    function applicable_formats()
    {
        // Default case: the block can be used in courses and site index, but not in activities
        return array(
            'my' => true,
        );
    }

    function has_config()
    {
        return true;
    }

    public function specialization()
    {
        if (isset($this->config)) {
            if (empty($this->config->title)) {
                $this->title = get_string('defaulttitle', 'block_customcertificates');
            } else {
                $this->title = $this->config->title;
            }
        }
    }

    public function get_content()
    {
        if ($this->content !== null) {
            return $this->content;
        }

        $renderable = new \block_customcertificates\output\main_page();
        $renderer = $this->page->get_renderer('block_customcertificates');
        $this->content         =  new stdClass();
        $this->content->text = $renderer->render($renderable);
        $this->content->footer = '';

        return $this->content;
    }
}
