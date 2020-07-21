<?php
// Standard GPL and phpdocs
require_once('../../config.php');
require_once("locallib.php");

global $DB, $PAGE;
$context = context_system::instance();
$PAGE->set_context($context);

$url  =  new moodle_url('/blocks/custommodules/modulelist.php');
$PAGE->set_url($url);
require_login();

$PAGE->set_pagelayout('standard');
$id = optional_param('id', 0, PARAM_INT);
$PAGE->set_heading(get_string('pluginname', 'block_custommodules'));

require_capability('moodle/course:update', $context);

$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('managemodules', 'block_custommodules'));
$output = $PAGE->get_renderer('block_custommodules');
$PAGE->requires->js_call_amd('block_custommodules/modulelist', 'init');

echo $output->header();

$modules = $DB->get_records("block_custommodules");
$renderable = new block_custommodules\output\module_list_page(renderable_list_modules_object());
echo $output->render($renderable);

echo $output->footer();
