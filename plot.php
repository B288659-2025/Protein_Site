<?php

// Start session so we can access the current dataset id
session_start();

require_once 'db.php';

// Load plotting functions
require_once 'analysis_functions.php';


// Get plot type
// Default is length plot
$type = $_GET['type'] ?? 'length';

// Get selected analysis id from session
$id = $_SESSION['id_analysis'] ?? null;


// Check if analysis exists
if(!$id)
{
	// Source: https://www.w3schools.com/php/func_network_http_response_code.asp
	http_response_code(404);
	exit("No analysis selected");
}


// Get sequences from database
$stmt = $pdo->prepare("select fasta_data from sequences where id_analysis = ?");
$stmt->execute([$id]);
$sequences = $stmt->fetchColumn();


// Get alignment data from database since they're eeded for conservation and heatmap plots
$stmt_align = $pdo->prepare("select alignment_data from alignments where id_analysis = ?");
$stmt_align->execute([$id]);
$alignment = $stmt_align->fetchColumn();


// Stop if alignment is missing
if (!$alignment)
{
	exit("No alignment found");
}


// Stop if sequences are missing
if(!$sequences)
{
	exit("No sequences found");
}


// Decide which plot to generate based on type
if($type == "length")
{
	$file = "/tmp/length_plot_" . $id . ".png";

	// Generate sequence length plot if file does not exist, otherwise, just load the file
	if (!file_exists($file))
	{
    		generate_length_plot($sequences, $id);
	}
}

elseif($type == "conservation")
{
	$file = "/tmp/conservation_plot_" . $id . ".png";

        // Generate conservation score plot if file does not exist, otherwise, just load the file
        if (!file_exists($file))
        {
	        generate_conservation_plot($sequences, $id);
        }

}

elseif($type == "aa")
{
	$file = "/tmp/aa_comp_" . $id . ".png";

        // Generate amino acid composition plot if file does not exist, otherwise, just load the file
        if (!file_exists($file))
        {
		generate_aa_composition_plot($sequences, $id);
        }

}

elseif ($type == "conserved_regions")
{
	$file = "/tmp/conserved_regions_" . $id . ".png";

        // Generate conserved regions plot using alignment if file does not exist, otherwise, just load the file
        if (!file_exists($file))
        {
                generate_conserved_regions_plot($alignment, $id);
        }
}

elseif ($type == "heatmap")
{
	$file = "/tmp/heatmap_" . $id . ".png";
        // Generate similarity heatmap using alignment if file does not exist, otherwise, just load the file
        if (!file_exists($file))
        {
                 generate_heatmap_plot($alignment, $id);
        }

}

elseif($type == "stats")
{
	// Return statistics as HTML instead of image
	header("Content-Type: text/html");

	echo get_statistics($sequences);

	exit;
}


// Send image to browser
// Source: https://www.php.net/manual/en/function.header.php
header("Content-Type: image/png");

// Display the generated plot file
// Source; https://www.php.net/manual/en/function.readfile.php
readfile($file);
