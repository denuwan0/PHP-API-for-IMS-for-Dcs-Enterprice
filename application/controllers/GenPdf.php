<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GenPdf extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	function invoice()
    {
        $this->load->library('pdf');
        $html = $this->load->view('template/pdfInvoice', [], true);
        return $status = $this->pdf->createPDF($html, 'mypdf', false);
    }
		
}
