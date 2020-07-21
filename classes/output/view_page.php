<?php
// Standard GPL and phpdocs
namespace block_customcertificates\output;

include_once('locallib.php');

use renderable;
use stdClass;

class view_page implements renderable
{
    /** @var stdClass $sometext Some text to show how to pass data to a template. */
    var $certificateid = null;
    var $print;

    public function __construct($certificateid, $print)
    {
        $this->certificateid = $certificateid;
        $this->print = $print;
    }

    /**                                                                                                                             
     * Export this data so it can be used as the context for a mustache template.                                                   
     *                                                                                                                              
     * @return stdClass                                                                                                             
     */
    public function export_for_template()
    {

        $certificates = get_certificates_user($this->certificateid, $this->print);
        $certificate = reset($certificates);
        if ($certificate) {
            return $certificate;
        } else {
            $notification = \core\notification::error("A  configuração do certificado ainda não foi concluída");
        }
    }
}
