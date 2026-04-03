<?php
// Start session so we can access the current dataset id
session_start();

// Load navigation menu and database connection
require_once 'menu.php';
require_once 'db.php';

// Set section page
echo "<h2 class='section-title'>Motif Scan</h2>";

// Use container class for visualisation
echo "<div class='container'>";

// Get selected dataset id from session
$id_analysis = $_SESSION['id_analysis'] ?? null;

// Stop if no dataset selected
if (!$id_analysis)
{
	echo "<p class='info-text'>";
	echo "Please select a dataset first";
	echo "</p>";
	echo "</div>";
	exit;
}

// Get motif data for the selected analysis
$stmt = $pdo->prepare("Select motif_data from motifs where id_analysis = ?");
$stmt->execute([$id_analysis]);
$motifs = $stmt->fetchColumn();


// Function to parse and display motif results
function display_motifs($text)
{
	// Stop if no data found
	if (!$text)
	{
		echo "<p class='info-text'>";
		echo "No motif results found :(";
		echo "</p>";
		echo "</div>";
		exit;
	}

	// Split text into lines
	$lines = explode("\n", $text);

	// Initialize variables
	$sequence = "";
	$motif = "";
	$start = "";
	$end = "";
	$length = "";

	$found = false;

	// Loop through each line of the file
	// // preg_match performs a regular expression match, so it can be used as a parser using regex patterns from BPSM.. Source: https://www.php.net/manual/en/function.preg-match.php
	foreach ($lines as $line)
	{
		// Extract sequence name
		if (preg_match("/Sequence:\s+(\S+)/", $line, $m))
		{
			$sequence = $m[1];
		}

		// Extract motif name
	// Extract motif name AND print row when record is complete
	if (preg_match("/Motif\s*=\s*(\S+)/", $line, $m))
	{
		$motif = $m[1];

		// Now we have a complete record
		if ($sequence != "" && $start != "" && $end != "" && $length != "")
		{
			// Create table header once
			if (!$found)
			{
				echo "<div class='card'>";
				echo "<table class='motif-table'>";
				echo "<tr>
						<th>Sequence</th>
						<th>Motif</th>
						<th>Start</th>
						<th>End</th>
						<th>Length</th>
					  </tr>";

				$found = true;
			}

			// Print motif row
			echo "<tr>
					<td>$sequence</td>
					<td>$motif</td>
					<td>$start</td>
					<td>$end</td>
					<td>$length</td>
				  </tr>";

			// Reset values for next motif
			$motif = "";
			$start = "";
			$end = "";
			$length = "";
		}
	}
		// Extract motif length
		if (preg_match("/Length\s*=\s*(\d+)/", $line, $m))
		{
			$length = $m[1];
		}

		// Extract start position
		if (preg_match("/Start\s*=\s*position\s*(\d+)/", $line, $m))
		{
			$start = $m[1];
		}

		// Extract end position
		if (preg_match("/End\s*=\s*position\s*(\d+)/", $line, $m))
		{
			$end = $m[1];

		}
	}

	// Close table if data found
	if ($found)
	{
		echo "</table>";
		echo "</div>";
	}
	// Sometimes motifs arent found so inform the user
	else
	{
		echo "<p class='info-text'>";
		echo "No motif results found :(";
		echo "</p>";
		echo "</div>";
	}
}

// Run the parser
display_motifs($motifs);

echo "</div>";
?>
