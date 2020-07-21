<?php
// Standard GPL and phpdocs
require_once('../../config.php');
include_once("locallib.php");
$id = required_param('id', PARAM_INT);

$context = context_system::instance();
$PAGE->set_context($context);
require_capability('moodle/category:manage', $context);
global $DB, $PAGE;
$url  =  new moodle_url('/blocks/custommodules/modulecourses.php');
$PAGE->set_url($url);

require_login();

$PAGE->set_pagelayout('standard');
//breadcrumbs
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('managemodules', 'block_custommodules'), new moodle_url('listmodules.php'));
$PAGE->navbar->add(get_string('managecourses', 'block_custommodules'));

$PAGE->set_heading(get_string('pluginname', 'block_custommodules'));
$output = $PAGE->get_renderer('block_custommodules');
$PAGE->requires->js_call_amd('block_custommodules/modulecourses', 'init');

require_capability('moodle/course:update', $context);

echo $output->header();
$modules = $DB->get_records("block_custommodules");
$renderable = new block_custommodules\output\modulecourses_page(renderable_modules_courses_object($id));
echo $output->render($renderable);

echo $output->footer();
