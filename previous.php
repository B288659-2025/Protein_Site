<?php

// Start session to access user or guest history
session_start();

// Load database connection
require_once 'db.php';

// Load navigation menu
require_once 'menu.php';

// Show page title
echo "<h2 class='section-title'>Previous Searches</h2>";


// Check if user is not logged and prepare guest message
if (!isset($_SESSION['id_user']))
{
	// If guest has current analysis
	if (isset($_SESSION['id_analysis']))
	{
		// Inform guest about temporary session storage
		echo "<p class='info-text'>";
		echo "You are currently using the system as a guest. Your analyses are stored only for this session. ";
		echo "<br>";
		echo "After 24 hours, all guest searches will be reset.";
		echo "</p>";
	}
	else
	{
		// No history available for guest
		echo "<p class='info-text'>";
		echo "No history available.";
		echo "<br>";
		echo "Please log in to retrieve saved history or perform a new analysis.";
		echo "</p>";

		exit;
	}
}


// Get user id from session
$id_user = $_SESSION['id_user'] ?? null;


// Decide whether to fetch history by user id or session id (for guest)
if ($id_user != null)
{
	// Get saved analyses for logged in user
	$stmt = $pdo->prepare("select id_analysis, protein, taxon, seq_max, created_at, exclude_partial, manual_only, exclude_frag from analyses where id_user = ? order by id_analysis desc");
	$stmt->execute([$id_user]);
}
else
{
	// Get analyses for guest session
	$stmt = $pdo->prepare("select id_analysis, protein, taxon, seq_max, created_at, exclude_partial, manual_only, exclude_frag from analyses where session_id = ? order by id_analysis desc");
	$stmt->execute([session_id()]);
}


// Get results as associative array using column names
// https://www.php.net/manual/en/pdostatement.fetch.php
$analyses = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Check if history list is empty
if (empty($analyses))
{
	echo "<p class='info-text'>No previous analyses found.</p>";
}
else
{
	// Use card and dataset-grid for visualisation
	echo "<div class='card'>";
	echo "<div class='dataset-grid'>";


	// Loop through each record
	foreach ($analyses as $a)
	{
		// Get values safely
		$id = $a['id_analysis'];
		$protein = $a['protein'];
		$taxon = $a['taxon'];
		$seq_max = $a['seq_max'];

		// Store selected filter options
		$filters = [];

		// Check filter flags
		if ($a['exclude_partial'])
		{
			$filters[] = "Exclude partial";
		}

		if ($a['manual_only'])
		{
			$filters[] = "Manual only";
		}

		if ($a['exclude_frag'])
		{
			$filters[] = "Exclude fragments";
		}


		// Combine filters into text
		if (empty($filters))
		{
			$filter_text = "No filters";
		}
		else
		{
			// Implode joins filter names with commas (jusy  like used in other files)
			// Implode source: https://www.php.net/manual/en/function.implode.php
			$filter_text = implode(", ", $filters);
		}


		// Format date and time for display
		// strtotime source: https://www.php.net/manual/en/function.strtotime.php
		$time = date("d M Y H:i", strtotime($a['created_at']));


		// Make the cars function like buttons
		echo "
		<form method='POST' action='seq.php'>

			<input type='hidden'
			       name='id_analysis'
			       value='$id'>

			<button type='submit'
			        class='history-card'>

				<div class='history-title'>
					$protein ($taxon)
				</div>

				<div class='history-meta'>
					$seq_max sequences
				</div>

				<div class='history-meta'>
					$filter_text
				</div>

				<div class='history-time'>
					$time
				</div>

			</button>

		</form>
		";
	}

	echo "</div>";
	echo "</div>";
}

?>
