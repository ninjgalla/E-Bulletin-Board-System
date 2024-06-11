<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// generate_pdf.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $fileId = $data['id'];

    // Connect to the database
    $mysqli = new mysqli("localhost", "root", "", "ebulletin_system");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Prepare and execute SQL query to fetch file data by ID
    $stmt = $mysqli->prepare("SELECT * FROM bulletin_files WHERE id = ?");
    $stmt->bind_param("i", $fileId);
    $stmt->execute();
    $result = $stmt->get_result();
    $fileData = $result->fetch_assoc();

    // Check if file data exists
    if ($fileData) {
        // Include the TCPDF library
        require_once('C:/xampp/htdocs/ebulletin/tcpdf.php');

        // Create new PDF document
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        // Add title
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, $fileData['title'], 0, 1, 'C');

        // Add description
        $pdf->SetFont('helvetica', '', 12);
        $pdf->MultiCell(0, 10, $fileData['description'], 0, 'L', 0, 1, '', '', true);

        // Add image if filename is provided
        if (!empty($fileData['filename'])) {
            $imagePath = 'C:/xampp/htdocs/ebulletin/uploads/' . $fileData['filename'];
            if (file_exists($imagePath)) {
                $pdf->Image($imagePath, 15, 60, 180); // Adjust the parameters as needed
            } else {
                $pdf->Write(0, 'Image not found: ' . $imagePath, '', 0, 'L', true, 0, false, false, 0);
            }
        }

        // Clean the output buffer to avoid sending any extraneous output
        if (ob_get_length()) {
            ob_end_clean();
        }

        // Output the PDF as a download
        header('Content-Type: application/pdf');
        $pdf->Output('file.pdf', 'D');
        
    } else {
        echo 'No record found for the given ID.';
    }

    // Close database connection and statement
    $stmt->close();
    $mysqli->close();
}
?>
