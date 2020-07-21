<?php
require_once('../../config.php');
require_once('classes/module_form.php');

$id = optional_param('id', 0, PARAM_INT);

$context = context_system::instance();
$module = $DB->get_record('block_custommodules', ['id' => $id]);

$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
$url  =  new moodle_url('/blocks/custommodules/module.php');
$PAGE->set_url($url);

require_login();

$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('managemodules', 'block_custommodules'), new moodle_url('modulelist.php'));
$PAGE->navbar->add(get_string('editpage', 'block_custommodules'));

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

//
$moduleObj = new stdClass();
$moduleObj->id = 0;
$moduleObj->fullname = '';
$moduleObj->description = '';
$moduleObj->descriptionformat = FORMAT_HTML;

if ($module) {
  $moduleObj->id = $module->id;
  $moduleObj->fullname = $module->fullname;
  $moduleObj->description = $module->description;
  //editor
  $moduleObj = file_prepare_standard_editor($moduleObj, 'description', $definitionoptions, $context, 'block_custommodules', 'module', $moduleObj->id);
  //filemanager
  file_prepare_standard_filemanager($moduleObj, 'moduleimage', $attachmentoptions, $context, 'block_custommodules', 'moduleimage',  $moduleObj->id);
}

$mform = new module_form(null, array('definitionoptions' => $definitionoptions, 'attachmentoptions' => $attachmentoptions));

$mform->set_data($moduleObj);
if ($mform->is_cancelled()) {
  redirect(new moodle_url('/blocks/custommodules/modulelist.php'));
} else if ($data = $mform->get_data()) {

  if ($data->id > 0) {
    $data = file_postupdate_standard_editor($data, 'description', $definitionoptions, $context, 'block_custommodules', 'module', $data->id);
    $data = file_postupdate_standard_filemanager($data, 'moduleimage', $attachmentoptions, $context, 'block_custommodules', 'moduleimage', $data->id);

    $DB->update_record('block_custommodules', $data);
  } else {
    $data->id = $DB->insert_record('block_custommodules', $data);
    $data = file_postupdate_standard_editor($data, 'description', $definitionoptions, $context, 'block_custommodules', 'module', $data->id);
    $data = file_postupdate_standard_filemanager($data, 'moduleimage', $attachmentoptions, $context, 'block_custommodules', 'moduleimage', $data->id);

    $DB->update_record('block_custommodules', $data);
  }
  redirect(new moodle_url('/blocks/custommodules/modulelist.php'));
}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
