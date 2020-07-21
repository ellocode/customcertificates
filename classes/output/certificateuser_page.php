<?php
// Standard GPL and phpdocs
namespace block_customcertificates\output;

include_once('locallib.php');

use renderable;
use stdClass;

class certificateuser_page implements renderable
{
    public function __construct()
    {
    }

    /**                                                                                                                             
     * Export this data so it can be used as the context for a mustache template.                                                   
     *                                                                                                                              
     * @return stdClass                                                                                                             
     */
    public function export_for_template()
    {
        $data = new stdClass();
        $certificates = get_certificates_user();
        $data->message = get_string('nocertificatesavailable', 'block_customcertificates');
        $data->has_certificates = false;
        $data->certificates = array();
        if ($certificates) {
            $data->message = get_string('certificatesavailable', 'block_customcertificates');
            $data->has_certificates = true;
            $data->certificates = $certificates;
        }

        return $data;
    }
}
