<?php

require_once("{$CFG->libdir}/formslib.php");

class module_form extends moodleform
{

    function definition()
    {


        $mform = &$this->_form;
        $definitionoptions = $this->_customdata['definitionoptions'];
        $attachmentoptions = $this->_customdata['attachmentoptions'];

        $mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);
        $mform->addElement('text', 'fullname', get_string('label_add_modules', 'block_custommodules'), array('size' => '60'));
        $mform->addRule('fullname', get_string('required'), 'required', null);
        $mform->setType('fullname', PARAM_TEXT);

        $mform->addElement('editor', 'description_editor', get_string('label_desc_add_modules', 'block_custommodules'), null, $definitionoptions);
        $mform->setType('description_editor', PARAM_RAW);
        $mform->addElement('filemanager', 'moduleimage_filemanager', get_string('label_add_image_modules', 'block_custommodules'), null, $attachmentoptions);

        $buttons = array();
        $buttons[] = $mform->createElement('submit', 'submitbutton', get_string('title_btn_add_modules', 'block_custommodules'));
        $buttons[] = $mform->createElement('cancel');
        $mform->addGroup($buttons, 'buttonarr', '', array(' '), false);
    }
    function definition_after_data()
    {
        $mform = &$this->_form;
        if ($mform->elementExists('id') && $mform->getElementValue('id')) {
            $mform->removeElement('buttonarr');
            $buttons[] = $mform->createElement('submit', 'submitbutton', get_string('title_btn_edit_modules', 'block_custommodules'));
            $buttons[] = $mform->createElement('cancel');
            $mform->addGroup($buttons, 'buttonarr', '', array(' '), false);
        }
    }
    function validation($data, $files)
    {
        $errors = parent::validation($data, $files);
        if (empty($data['fullname'])) {
            $errors['fullname'] = get_string('required');
        }
        return $errors;
    }
}
