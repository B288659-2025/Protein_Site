<?php

// Start session to store selected analyses
session_start();
// Load database and analysis functions
require_once 'db.php';
require_once 'analysis_functions.php';
// Load navigation menu
require_once 'menu.php';

// Show page title
echo "<h2 class='section-title'>Additional Analysis</h2>";


// If user clicked "Display All"
// Store all analysis types in session
if (isset($_POST['display_all']))
{
	$_SESSION['generated_analyses'] = [
		'stats',
		'length_plot',
		'residue_conserve',
		'aa_comp',
		'heatmap',
		'cons'
	];
}

// If user selected specific analyses
elseif (isset($_POST['generate_selected']) && isset($_POST['analysis']))
{
	// Save selected analyses from form
	$_SESSION['generated_analyses'] = $_POST['analysis'];
}


// Make sure the session variable exists
if (!isset($_SESSION['generated_analyses']))
{
	$_SESSION['generated_analyses'] = [];
}



// Use the containr class
echo "<div class = 'container'>";


// Check if dataset is selected
if(!isset($_SESSION['id_analysis']))
{
	echo "<p class='info-text'>";
	echo "Please select a dataset first";
	echo "</p>";
	echo "</div>";
	exit;
}


// Get current analysis id
$id = $_SESSION['id_analysis'];


// Get sequences from database
$stmt = $pdo->prepare("select fasta_data from sequences where id_analysis = ?");

$stmt->execute([$id]);

$sequences = $stmt->fetchColumn();


// Safety check to ensure session variable exists
if(!isset($_SESSION['generated_analyses']))
{
	$_SESSION['generated_analyses'] = [];
}


// Handle single checkbox click
// Add analysis to session list if not already there
if(isset($_POST['analysis']))
{
	$clicked = $_POST['analysis'];

	if(!in_array($clicked, $_SESSION['generated_analyses']))
	{
		$_SESSION['generated_analyses'][] = $clicked;
	}
}

?>


<!-- Add the containr, analysis-card, and dataset-grid classes for visualisation -->
<div class="container">

<form method="POST">

<div class="analysis-card">

<div class="dataset-grid">

<!-- Analysis selection checkboxes -->

<label>
<input type="checkbox" name="analysis[]" value="stats">
Generate Dataset Statistics
</label>

<label>
<input type="checkbox" name="analysis[]" value="length_plot">
Generate Sequence Length Distribution
</label>

<label>
<input type="checkbox" name="analysis[]" value="residue_conserve">
Generate Residue Conservation Plot
</label>

<label>
<input type="checkbox" name="analysis[]" value="aa_comp">
Generate Amino Acid Composition Plot
</label>

<label>
<input type="checkbox" name="analysis[]" value="heatmap">
Generate Sequence Similarity Heatmap
</label>

<label>
<input type="checkbox" name="analysis[]" value="cons">
Generate Conservation Regions Plot
</label>

</div>


<!-- Buttons to generate analyses -->

<div class="button-row">

	<button class="center-button" type="submit" name="generate_selected">
		Generate Selected Analyses
	</button>

	<button class="center-button" type="submit" name="display_all">
		Display All Analyses
	</button>

</div>

</div>

<br>

</form>

</div>

<br><br>


<div class="dataset-grid">


<?php


// Loop through generated analyses
// Display plots or statistics

foreach($_SESSION['generated_analyses'] as $analysis)
{

	// Length distribution plot
	if($analysis == "length_plot")
	{
		echo "<div class='card'>";
		echo "<img src='plot.php?type=length&id=$id'>";
		echo "</div>";
	}

	// Residue conservation plot
	if($analysis == "residue_conserve")
	{
		echo "<div class='card'>";
		echo "<img src='plot.php?type=conservation&id=$id'>";
		echo "</div>";
	}

	// Amino acid composition plot
	if($analysis == "aa_comp")
	{
		echo "<div class='card'>";
		echo "<img src='plot.php?type=aa&id=$id'>";
		echo "</div>";
	}

	// Dataset statistics display
	if($analysis == "stats")
	{
		echo "<div class='card'>";
		echo "<h4 style='text-align: center; margin-bottom: 20px;'>Dataset Statistics</h4>";
		echo get_statistics($sequences);
		echo "</div>";
	}

	// Heatmap plot
	if($analysis == "heatmap")
	{
		echo "<div class='card'>";
		echo "<img src='plot.php?type=heatmap&id=$id'>";
		echo "</div>";
	}

	// Conserved regions plot
	if($analysis == "cons")
	{
		echo "<div class='card'>";
		echo "<img src='plot.php?type=conserved_regions&id=$id'>";
		echo "</div>";
	}

}

?>


</div>
</div>
