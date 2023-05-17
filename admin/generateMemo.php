<?php
session_start();
include "../dbcon.php";
// Include the main TCPDF library (search for installation path).
require_once('includes/TCPDF/tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'header_img.png';
        $this->Image($image_file, 10, 10, 190, '', 'PNG', '', 'C', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        // $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', 'B', 12);

// add a page
$pdf->AddPage();

$GetData = mysqli_query($conn, "select *, DATE_FORMAT(`date`, '%M %D, %Y ') as `Edit_Date` from memo where id=" . $_GET['id'] . "");
$Datas = mysqli_fetch_array($GetData);

$memo_no = $Datas['memo_number'];
$from = trim($Datas['from']);
$date = $Datas['Edit_Date'];
$subject = $Datas['subject'];
$content = $Datas['content'];
$additional_info = $Datas['additional_info'];
$prepared_by = $_SESSION['username'];




$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0) ;
$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0) ;
$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0) ;
$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0) ;
$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0) ;
$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0) ;

$tbl = <<<EOD


<h4>Memorandum No. : $memo_no</h4>
<h5>Series of 2023</h6>


<h4>TO: </h4>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$sqlget = "SELECT f.`name`, f.`course_abb` FROM `memo_route` mr 
INNER JOIN `faculty` f ON f.`name` = mr.`faculty_name`
WHERE mr.`memo_id` = ".$Datas['id'].";";
$actresult = mysqli_query($conn, $sqlget);
while ($result = mysqli_fetch_assoc($actresult)) {
    $to = $result['name'] . " - " . $result['course_abb']." Faculty";
    $tbl2 = <<<EOD
    <h4 style="text-align: center"> $to</h4>
    EOD;

    $pdf->writeHTML($tbl2, true, false, false, false, '');
}

$tbl3 = <<<EOD
<h4>FROM: $from</h4></br>
<h4>Subject: $subject</h4>
<h4>Date: $date</h4></br>
EOD;
$pdf->writeHTML($tbl3, true, false, false, false, '');

$pdf->writeHTML("<hr>", true, false, false, false, '');

// -----------------------------------------------------------------------------

$contnt = <<<EOD

<p style="text-indent: 1cm;">$content </p></br>

<p style="text-indent: 1cm;">$additional_info</p>


EOD;
$pdf->writeHTML($contnt, true, false, false, false, '');

// -----------------------------------------------------------------------------

$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0) ;
$pdf->Write(0, '   ', '*', 0, 'C', TRUE, 0, false, false, 0) ;

$fotr = <<<EOD




<h4>Approved By:</h4></br>
<img src="./sign.png" />


EOD;
$fotrpres = <<<EOD




<h4>Approved By:</h4></br>
<img src="./pres.png" />


EOD;
$fotrmc = <<<EOD




<h4>Approved By:</h4></br>
<img src="./director.png" />


EOD;
$fotrid = <<<EOD




<h4>Approved By:</h4></br>
<img src="./iddean.png" />


EOD;

if ($from=="University - President")
{
    $pdf->writeHTML($fotrpres, true, false, false, false, '');
}
else if ($from=="BISU-MC Director")
{
    $pdf->writeHTML($fotrmc, true, false, false, false, '');
}
else if ($from=="CEA-ID Dean")
{
    $pdf->writeHTML($fotrid, true, false, false, false, '');
}
else{
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