<?php

if (session_status() === PHP_SESSION_NONE)
{
	session_start();
}

require_once "db.php";

// Update dataset id based on user selection
if (isset($_POST['analysis_id']))
{
	$_SESSION['id_analysis'] = $_POST['analysis_id'];
}

$id = $_SESSION['id_analysis'] ?? null;

// Stop if no dataset has been selected
if (!$id)
{
	echo "Please select a dataset first";
	exit;
}


// Create a unique temporary folder to store export files
$tmp_dir = sys_get_temp_dir() . "/export_" . uniqid();

// Small safety check to ensure the directly is correctly made
if (!mkdir($tmp_dir))
{
	echo "Could not create temporary directory";
	exit;
}


// Track whether the user selected anything to export
$something_selected = false;

// Track whether any figure files were made - since the additional analyses are optional
$copied_any = false;


// Export sequences if selected
if (isset($_POST['export_sequences']))
{
	$something_selected = true;

	// Get selected file format, default is FASTA
	$format = $_POST['sequences_format'] ?? "fasta";

	$stmt = $pdo->prepare("select fasta_data from sequences where id_analysis = ?");
	$stmt->execute([$id]);

	$sequences = $stmt->fetchColumn();

	if ($sequences)
	{
		if ($format == "txt")
		{
			$filename = "sequences.txt";
		}
		else
		{
			$filename = "sequences.fasta";
		}

		file_put_contents($tmp_dir . "/" . $filename, $sequences);
	}
}


// Export alignment if selected
if (isset($_POST['export_alignment']))
{
	$something_selected = true;

	// Get selected format, default is FASTA
	$format = $_POST['alignment_format'] ?? "fasta";

	$source_file = "/tmp/alignment_" . $id . ".fasta";
	if (!file_exists($source_file))
	{
		echo "Alignment file not found";
		exit;
	}

	if ($format == "txt")
	{
		$filename = "alignment.txt";
	}
	else
	{
		$filename = "alignment.fasta";
	}

	copy($source_file,$tmp_dir . "/" . $filename);
}


// Export motif report if selected
if (isset($_POST['export_motif_report']))
{
	$something_selected = true;

	$file = "/tmp/motifs_" . $id . ".txt";
	if (file_exists($file))
	{
		copy($file, $tmp_dir . "/motif_report.txt");
	}
}


// Export figures if selected
if (isset($_POST['export_figures']))
{
	$something_selected = true;

	$id = $_SESSION['id_analysis'];

	// List of possible figure files
	$figures = ["/tmp/length_plot_" . $id . ".png", "/tmp/conservation_plot_" . $id . ".png", "/tmp/aa_comp_" . $id . ".png", "/tmp/heatmap_" . $id . ".png", "/tmp/conserved_regions_" . $id . ".png"];

	// Copy each figure if it exists
	foreach ($figures as $file)
	{
		if (file_exists($file))
		{
			copy($file, $tmp_dir . "/" . basename($file));
			$copied_any = true;
		}
	}
}


// If user selected figures but none exist, show message
if (isset($_POST['export_figures']) && !$copied_any)
{
	echo "No figures available to export.";
	exit;
}


// If user selected nothing at all, return to export page with error
if (!$something_selected)
{
	header("Location: export.php?error=1");
	exit;
}


// Create zip file from the temporary export folder
$zip_file = $tmp_dir . ".zip";

// Source for escapeshellarg: https://www.php.net/manual/en/function.escapeshellarg.php
// Source for exec: https://www.php.net/manual/en/function.escapeshellarg.php
$command = "zip -r " . escapeshellarg($zip_file) . " " . escapeshellarg($tmp_dir);

exec($command);


// Send the zip file to the browser for download
// Header function source: https://www.php.net/manual/en/function.header.php
header("Content-Type: application/zip");
header("Content-Disposition: attachment; filename=export_results.zip");
header("Content-Length: " . filesize($zip_file));

// Readfile source: https://www.php.net/manual/en/function.readfile.php
readfile($zip_file);


// Delete the zip file after sending it
unlink($zip_file);


// Delete the temporary export folder and its contents
exec("rm -rf " .escapeshellarg($tmp_dir));

exit;

?>
