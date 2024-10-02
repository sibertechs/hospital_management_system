<?php
require "./public/include/connect.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the billing record
    $query = "SELECT * FROM billing WHERE id=$id";
    $result = mysqli_query($connect, $query);
    
    if ($billing = mysqli_fetch_assoc($result)) {
        // Fetch the drug details
        $drug_query = "SELECT drug_name, drug_type, illness, dossage FROM drugs WHERE id=" . intval($billing['drug_id']);
        $drug_result = mysqli_query($connect, $drug_query);
        $drug = mysqli_fetch_assoc($drug_result);

        // Ensure drug details are set
        $drug_name = isset($drug['drug_name']) ? $drug['drug_name'] : 'Unknown Drug Name';
        $drug_type = isset($drug['drug_type']) ? $drug['drug_type'] : 'Unknown Drug Type';
        $illness = isset($drug['illness']) ? $drug['illness'] : 'Unknown Illness';
        $dossage = isset($drug['dossage']) ? $drug['dossage'] : 'Unknown Dossage';

        // Create the invoice content
        $invoiceContent = "Invoice\n";
        $invoiceContent .= "-------------------------------------\n";
        $invoiceContent .= "Patient Name: " . htmlspecialchars($billing['name'] ?? 'Unknown') . "\n";
        $invoiceContent .= "Amount: GH₵" . htmlspecialchars($billing['amount'] ?? '0.00') . "\n";
        $invoiceContent .= "Date: " . htmlspecialchars($billing['date'] ?? 'N/A') . "\n";
        $invoiceContent .= "Drug Name: " . htmlspecialchars($drug_name) . "\n";
        $invoiceContent .= "Drug Type: " . htmlspecialchars($drug_type) . "\n";
        $invoiceContent .= "Illness: " . htmlspecialchars($illness) . "\n";
        $invoiceContent .= "Dossage: " . htmlspecialchars($dossage) . "\n";
        $invoiceContent .= "-------------------------------------\n";
        $invoiceContent .= "Thank you for your business!\n";

        // Set headers to download the invoice as a text file
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=\"" . htmlspecialchars($billing['name']) . "_invoice.txt\"");

        // Output the content
        echo $invoiceContent;
    } else {
        echo "Record not found.";
    }
} else {
    echo "Invalid ID.";
}
?>
