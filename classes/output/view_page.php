<?php
// Standard GPL and phpdocs
namespace block_custommodules\output;

require_once($CFG->dirroot . '/blocks/custommodules/locallib.php');
require_once($CFG->libdir . '/filelib.php');

use renderable;
use renderer_base;
use context_course;
use core_completion\progress;
use moodle_url;
use stdClass;

class view_page implements renderable
{
    /** @var stdClass $sometext Some text to show how to pass data to a template. */
    var $module = null;
    var $userid = null;
    private $output = null;

    public function __construct($userid, $module)
    {
        $this->userid = $userid;
        $this->module = $module;
    }

    /**                                                                                                                             
     * Export this data so it can be used as the context for a mustache template.                                                   
     *                                                                                                                              
     * @return stdClass                                                                                                             
     */
    public function export_for_template(renderer_base $output)
    {
        $data = new stdClass();
        $this->output = $output;
        $data->modulename = $this->module->fullname;
        $data->courses = $this->list_courses();
        return $data;
    }
    function list_courses()
    {
        $courses = array();
        $courses_result = get_courses_module_by_user($this->userid, $this->module);

        foreach ($courses_result as $course_result) {

            $completion = new \completion_info($course_result);
            $course = new stdClass();
            $course->id = $course_result->id;
            $course->fullname = $course_result->fullname;
            $course->viewurl = new moodle_url('/course/view.php', ["id" => $course_result->id]);
            $course->courseimage = $this->course_image($course->id);
            $course->hasprogress = $completion->is_enabled();

            if ($completion->is_enabled()) {
                $progress = round(progress::get_course_progress_percentage($course_result, $this->userid));
                $course->progress = is_null($progress) ? 0 : $progress;
            }

            $course->visible = $course_result->visible;

            if (!$course->visible) continue;

            $courses[] = $course;
        }
        return $courses;
    }
    function course_image($courseid)
    {
        $url = null;
        $context = context_course::instance($courseid);
        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'course', 'overviewfiles', 0);

        foreach ($files as $f) {
            if ($f->is_valid_image()) {
                $url = moodle_url::make_pluginfile_url($f->get_contextid(), $f->get_component(), $f->get_filearea(), null, $f->get_filepath(), $f->get_filename(), false);
            }
        }

        if (is_null($url)) {
            $url = $this->output->image_url('previa-default', 'block_custommodules')->out();
        }
        return $url;
    }
}
