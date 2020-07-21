<?php
// Standard GPL and phpdocs
require_once('../../config.php');
require_once("locallib.php");
$certificateid = required_param('id', PARAM_INT);

$context = context_system::instance();
$PAGE->set_context($context);

global $DB, $PAGE;
$url  =  new moodle_url('/blocks/customcertificates/certificatemodules.php', ["id" => $certificateid]);
$PAGE->set_url($url);

require_login();

$PAGE->set_pagelayout('standard');
//breadcrumbs
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('managecertificates', 'block_customcertificates'), new moodle_url('certificatelist.php'));
$PAGE->navbar->add(get_string('managemodules', 'block_customcertificates'));

$PAGE->set_heading(get_string('pluginname', 'block_customcertificates'));
$output = $PAGE->get_renderer('block_customcertificates');
$PAGE->requires->js_call_amd('block_customcertificates/certificatemodules', 'init');

require_capability('moodle/course:update', $context);

echo $output->header();
$renderable = new block_customcertificates\output\certificatemodules_page($certificateid);
echo $output->render($renderable);

echo $output->footer();
