<?php
// Standard GPL and phpdocs
require_once('../../config.php');
require_once('locallib.php');


$id = required_param('id', PARAM_INT);
$print = required_param('print', PARAM_INT);
$url  =  new moodle_url('/blocks/customcertificates/view.php');
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');


require_login();

$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_heading(get_string('pluginname', 'block_customcertificates'));

if (!$print) {
    $PAGE->navbar->ignore_active();
    $url  =  new moodle_url('/blocks/customcertificates/certificatelist.php');
    $PAGE->navbar->add(get_string('managecertificates', 'block_customcertificates'), $url);
    $PAGE->navbar->add(get_string('preview', 'block_customcertificates'));

    $output = $PAGE->get_renderer('block_customcertificates');

    $renderable = new block_customcertificates\output\view_page($id, $print);

    echo $output->header();

    echo $output->render($renderable);

    echo $output->footer();
} else {
    $certificate = new block_customcertificates\certificate_print($id, 297, 210, $print);
    if ($certificate->is_valid()) {
        $certificate->print_pdf();
    } else {
        echo $OUTPUT->header();
        echo $OUTPUT->footer();
    }
}
