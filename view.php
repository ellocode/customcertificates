<?php
require_once('../../config.php');

$id = required_param('id', PARAM_INT);

$module = $DB->get_record('block_custommodules', array('id' => $id));

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('mycourses', 'block_custommodules'));
$url  =  new moodle_url('/blocks/custommodules/view.php', array('id' => $id));
$PAGE->set_heading(get_string('mycourses', 'block_custommodules'));
$PAGE->set_url($url);

require_login();

$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('mycourses', 'block_custommodules'), $url);

$output = $PAGE->get_renderer('block_custommodules');
$renderable = new block_custommodules\output\view_page($USER->id, $module);

echo $output->header();
echo $output->render($renderable);
echo $output->footer();
