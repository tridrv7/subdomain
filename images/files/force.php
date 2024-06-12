<?php

require('../../conf/config.php');

// Ensure that a filename is provided
if (isset($_GET['file'])) {
   $fileName = basename($_GET['file']);
   $filePath = '../files/' . $fileName; // Adjust the path to your files accordingly

    // Check if the file exists
   if (file_exists($filePath)) {
        // Set headers for force download
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="' . $fileName . '"');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($filePath));

      // Read the file and output it to the browser
      readfile($filePath);

      $query = "UPDATE pub_files SET files_down = files_down + 1 WHERE files_nm = '$fileName'";
      $mysqli->query($query);

      exit;

   } else {
      header("Location: ../error.php");
   }
   
} else {
   echo "Invalid request.";
}


?>
