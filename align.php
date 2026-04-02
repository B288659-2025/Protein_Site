<?php

// Start the session to use stored data
session_start();

// Include navigation menu
require_once 'menu.php';

// Include database connection
require_once 'db.php';

// Show page title
echo "<h2 class='section-title'>Sequence Alignment</h2>";

// Use main container cass for visualisation
echo "<div class='container'>";

// Get analysis id from session
$id_analysis = $_SESSION['id_analysis'] ?? null;


// Check if dataset was selected
if (!$id_analysis)
{
	// tell the user to select a dataset first
	echo "<p class='info-text'>";
	echo "Please select a dataset first";
	echo "</p>";
	echo "</div>";
	exit;
}


// Prepare SQL query to get alignment data from database
$stmt = $pdo->prepare("select alignment_data from alignments where id_analysis = ?");

// Run the query using the analysis id
$stmt->execute([$id_analysis]);

// Get the alignment result from database
$alignment = $stmt->fetchColumn();


// Remove spaces from start and end before checking and then check if alignment is empty
if (!$alignment || trim($alignment) == "")
{
	// If yes, clarify that at least 2 sequences are needed for an alignment
	echo "<p class='info-text'>";
	echo "Alignment requires at least 2 sequences.";
	echo "</p>";
	echo "</div>";
	exit;
}


// Start FASTA display area
echo "<div class='fasta-container'>";


// Split sequences using the > symbol and use explode since it splits text into parts
// Explode source: https://www.php.net/manual/en/function.explode.php
$alignment = explode(">", $alignment);


// Loop through each sequence
foreach ($alignment as $align)
{
	// Remove spaces and skip empty parts
	if (trim($align) == "") continue;

	// Split sequence into lines using new line
	$lines = explode("\n", trim($align));

	// Take first line as header then array_shift removes the first item
	// Array_shift source: https://www.php.net/manual/en/function.array-shift.php
	$header = array_shift($lines);

	// Join remaining lines into one sequence using implode which joins text together
	// Implode source: https://www.php.net/manual/en/function.implode.php
	$sequence = implode("", $lines);


	// Use the sequence-card class to represent each sequence alignment in a card
	echo "<div class='sequence-card'>";

	// Show sequence name
	echo "<div class='sequence-header'>$header</div>";

	// Show sequence letters
	echo "<div class='sequence-body'>" . $sequence . "</div>";

	echo "</div>";
}


echo "</div>";

?>
