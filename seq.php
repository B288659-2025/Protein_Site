<?php

// Beging session to save the id
session_start();

// If an analysis id is sent through POST, store it in session
if (isset($_POST['id_analysis'])) {
	$_SESSION['id_analysis'] = $_POST['id_analysis'];
	$_SESSION['generated_analyses'] = [];
}

// Load database and required functions
require_once 'db.php';
require_once 'analysis_functions.php';


// If example dataset button was used
if (isset($_POST['example_dataset']))
{
	//Look for existing example dataset
	$stmt = $pdo->prepare("select id_analysis from analyses where name = 'Example Dataset' order by id_analysis desc limit 1");
	$stmt->execute();
	$example_id = $stmt->fetchColumn();

	// If example dataset not found, create it
	if (!$example_id)
	{
	        require_once 'populate_example.php';

	// Get the id of the newly inserted dataset
	$example_id = $pdo->lastInsertId();
	}

	// Store example dataset id
	$_SESSION['id_analysis'] = $example_id;
	$_SESSION['generated_analyses'] = [];
}

// If user submitted a search
if (isset($_POST['protein']) && isset($_POST['taxon']))
{
	// Get form values
	$protein = $_POST['protein'];
	$taxon   = $_POST['taxon'];
	$maxseq  = $_POST['seq_max'] ?? 30;
	$id_user = $_SESSION['id_user'] ?? null;

	// Get filter values
	$exclude_partial = isset($_POST['exclude_partial']) ? 1 : 0;
	$manual_only     = isset($_POST['manual_only']) ? 1 : 0;
	$exclude_frag    = isset($_POST['exclude_frag']) ? 1 : 0;

	// Check if this search already exists
	$session_id = session_id(); // Get session id for guest users
	$stmt = $pdo->prepare("Select id_analysis from analyses where protein = ? and taxon = ? and seq_max = ? and ((id_user = ?) or (id_user is null and session_id = ?)) and exclude_partial = ? and manual_only = ? and exclude_frag = ? order by created_at desc limit 1");
	$stmt->execute([$protein, $taxon, $maxseq, $id_user, $session_id, $exclude_partial, $manual_only, $exclude_frag]);
	$existing_id = $stmt->fetchColumn();

	// If search exists, redirect to sequences page
	if ($existing_id)
	{
		$_SESSION['id_analysis'] = $existing_id;
		$_SESSION['generated_analyses'] = [];
		header("Location: seq.php");
		exit;
	}
	// Include navigation menu
	require_once "menu.php";

	// Get sequences from NCBI
	$sequences = get_sequences_ncbi($protein, $taxon, $maxseq, $exclude_partial, $manual_only, $exclude_frag);

	// Count number of sequences
	$maxseq = substr_count($sequences, ">");


	// If sequences were found
	if ($maxseq > 0)
	{
		// Create analysis first to generate id
		$id_analysis = save_analysis($pdo, $protein, $taxon, $maxseq, $sequences, $exclude_partial, $manual_only, $exclude_frag);
		// Run alignment only if 2 or more sequences
		if ($maxseq >= 2)
		{
			$alignment = run_alignment($sequences, $id_analysis);
		}
		else
		{
			$alignment = "";
		}

		// Run motif scan
		$motifs = run_motifs($sequences, $id_analysis);

		// Save analysis results to database
		$stmt = $pdo->prepare("Insert into alignments (id_analysis, alignment_data) values (?, ?)");
		$stmt->execute([$id_analysis, $alignment]);

		$stmt = $pdo->prepare("Insert into motifs (id_analysis, motif_data) values (?, ?)");
		$stmt->execute([$id_analysis, $motifs]);

		// Store analysis id
		$_SESSION['id_analysis'] = $id_analysis;
		$_SESSION['generated_analyses'] = [];
	}

	else
	{
		// No sequences found message
		echo "<p class='info-text'>";
		echo "No sequences were found for this query. Please check the spelling or try a different query :(";
		echo "</p>";

		exit;
	}
}


// Load menu and page title again since if the previous case was true, we would've exited
require_once "menu.php";
echo "<h2 class='section-title'>Sequences</h2>";
echo "<div class='container'>";

// Get current analysis id
$id = $_SESSION['id_analysis'] ?? null;

// If no dataset selected
if (!$id)
{
	echo "<p class='info-text'>";
	echo "Please select a dataset first";
	echo "</p>";
}
else
{
	// Get fasta data from database
	$stmt = $pdo->prepare("Select fasta_data from sequences where id_analysis = ?");
	$stmt->execute([$id]);

	$sequences = $stmt->fetchColumn();

	// If no sequences found inform the user
	if (empty($sequences))
	{
		echo "<p style='text-align:center;'>No sequences found.</p>";
	}
	else
	{
		echo "<div class='fasta-container'>";

		// Split fasta entries
		// Explode source: https://www.php.net/manual/en/function.explode.php
		$entries = explode(">", $sequences);

		foreach ($entries as $seq)
		{
			// Skip empty entries
			if (trim($seq) == "") continue;

			// Split header and sequence
			$lines = explode("\n", trim($seq));
			// array_shift source: https://www.php.net/manual/en/function.array-shift.php
			$header = array_shift($lines);
			// implode source: https://www.php.net/manual/en/function.implode.php
			$sequence = implode("", $lines);

			// Display sequence card
			echo "<div class='sequence-card'>";
			echo "<div class='sequence-header'> >$header</div>";
			echo "<div class='sequence-body'>$sequence</div>";
			echo "</div>";
		}

		echo "</div>";
	}
}

?>
