<?php
// Standard GPL and phpdocs
namespace block_customcertificates;

use stdClass;

require_once($CFG->libdir . '/pdflib.php');
require_once('locallib.php');

class certificate_print
{
    var  $certificateid;
    var  $width;
    var  $height;
    var  $print;

    public function __construct($certificateid, $width, $height, $print)
    {
        $this->certificateid = $certificateid;
        $this->width = $width;
        $this->height = $height;
        $this->print = $print;
        $this->instance = $this->get_instance();
    }
    protected function get_instance()
    {
        $certificates = get_certificates_user($this->certificateid, $this->print);
        $certificate = reset($certificates);
        return $certificate;
    }
    protected function create_pdf_object()
    {
        // Default orientation is Landescape.
        $orientation = 'L';

        if ($this->height > $this->width) {
            $orientation = 'P';
        }
        $pdf = new \pdf($orientation, 'mm', array($this->width, $this->height), true, 'UTF-8', false);
        $pdf->SetTitle($this->instance->fullname);
        $pdf->SetSubject($this->instance->fullname);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->setFontSubsetting(true);
        $pdf->SetMargins(0, 0, 0, true);
        // remove default header/footer

        return $pdf;
    }
    public function create_pdf()
    {
        $pdf = $this->create_pdf_object();
        //pagina frontal 
        $pdf->AddPage('L', 'A4');
        $pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');

        //imagem de fundo
        $file = $this->instance->front_image;
        if ($file) {
            $tmpfilename = $file->copy_content_to_temp("block_customcertificates", 'front_image_');
            $pdf->Image($tmpfilename, 0, 0, $this->width, $this->height);
            @unlink($tmpfilename);
        }
        //nome do participante 
        $pdf->SetXY(0, 80);
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->SetTextColor(11, 32, 95);
        $pdf->MultiCell(0, 0, $this->instance->name_user, 1, 'C', false, 1);

        //data de emissão
        $pdf->SetXY(0, 140);
        $pdf->SetFont('helvetica', '', 14);
        $pdf->SetTextColor(11, 32, 95);
        $pdf->MultiCell(0, 0, $this->instance->local_date, 1, 'C', false, 1);


        //Verso 
        $pdf->AddPage();
        $file = $this->instance->verse_image;
        if ($file) {
            $tmpfilename = $file->copy_content_to_temp("block_customcertificates", 'verse_image_');
            $pdf->Image($tmpfilename, 0, 0, $this->width, $this->height);
            @unlink($tmpfilename);
        }
        //modulos e coursos
        $pdf->SetXY(50, 20);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(11, 32, 95);
        $pdf->writeHTMLCell(0, 0, '', '', $this->get_modules_html(), 0, 1, 0, true, '', true);

        return $pdf;
    }
    function get_modules_html()
    {

        $html = '<div class="fundoVerso">';
        $html .= '<div class="cursos">';

        foreach ($this->instance->modules as $module) {
            $html .= '<h4>' . $module->fullname . ' - Carga horária: ' . $module->total_hours .  '</h4>';
            $html .= "<ul>";
            foreach ($module->courses as $course) {
                $html .= "<li>" . $course->fullname . "</li>";
            }
            $html .= "</ul>";
        }

        $html .= "</div>";
        $html .= "</div>";

        return $html;
    }
    function sanitize_html($html)
    {
        $params = "&nbsp;";
        return html_entity_decode(strip_tags($html, $params));
    }
    public function print_pdf()
    {

        save_certificate_user($this->instance->id, $this->instance->userid, $this->instance->fullname, $this->instance->issue_date);

        $pdf = $this->create_pdf();
        //ob_end_clean();
        $filename = $this->instance->fullname . $this->instance->issue_date . ".pdf";
        $pdf->Output();
        //$pdf->Output($filename, 'D');
    }
    public function is_valid()
    {
        if ($this->instance) {
            return true;
        } else {
            return  \core\notification::error("Ainda não há um certificado configurado.");
        }
    }
}
