<?php

class block_customcertificates_edit_form extends block_edit_form
{

  protected function specific_definition($mform)
  {
    $url  =  new moodle_url('/blocks/customcertificates/certificatelist.php');
    $attributes = array('size' => '40');

    $has_capability = has_capability('moodle/course:update', context_system::instance());
    // Section header title according to language file.
    if ($has_capability) {

      $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));
      $mform->addElement('html', '<div class="row">');
      $mform->addElement('html', '<div class="col-md-8"></div>');
      $mform->addElement('html', '<div class="col-md-4">');
      $mform->addElement('html', '<a class="btn btn-primary" href=' . $url . '>' . get_string('managecertificates', 'block_customcertificates') . '</a>');
      $mform->addElement('html', '</div>');
      $mform->addElement('html', '</div>');
      //--//
      $mform->addElement('html', '</p>');
      //--//
      $mform->addElement('html', '<div class="row">');
      $mform->addElement('html', '<div class="col-md-8">');

      $mform->addElement('text', 'config_title', get_string('label_txt_default_title', 'block_customcertificates'), $attributes);
      $mform->setDefault('config_title', get_string('defaulttitle', 'block_customcertificates'));
      $mform->setType('config_title', PARAM_TEXT);

      if (!empty($this->config->text)) {
        $this->content->text = $this->config->text;
      }

      $mform->addElement('html', '</div>');
      $mform->addElement('html', '<div class="col-md-4"></div>');
      $mform->addElement('html', '</div>');
    }
  }
}
