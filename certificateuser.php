<?php
// Standard GPL and phpdocs
require_once('../../config.php');
require_once($CFG->libdir . '/pdflib.php');
require_once("lib.php");

require_login();

$id = optional_param('id', 0, PARAM_INT);
$userid = optional_param('userid', 0, PARAM_INT);
$print = optional_param('print', 0, PARAM_INT);

$context = context_system::instance();
$PAGE->set_context($context);
$url  =  new moodle_url('/blocks/customcertificates/certificateuser.php');
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');

$PAGE->set_heading(get_string('pluginname', 'block_customcertificates'));
//breadcrumbs
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('mycertificates', 'block_customcertificates'), new moodle_url('certificatelist.php'));


$output = $PAGE->get_renderer('block_customcertificates');
$renderable = new block_customcertificates\output\certificateuser_page($id, $userid);


echo $OUTPUT->header();

echo $output->render($renderable);

echo $OUTPUT->footer();
