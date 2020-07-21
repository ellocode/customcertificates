<?php
// Standard GPL and phpdocs
require_once('../../config.php');

$id = optional_param('id', 0, PARAM_INT);

$context = context_system::instance();
$PAGE->set_context($context);

global $DB;

$PAGE->set_pagelayout('standard');
$PAGE->requires->js_call_amd('block_customcertificates/certificatelist', 'init');
$PAGE->set_heading(get_string('pluginname', 'block_customcertificates'));

$url  =  new moodle_url('/blocks/customcertificates/certificatelist.php');
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('managecertificates', 'block_customcertificates'));
$PAGE->set_url($url);

require_login();

require_capability('moodle/category:manage', $context);

$output = $PAGE->get_renderer('block_customcertificates');
$renderable = new block_customcertificates\output\certificatelist_page();


echo $output->header();

echo $output->render($renderable);

echo $output->footer();
