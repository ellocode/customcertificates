<?php
// Standard GPL and phpdocs
require_once('../../config.php');
//require_once("lib.php");
require_login();

$context = context_system::instance();
$PAGE->set_context($context);
require_capability('moodle/category:manage', $context);
global $DB,$PAGE;
$url  =  new moodle_url ('/blocks/customcertificates/listcertificates.php');
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');
$id = optional_param('id', 0, PARAM_INT);
$PAGE->set_heading(get_string('pluginname', 'block_customcertificates')); 
$output = $PAGE->get_renderer('block_customcertificates');
$renderable = new block_customcertificates\output\listcertificates_page();

echo $output->header();

echo $output->render($renderable);
 
echo $output->footer();