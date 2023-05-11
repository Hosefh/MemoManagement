<?php


// Include the main TCPDF library (search for installation path).
require_once('includes/TCPDF/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

// $pdf->Write(0, 'Memorandum', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 12);

// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td rowspan="4"><img src=\"https://upload.wikimedia.org/wikipedia/en/0/0c/Bohol_Island_State_University.png\" border=0 border=\"0\" /></td>
        <td col>COL 2 - ROW 1</td>
        <td>Form No.:</td>
        <td>Revision No.:</td>
    </tr>
    <tr>
        <td>COL 2 - ROW 2 - COLSPAN 2</td>
        <td>Effectivity Date:</td>
        <td>OFFICE MEMORANDUM</td>
    </tr>
    <tr>
       <td>Related Process:</td>
    </tr>

</table>

<h4>Memorandum No. :</h4>
<h4>Series of 2023</h4>

<h4>TO:</h4></br>
<h4>FROM:</h4></br>
<h4>Subject:</h4>
<h4>Date:</h4></br>

EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->writeHTML("<hr>", true, false, false, false, '');

// -----------------------------------------------------------------------------

$contnt = <<<EOD

<h1 style="text-align: center;">Full Content and additional information here</h1></br>


EOD;
$pdf->writeHTML($contnt, true, false, false, false, '');

// -----------------------------------------------------------------------------


$fotr = <<<EOD

<h4>Prepared By: </h4></br>



<h4>Approved By: </h4></br


EOD;
$pdf->writeHTML($fotr, true, false, false, false, '');

// -----------------------------------------------------------------------------



//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+