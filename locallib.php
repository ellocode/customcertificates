<?php

defined('MOODLE_INTERNAL') || die();


function get_courses_module_by_user($userid, $module)
{
    if (!is_null($module->courseids)) {

        $courses_in_module = explode("|", $module->courseids);
        $context = context_user::instance($userid);
        $has_capability = has_capability('moodle/course:view',  $context);
        $courses = [];

        if ($has_capability) {
            foreach ($courses_in_module as $courseid) {
                $course = get_course($courseid);
                if (!is_null($course)) {
                    $courses[] = $course;
                }
            }
        } else {
            $courses_user = enrol_get_users_courses($userid, true, null, 'visible DESC,sortorder ASC');
            foreach ($courses_in_module as $courseid) {
                $course = find_course_by_id($courseid, $courses_user);
                if (!is_null($course)) {
                    $courses[] = $course;
                }
            }
        }
        return $courses;
    }
    return null;
}
function find_course_by_id($id, $courses)
{
    foreach ($courses as $course) {
        if ($course->id == $id) {
            return $course;
        };
    }
    return null;
}

function renderable_list_modules_object()
{
    global $DB;
    $pageObject = new stdClass();
    $pageObject->createUrl = new moodle_url('/blocks/custommodules/module.php');
    $pageObject->pageUrl = new moodle_url('/blocks/custommodules/modulelist.php');

    $modules = $DB->get_records("block_custommodules");
    $modulelist = [];
    foreach ($modules as $module) {
        $modulelist[] = [
            'id' => $module->id,
            'fullname' => $module->fullname,
            'courses' => list_courses_by_module($module),
            'edit_url' => new moodle_url('/blocks/custommodules/module.php?id=' . $module->id),
            'config_url' => new moodle_url('/blocks/custommodules/modulecourses.php?id=' . $module->id)
        ];
    }
    $pageObject->modules = $modulelist;
    return $pageObject;
}
function list_courses_by_module($module)
{
    $courses_module = [];
    if (!is_null($module->courseids)) {
        $courseids = explode("|", $module->courseids);
        $courses = get_courses('all', "c.fullname ASC");
        foreach ($courseids as $id) {
            $course = find_course_by_id($id, $courses);
            if (!is_null($course)) {
                $courses_module[] = ["id" => $course->id, "coursename" => $course->fullname];
            }
        }
    }
    if (empty($courses_module)) {
        $courses_module[] = ["id" => 0, "coursename" => "Não há cursos neste módulo"];
    }
    return $courses_module;
}

function renderable_modules_courses_object($id)
{
    global $DB;
    $pageObject = new stdClass();
    $module = $DB->get_record('block_custommodules', ['id' => $id]);
    $courseids = explode("|", $module->courseids);
    $courses = get_courses('all', "c.fullname ASC");

    $pageObject->id = $module->id;
    $pageObject->module_name = $module->fullname;
    $pageObject->page_url = new moodle_url('/blocks/custommodules/modulelist.php');
    $pageObject->label_save = get_string('title_btn_edit_modules', 'block_custommodules');
    $pageObject->label_cancel = "Cancelar";
    $pageObject->selected_courses = [];
    $pageObject->available_courses = [];

    foreach ($courses as $course) {
        if (in_array($course->id, $courseids, true)) {
            $pageObject->selected_courses[] = ["courseid" => $course->id, "coursename" => $course->fullname, "checked" => "checked"];
        } else {
            $pageObject->available_courses[] = ["courseid" => $course->id, "coursename" => $course->fullname, "checked" => ""];
        }
    }
    return $pageObject;
}

function renderable_list_courses_home_object()
{
    global $DB;
    $pageObject = new stdClass();
    $pageObject->createUrl = new moodle_url('/blocks/custommodules/module.php');
    $pageObject->pageUrl = new moodle_url('/blocks/custommodules/modulelist.php');

    $modules = $DB->get_records("block_custommodules");
    $list_modules = [];
    foreach ($modules as $module) {
        $list_modules[] = [
            'id' => $module->id,
            'fullname' => $module->fullname,
            'courses' => list_courses_by_module($module),
            'edit_url' => new moodle_url('/blocks/custommodules/module.php?id=' . $module->id),
            'config_url' => new moodle_url('/blocks/custommodules/modulecourses.php?id=' . $module->id)
        ];
    }
    $pageObject->modules = $list_modules;
    return $pageObject;
}
