<?php
	header('Content-Type: application/csv');
	header('Content-Disposition: attachment; filename="report.csv"');
	
	$rString = $_POST['report'];
	$report = json_decode($rString);

	//Open file
	$file = fopen('php://output', 'w');

	//Output header line
	fputcsv($file, array_keys((array)$report[0]));

	//Ouput each line of report as csv line
	foreach ($report as $line) {
		fputcsv($file, (array)$line);
	}

	//Clean up file and close
	fclose($file);
?>