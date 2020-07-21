<?php
// Standard GPL and phpdocs
namespace block_customcertificates;

class certificate_course_info
{
    var $course;

    public function __construct($course)
    {
        $this->course = $course;
    }

    //Verifica se o curso esta completo conforme as regras do Nefru
    function is_complete_course()
    {
        global $DB, $USER, $CFG;
        $userid = $USER->id;
        require_once("$CFG->libdir/gradelib.php");
        $complete_scorm = 0;
        $complete_quiz = 0;

        $modinfo = get_fast_modinfo($this->course);

        foreach ($modinfo->get_cms() as $cminfo) {

            switch ($cminfo->modname) {
                case 'scorm':
                    $params = array(
                        "userid" => $userid,
                        "scormid" => $cminfo->instance
                    );
                    $tracks = $DB->get_records('scorm_scoes_track', $params);
                    foreach ($tracks as $track) {
                        if (($track->value == 'completed') || ($track->value == 'passed') || ($track->value == 'failed')) {
                            $complete_scorm++;
                        }
                    }
                    break;
                case 'quiz':

                    $grading_info = grade_get_grades($this->course->id, 'mod', 'quiz', $cminfo->instance, $userid);
                    $gradebookitem = array_shift($grading_info->items);
                    $grade = $gradebookitem->grades[$userid];
                    $value = round(floatval(str_replace(",", ".", $grade->str_grade)), 1);
                    //verifica se a nota do aluno é igual ou maior que 7 em quiz 
                    if ($value >= 7.0) {
                        $complete_quiz++;
                    }
                    break;
                default:
                    break;
            }
        }
        if ($complete_scorm > 0 && $complete_quiz > 0) {
            return true;
        }
        return false;
    }
}
