<?php

// Start session so we can access the current dataset id
session_start();

// Include navigation menu
require 'menu.php';

// Include database connection because we read datasets from the database
require 'db.php';

// Display page title
echo "<h2 class='section-title'>Export Results</h2>";


// Show message if user clicked download without selecting anything
if (isset($_GET['error']))
{
	echo "<p class='info-text'>Please select something to export</p>";
}


// Get current dataset id from the session
$id = $_SESSION['id_analysis'] ?? null;


// If no dataset is selected, stop and tell the user
if (!$id)
{
	echo "<p class='info-text'>Please select a dataset first</p>";
	exit;
}


// Start the export form
// Data will be sent to download.php when user clicks Download
echo "<form method='POST' action='download.php'>";

// Use the card class for visualisation
echo "<div class='card'>";

// Get the current session id so we can show only datasets from this session
$session_id = session_id();


// Get the current session id so we can filter datasets correctly
$session_id = session_id();


// If the user is logged in, show their datasets plus the example dataset
if (isset($_SESSION['id_user']))
{
	$stmt = $pdo->prepare("Select id_analysis, name, protein, taxon, seq_max, created_at, exclude_partial, manual_only from analyses where id_user = ? 
	or name = 'Example Dataset' order by created_at desc");
	$stmt->execute([$_SESSION['id_user']]);
}
else
{
	// If the user is a guest, show datasets from this session plus the example dataset

	$stmt = $pdo->prepare("Select id_analysis, name, protein, taxon, seq_max, created_at, exclude_partial, manual_only from analyses where session_id = ? 
	or name = 'Example Dataset' order by created_at desc");
	$stmt->execute([$session_id]);
}
echo "<div class='form-row'>";

echo "<label for='analysis_id'><strong>Dataset to export:</strong></label>";


// Dropdown menu to choose which dataset to export
echo "<select id='analysis_id' name='analysis_id' required>";


// Loop through each dataset and add it as an option
while ($row = $stmt->fetch())
{
	$id = $row['id_analysis'];
	$name  = $row['name'];
	$taxon = $row['taxon'];
	$count = $row['seq_max'];

	// Format the date nicely - get the date using strtotime
	// Source: https://www.php.net/manual/en/function.strtotime.php
	// Do not display the creation date for the example dataset,because it reflects the first time the dataset was generated,not when the current user selected it.
	// The example dataset is created once and then reused for all users.
	if ($name === "Example Dataset")
	{
		$date = "System data";
	}
	else
	{
		$date = date("d M Y H:i", strtotime($row['created_at']));
	}

	// Store selected filters in a list
	$filters = [];

	if ($row['exclude_partial'])
		$filters[] = "Exclude partial";

	if ($row['manual_only'])
		$filters[] = "Manual only";

	// Join filters into one text string using the implode function
	// Source: https://www.php.net/manual/en/function.implode.php
	$filter_text = implode(", ", $filters);

	// Build the label shown in the dropdown
	$label = "$name ($taxon) | $count sequences";

	if ($filter_text)
		$label .= " | $filter_text";

	$label .= " | $date";

	echo "<option value='$id'>$label</option>";
}

echo "</select>";

echo "</div>";


// Section title for export choices
echo "<h4>Choose data to export</h4>";


// Option to export sequences
echo "<div class='export-option'>";
echo "<label>";
echo "<input type='checkbox' name='export_sequences'>";
echo " Sequences";

// Choose file format for sequences
echo "<select name='sequences_format'>";
echo "<option value='fasta'>FASTA</option>";
echo "<option value='txt'>TXT</option>";
echo "</select>";
echo "</div>";

echo "<br>";


// Option to export alignment
echo "<div class='export-option'>";
echo "<label>";
echo "<input type='checkbox' name='export_alignment'>";
echo " Alignment";

// Choose file format for alignment
echo "<select name='alignment_format'>";
echo "<option value='fasta'>FASTA</option>";
echo "<option value='txt'>TXT</option>";
echo "</select>";
echo "</div>";

echo "<br>";


// Option to export motif report
echo "<label>";
echo "<input type='checkbox' name='export_motif_report'>";
echo " Motif report";
echo "</label>";

echo "<br>";


// Option to export figures
echo "<label>";
echo "<input type='checkbox' name='export_figures'>";
echo " Figures";
echo "</label>";

echo "<br><br>";


// Submit button to download selected items
echo "<button class='login-card' type='submit'>Download</button>";

echo "</div>";

echo "</form>";

?>
