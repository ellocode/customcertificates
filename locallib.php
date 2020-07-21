<?php
require_once($CFG->libdir . '/pdflib.php');


function get_certificates_user($certificateid = null, $print = 1)
{
    global $DB, $USER;
    $certificates_user = [];

    $context = context_user::instance($USER->id);
    $has_capability = has_capability('moodle/course:view',  $context);

    $courses_user = enrol_get_users_courses($USER->id, true, Null, 'visible DESC,sortorder ASC');

    $conditions = null;

    if (!is_null($certificateid)) {
        $conditions = array("id" => $certificateid);
    }

    $certificates = $DB->get_records("block_customcertificates", $conditions);
    //Percorre os certificados 
    foreach ($certificates as $certificate) {

        if (is_null($certificate->moduleids)) continue;

        $certificate_user = new stdClass();
        $certificate_user->id = $certificate->id;
        $certificate_user->userid = $USER->id;
        $certificate_user->fullname = $certificate->fullname;
        $certificate_user->description = $certificate->description;
        $certificate_user->name_user = $USER->firstname . " " . $USER->lastname;
        $certificate_user->modules = [];
        $certificate_info = new \block_customcertificates\certificate_info($certificate->id, $print);
        $certificate_user->front_image = $certificate_info->front_image;
        $certificate_user->verse_image  = $certificate_info->verse_image;
        $certificate_user->viewurl = $certificate_info->get_view_url();
        $certificate_user->local_date = $certificate_info->local_date();
        $certificate_user->issue_date = $certificate_info->issue_date;

        $moduleids = explode("|", $certificate->moduleids);
        $countnotcomplete = 0;
        //Percorre os modulos dos certificados  
        foreach ($moduleids as $moduleid) {
            $module = $DB->get_record("block_custommodules", ["id" => $moduleid]);
            if ($module) {
                if (is_null($module->courseids)) continue;

                $module_user = new stdClass();
                $module_user->id = $module->id;
                $module_user->fullname = $module->fullname;
                $module_user->courses = [];
                $module_user->total_hours = $module->total_hours;

                $courseids = explode("|", $module->courseids);
                //Percorre os cursos dos módulos
                foreach ($courseids as $courseid) {
                    if ($has_capability) {
                        $course = get_course($courseid);
                        $module_user->courses[] = $course;
                    } else {
                        $course = find_course($courseid, $courses_user);

                        if (!is_null($course)) {
                            $course_info = new \block_customcertificates\certificate_course_info($course);
                            $iscomplete =  $course_info->is_complete_course();
                            //verifica se o curso esta completo
                            if ($iscomplete) {
                                $module_user->courses[] = $course;
                            } else {
                                $countnotcomplete++;
                            }
                        }
                    }
                }
                $certificate_user->modules[] = $module_user;
            }
        }
        if ($countnotcomplete == 0) {
            $certificates_user[] = $certificate_user;
        }
    }
    return $certificates_user;
}

function find_course($id, $courses)
{
    foreach ($courses as $course) {
        if ($course->id == $id) {
            return $course;
        };
    }
    return null;
}
function save_certificate_user($certificateid, $userid, $certificate_name, $issue_date)
{
    global $DB;
    $params = array("certificateid" => $certificateid, "userid" => $userid);
    $table = "customcertificates_issues";
    $certificate_user = $DB->get_record($table, $params);
    if ($certificate_user) {
        $certificate_user->version += 1;
        $certificate_user->issuedate = $issue_date;
        $DB->update_record($table, $certificate_user, false);
    } else {
        $certificate_user = array(
            "certificateid" => $certificateid,
            "userid" => $userid,
            "certificate_name" => $certificate_name,
            "version" => 1,
            "issuedate" => $issue_date
        );


        $DB->insert_record($table, $certificate_user, false, false);
    }
}
