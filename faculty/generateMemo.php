<?php
session_start();
include "../dbcon.php";
// Include the main TCPDF library (search for installation path).
require_once('includes/TCPDF/tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{

    //Page header
    public function Header()
    {
        // Logo
        $image_file = K_PATH_IMAGES . 'header_img.png';
        $this->Image($image_file, 10, 10, 190, '', 'PNG', '', 'C', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        // $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// // set document information
// $pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor('Nicola Asuni');
// $pdf->SetTitle('TCPDF Example 003');
// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 12);

// add a page
$pdf->AddPage();

$GetData = mysqli_query($conn, "select *, DATE_FORMAT(`date_created`, '%M %d, %Y ') as `Edit_Date` from memo where id=" . $_GET['id'] . "");
$Datas = mysqli_fetch_array($GetData);

$memo_no = $Datas['memo_number'];
$from = trim($Datas['from']);
$date = $Datas['Edit_Date'];
$subject = $Datas['subject'];
$content = $Datas['content'];
$additional_info = $Datas['additional_info'];
$prepared_by = $_SESSION['username'];




$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0);
$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0);
$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0);
$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0);
$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0);
$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0);

$tbl = <<<EOD


<h4>Memorandum No. : $memo_no</h4>
Series of 2023
<br><br>

To:
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');


//mao n ang backend sa pagkuha sa tanan to
$sqlget = "SELECT f.`name`, f.`course_abb` FROM `memo_route` mr 
INNER JOIN `faculty` f ON f.`name` = mr.`faculty_name`
WHERE mr.`memo_id` = " . $Datas['id'] . ";";
$actresult = mysqli_query($conn, $sqlget);
while ($result = mysqli_fetch_assoc($actresult)) {
    $to = $result['name'] . " - " . $result['course_abb'] . " Faculty";
    $tbl2 = <<<EOD
    <p style="text-align: left; text-indent: 1cm">             $to</p>
    EOD;

    $pdf->writeHTML($tbl2, true, false, false, false, '');
}

$tbl3 = <<<EOD
<br><br>From: $from</br> <br><br>
Subject: $subject<br><br>
Date: $date</br>
EOD;
$pdf->writeHTML($tbl3, true, false, false, false, '');

$pdf->writeHTML("<hr>", true, false, false, false, '');

// -----------------------------------------------------------------------------

$contnt = <<<EOD

<p style="text-indent: 1cm;">$content </p></br>

<p style="text-indent: 1cm;">Other Details: $additional_info</p>


EOD;
$pdf->writeHTML($contnt, true, false, false, false, '');

// -----------------------------------------------------------------------------

$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0);
$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0);

$fotr = <<<EOD




<h4>Approved:</h4></br>
<img src="./sign.png" />


EOD;
$fotrpres = <<<EOD




<h4>Approved:</h4></br>
<img src="./pres.png" />


EOD;
$fotrVpres = <<<EOD




<h4>Approved:</h4></br>
<img src="./v-pres.png" />


EOD;
$fotrmc = <<<EOD




<h4>Approved:</h4></br>
<img src="./director.png" />


EOD;
$fotrid = <<<EOD




<h4>Approved:</h4></br>
<img src="./dean.png" />


EOD;

if ($from == "University President") {
    $pdf->writeHTML($fotrpres, true, false, false, false, '');
} else if ($from == "University V-President") {
    $pdf->writeHTML($fotrVpres, true, false, false, false, '');
} else if ($from == "BISU-MC Director") {
    $pdf->writeHTML($fotrmc, true, false, false, false, '');
} else if ($from == "College of Engineering and Architecture, Dean") {
    $pdf->writeHTML($fotrid, true, false, false, false, '');
} else {
    $pdf->writeHTML($fotrpres, true, false, false, false, '');
}

// -----------------------------------------------------------------------------


// set some text to print
// $txt = <<<EOD
// TCPDF Example 003

// Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
// EOD;

// // print a block of text using Write()
// $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+