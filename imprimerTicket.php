<?php
// Path to the text file you want to print
$textFilePath = 'ticket.txt';  // Update with your actual text file path
$printerName = "EPSON TM-T20 Receipt";  // Replace with your actual printer name




    // Escape the paths to prevent errors
    $textFilePath = escapeshellarg($textFilePath);
    $printerName = escapeshellarg($printerName);

    // Command to print the text file using the Windows print command
    $command = "start /min notepad /p $textFilePath $printerName";

    // Execute the shell command to send the text file to the printer
    $output = shell_exec($command);

    // Check if the command was successful
    if ($output === null) {
        echo "Text file has been sent to the printer successfully.";
    } else {
        echo "Error: " . $output;
    }

?>
