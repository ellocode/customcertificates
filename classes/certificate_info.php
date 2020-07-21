<?php
// Standard GPL and phpdocs
namespace block_customcertificates;

use moodle_url;
use context_system;
use DateTime;

class certificate_info
{
    var $id;
    public $front_image;
    public $verse_image;
    public $issue_date;
    var $print;

    public function __construct($certificateid, $print)
    {
        $this->id = $certificateid;
        $this->print = $print;
        $this->front_image = self::get_images($certificateid, "front_image", $this->print);
        $this->verse_image = self::get_images($certificateid, "verse_image", $this->print);
        $this->issue_date = self::issue_date();
    }

    static function issue_date()
    {
        $date = new DateTime();
        return $date->getTimestamp();
    }
    public function  get_view_url()
    {
        $params = array("id" => $this->id, "print" => $this->print);
        $url = new moodle_url('/blocks/customcertificates/view.php', $params);
        return str_replace('&amp;', '&', $url);
    }
    public function  local_date()
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $local = "Rio de Janeiro, ";
        $local .= strftime('%d de %B de %Y', strtotime('today'));
        return $local;
    }
    static function get_images($certificateid, $position, $print)
    {
        $context = context_system::instance();
        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'block_customcertificates', $position, $certificateid);

        foreach ($files as $f) {
            if ($f->is_valid_image()) {
                if (!$print) {
                    return moodle_url::make_pluginfile_url($f->get_contextid(), $f->get_component(), $f->get_filearea(), $certificateid, $f->get_filepath(), $f->get_filename(), false);
                } else {
                    return $fs->get_file($f->get_contextid(), $f->get_component(), $f->get_filearea(), $certificateid, $f->get_filepath(), $f->get_filename());
                }
            }
        }
        return null;
    }
}
