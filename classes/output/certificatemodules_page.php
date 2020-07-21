<?php
// Standard GPL and phpdocs
namespace block_customcertificates\output;

use renderable;

class certificatemodules_page implements renderable
{
    var $certificateid = 0;

    public function __construct($certificateid)
    {
        $this->certificateid = $certificateid;
    }

    public function export_for_template()
    {
        $renderable = new \block_customcertificates\renderable_certificate_modules($this->certificateid);
        return $renderable->get_certificate_modules();
    }
}
