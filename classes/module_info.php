<?php
// Standard GPL and phpdocs
namespace block_custommodules;

require_once($CFG->dirroot . '/blocks/custommodules/locallib.php');
require_once($CFG->libdir . "/completionlib.php");

use context_system;
use moodle_url;

class module_info
{
    private $count_courses = 0;
    private $courses = array();
    private $userid;

    public function __construct($userid, $module)
    {
        $this->$userid = $userid;
        $this->module = $module;
        $courses = get_courses_module_by_user($userid, $module);

        if ($courses) {
            $this->courses = $courses;
            $this->count_courses =  count($courses);
        }
    }
    public static function image_module($moduleid)
    {
        $url = null;
        $context = context_system::instance();
        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'block_custommodules', 'moduleimage', $moduleid);

        foreach ($files as $f) {
            if ($f->is_valid_image()) {
                $url = moodle_url::make_pluginfile_url($f->get_contextid(), $f->get_component(), $f->get_filearea(), $moduleid, $f->get_filepath(), $f->get_filename(), false);
            }
        }
        return $url;
    }
    public function progress()
    {
        $progress = 0;
        $countcomplete = 0;
        foreach ($this->courses as $course) {
            $completion = new \completion_info($course);
            if (!$completion->is_enabled()) continue;

            $iscomplete = $completion->is_course_complete($this->userid);

            if ($iscomplete) {
                $countcomplete++;
            }
        }
        $progress =  ($countcomplete / $this->count_courses) * 100;

        return $progress;
    }
    public function has_courses()
    {
        return ($this->count_courses > 0) ? true : false;
    }
}
