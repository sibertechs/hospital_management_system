<?php
// Include the TCPDF library
require './TCPDF/tcpdf.php'; // Adjust the path if necessary
require './public/include/connect.php'; // Include your database connection

if(isset($_GET['viewid'])){
    $viewid = $_GET['viewid'];
    $q = mysqli_query($connect, "SELECT * FROM patient_report WHERE id = '$viewid'");
    $data = mysqli_fetch_assoc($q);

    // Create a new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Patient Details');
    $pdf->SetSubject('Patient Details Report');
    $pdf->SetKeywords('TCPDF, PDF, patient, details, report');

    // Set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // Set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // Set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // Set font
    $pdf->SetFont('dejavusans', '', 10);

    // Add a page
    $pdf->AddPage();

    // Write the patient's details
    $html = '
    <h1>Patient Details</h1>
    <table border="1" cellpadding="4">
        <tr>
            <th>Patient\'s Name</th>
            <td>' . (isset($data['name']) ? $data['name'] : '') . '</td>
        </tr>
        <tr>
            <th>Illness</th>
            <td>' . (isset($data['illness']) ? $data['illness'] : '') . '</td>
        </tr>
        <tr>
            <th>Patient\'s Contact</th>
            <td>' . (isset($data['patient_contact']) ? $data['patient_contact'] : '') . '</td>
        </tr>
        <tr>
            <th>Referral Doctor\'s Name</th>
            <td>' . (isset($data['ref_doctor_name']) ? $data['ref_doctor_name'] : '') . '</td>
        </tr>
        <tr>
            <th>Referral Hospital</th>
            <td>' . (isset($data['ref_hospital']) ? $data['ref_hospital'] : '') . '</td>
        </tr>
        <tr>
            <th>Referral Doctor\'s Contact</th>
            <td>' . (isset($data['ref_doctor_contact']) ? $data['ref_doctor_contact'] : '') . '</td>
        </tr>
        <tr>
            <th>Referral Hospital Location</th>
            <td>' . (isset($data['ref_hospital_location']) ? $data['ref_hospital_location'] : '') . '</td>
        </tr>
        <tr>
            <th>Location Of Hospital Referred To</th>
            <td>' . (isset($data['location_hosp_referred']) ? $data['location_hosp_referred'] : '') . '</td>
        </tr>
        <tr>
            <th>Name Of Hospital Referred To</th>
            <td>' . (isset($data['name_hosp_referred']) ? $data['name_hosp_referred'] : '') . '</td>
        </tr>
    </table>';

    // Output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Close and output PDF document
    $pdf->Output('patient_details.pdf', 'I');
}
?>
