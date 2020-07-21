<?php
include_once($CFG->dirroot . '/course/lib.php');

class block_custommodules extends block_base
{
    public function init()
    {
        $this->title = get_string('pluginname', 'block_custommodules');
    }

    /**
     * Build form.
     *
     * @param object $mform
     */

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
                $this->title = get_string('defaulttitle', 'block_custommodules');
            } else {
                $this->title = $this->config->title;
            }
        }
    }

    public function get_content()
    {

        $output = $this->page->get_renderer('block_custommodules');
        $renderable = new block_custommodules\output\home_page();

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = $output->render($renderable);
        $this->content->footer = '';

        return $this->content;
    }
}
