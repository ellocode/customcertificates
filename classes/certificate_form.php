<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Edit category form.
 *
 * @package core_course
 * @copyright 2002 onwards Martin Dougiamas (http://dougiamas.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once("{$CFG->libdir}/formslib.php");

class block_customcertificates_certificate_form extends moodleform
{

    function definition()
    {
        $mform = &$this->_form;

        $definitionoptions = $this->_customdata['definitionoptions'];
        $attachmentoptions = $this->_customdata['attachmentoptions'];

        $mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);
        //title
        $mform->addElement('text', 'fullname', get_string('label_add_certificate', 'block_customcertificates'), array('size' => '60'));
        $mform->addRule('fullname', get_string('required'), 'required', null);
        $mform->setType('fullname', PARAM_TEXT);
        //description
        $mform->addElement('editor', 'description_editor', get_string('label_desc_add_certificate', 'block_customcertificates'), null, $definitionoptions);
        $mform->setType('description_editor', PARAM_RAW);
        $mform->addRule('description_editor', get_string('required'), 'required', null);
        // assinaturas
        $mform->addElement('filemanager', 'frontimage_filemanager', get_string('front_image', 'block_customcertificates'), null, $attachmentoptions);
        $mform->addElement('filemanager', 'verseimage_filemanager', get_string('verse_image', 'block_customcertificates'), null, $attachmentoptions);
        //botoes
        $buttons = array();
        $buttons[] = $mform->createElement('submit', 'submitbutton', get_string('title_btn_add_certificate', 'block_customcertificates'));
        $buttons[] = $mform->createElement('cancel');
        $mform->addGroup($buttons, 'buttonarr', '', array(' '), false);
    }
    function definition_after_data()
    {
        $mform = &$this->_form;
        if ($mform->elementExists('id') && $mform->getElementValue('id')) {
            $mform->removeElement('buttonarr');
            $buttons[] = $mform->createElement('submit', 'submitbutton', get_string('title_btn_edit_certificate', 'block_customcertificates'));
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
