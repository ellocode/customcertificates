<?php
// Standard GPL and phpdocs
require_once('../../config.php');
require_once('lib.php');
require_once('classes/certificate_form.php');

require_login();

$id = optional_param('id', 0, PARAM_INT); // id certificado 
$context = context_system::instance();
$certificate = $DB->get_record('block_customcertificates', ['id' => $id]);

$url  =  new moodle_url('/blocks/customcertificates/certificate.php');
$return_url  =  new moodle_url('/blocks/customcertificates/certificatelist.php');
//navigation
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('managecertificates', 'block_customcertificates'), new moodle_url('certificatelist.php'));
$PAGE->navbar->add(get_string('editpage', 'block_customcertificates'));

$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('pluginname', 'block_customcertificates'));

require_capability('moodle/course:update', $context);

$definitionoptions = array(
  'maxbytes'  => $CFG->maxbytes,
  'trusttext' => false,
  'context'   => $context,
  'subdirs'   => false
);
$attachmentoptions = array(
  'subdirs' => 0,
  'maxfiles' => 1,
  'accepted_types' => array('.png', '.jpeg', '.jpg')
);

$object = new stdClass();
$object->id = 0;
$object->fullname = '';
$object->description = '';
$object->timecreated = '';
$object->timemodified = '';
$object->descriptionformat = FORMAT_HTML;

if ($certificate) {
  $object->id = $certificate->id;
  $object->fullname = $certificate->fullname;
  $object->description = $certificate->description;

  $object = file_prepare_standard_editor($object, 'description', $definitionoptions, $context, 'block_customcertificates', 'certificate', $object->id);
  file_prepare_standard_filemanager($object, 'frontimage', $attachmentoptions, $context, 'block_customcertificates', 'front_image', $object->id);
  file_prepare_standard_filemanager($object, 'verseimage', $attachmentoptions, $context, 'block_customcertificates', 'verse_image', $object->id);
}

$mform = new block_customcertificates_certificate_form(null, array(
  'definitionoptions' => $definitionoptions,
  'attachmentoptions' => $attachmentoptions
));

$mform->set_data($object);

if ($mform->is_cancelled()) {

  redirect($return_url);
} else if ($data = $mform->get_data()) {

  if ($data->id > 0) {
    $data->timemodified = strtotime(date("d-m-Y"));
    $data = file_postupdate_standard_editor($data, 'description', $definitionoptions, $context, 'block_customcertificates', 'certificate', $data->id);
    $data = file_postupdate_standard_filemanager($data, 'frontimage', $attachmentoptions, $context, 'block_customcertificates', 'front_image', $data->id);
    $data = file_postupdate_standard_filemanager($data, 'verseimage', $attachmentoptions, $context, 'block_customcertificates', 'verse_image', $data->id);
    $DB->update_record('block_customcertificates', $data);
  } else {
    $data->timecreated = strtotime(date("d-m-Y"));
    $data->id = $DB->insert_record('block_customcertificates', $data);
    $data = file_postupdate_standard_editor($data, 'description', $definitionoptions, $context, 'block_customcertificates', 'certificate', $data->id);
    $data = file_postupdate_standard_filemanager($data, 'frontimage', $attachmentoptions, $context, 'block_customcertificates', 'front_image', $data->id);
    $data = file_postupdate_standard_filemanager($data, 'verseimage', $attachmentoptions, $context, 'block_customcertificates', 'verse_image', $data->id);
    $DB->update_record('block_customcertificates', $data);
  }
  redirect($return_url);
}
//
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
