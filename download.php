<?php
/*
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="report.csv"');

ob_end_clean();

//Open file
$handle = fopen('php://output', 'w');
$report = $_POST["report"];

//Output header line
fputcsv($file, array_keys($report));

//Ouput each line of report as csv line
foreach ($report as $line) {
    fputcsv($handle, $line);
}

//Clean up file and close
fclose($file);
ob_flush();
*/
print_r($_POST['report']);
?>