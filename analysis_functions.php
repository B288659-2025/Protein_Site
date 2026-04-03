<?php

// Get protein sequences from NCBI using search filters
function get_sequences_ncbi($protein, $taxon, $maxseq, $exclude_partial, $manual_only, $exclude_frag)
{
	// Build search query
	$query = $protein . " AND (" . $taxon . ")";

	// Remove partial sequences if selected
	if ($exclude_partial) {
		$query .= " NOT partial";
	}

	// Remove fragment sequences if selected
	if ($exclude_frag) {
		$query .= " NOT fragment";
	}

	// Only include reviewed sequences if selected
	if ($manual_only) {
		$query .= " AND reviewed[filter]";
	}

	// Encode query for URL
	$term = urlencode($query);

	// Step 1: search for sequence IDs
	// Source: https://www.ncbi.nlm.nih.gov/books/NBK25499/#chapter4.Introduction
	$search_url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=protein&term={$term}&retmax={$maxseq}&retmode=json&api_key=d41e452731cb27ccab32c0651c40b7dc5a08";
	$search_json = file_get_contents($search_url);
	// JSON is requested from the NCBI API using retmode=json and parsed using json_decode
	$data = json_decode($search_json, true);

	// Stop if no IDs found
	if (!$data || !isset($data['esearchresult']['idlist'])) {
    		return "";
	}

	// Collect IDs into array
	$ids = $data['esearchresult']['idlist'];

	// Stop if ID list is empty
	if (empty($ids)) {
		return "";
	}

	// Convert IDs into comma separated string
	$id_string = implode(",", $ids);

	// Step 2: fetch FASTA sequences
	$fetch_url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=protein&id={$id_string}&rettype=fasta&retmode=text&api_key=d41e452731cb27ccab32c0651c40b7dc5a08";

	$fasta = file_get_contents($fetch_url);

	// Return FASTA data
	return $fasta ? $fasta : "";
}


// Run multiple sequence alignment using Clustal Omega
function run_alignment($fasta, $id)
{
	// Define file paths
	$input_file = "/tmp/sequences_" . $id . ".fasta";
	$output_file = "/tmp/alignment_" . $id . ".fasta";

	// Save sequences to temporary file
	file_put_contents($input_file, $fasta);

	// Log input file check
	error_log("Input file: " . $input_file);
	error_log("Input exists: " . (file_exists($input_file) ? "yes" : "no"));
	error_log("Input size: " . filesize($input_file));

	// Run alignment command
	$cmd = "clustalo -i $input_file -o $output_file --force 2>&1";

	$output = shell_exec($cmd);

	// Log command and result
	error_log("Command run: " . $cmd);
	error_log("Command output: " . $output);

	// Check output file
	error_log("Output file: " . $output_file);
	error_log("Output exists: " . (file_exists($output_file) ? "yes" : "no"));

	if (file_exists($output_file))
	{
		error_log("Output size: " . filesize($output_file));

		$alignment = file_get_contents($output_file);

		if (trim($alignment) == "")
		{
			error_log("Alignment file is empty");
		}
		else
		{
			error_log("Alignment generated successfully");
		}

		return $alignment;
	}

	error_log("Alignment file was not created");

	return "";
}
// Run motif scan using EMBOSS patmatmotifs
function run_motifs($fasta, $id)
{
	// Save sequences to temporary file
	file_put_contents("/tmp/sequences_" . $id . ".fasta", $fasta);

	// Run motif search command
	$cmd = "patmatmotifs -sequence /tmp/sequences_" . $id . ".fasta -outfile /tmp/motifs_" . $id . ".txt -auto";
	shell_exec($cmd);

	// Return motif results if file exists
	if (file_exists("/tmp/motifs_" . $id . ".txt"))
	{
		return file_get_contents("/tmp/motifs_" . $id . ".txt");
	}

	return "";
}

// Generate sequence length distribution plot
function generate_length_plot($fasta, $id)
{
	$fasta_file = "/tmp/sequences_" . $id . ".fasta";
	$plot_file  = "/tmp/length_plot_" . $id . ".png";

	// Save FASTA file
	file_put_contents($fasta_file, $fasta);

	// Run Python plotting script
	$cmd = "/usr/bin/python3 /localdisk/home/s2794196/public_html/protein_site/plot_lengths.py $fasta_file $plot_file";
	shell_exec($cmd);

	return $plot_file;
}


// Generate conservation plot from alignment
function generate_conservation_plot($alignment, $id)
{
	$aln_file = "/tmp/alignment_" . $id . ".fasta";
	$plot_file = "/tmp/conservation_plot_" . $id . ".png";

	file_put_contents($aln_file, $alignment);

	$cmd = "python3 /localdisk/home/s2794196/public_html/protein_site/plot_conservation.py $aln_file $plot_file";
	shell_exec($cmd);

	return $plot_file;
}


// Generate amino acid composition plot
function generate_aa_composition_plot($fasta, $id)
{
	$fasta_file = "/tmp/sequences_" . $id . ".fasta";
	$plot_file = "/tmp/aa_comp_" . $id . ".png";

	file_put_contents($fasta_file, $fasta);

	$cmd = "python3 /localdisk/home/s2794196/public_html/protein_site/plot_aa_comp.py $fasta_file $plot_file";
	shell_exec($cmd);

	return $plot_file;
}


// Generate heatmap plot from alignment
function generate_heatmap_plot($alignment, $id)
{
	$aln_file = "/tmp/alignment_" . $id . ".fasta";
	$plot_file = "/tmp/heatmap_" . $id . ".png";

	file_put_contents($aln_file, $alignment);

	$cmd = "python3 /localdisk/home/s2794196/public_html/protein_site/plot_heatmap.py $aln_file $plot_file";
	shell_exec($cmd);

	return $plot_file;
}


// Generate conserved regions plot
function generate_conserved_regions_plot($alignment, $id)
{
	$aln_file = "/tmp/alignment_" . $id . ".fasta";
	$plot_file = "/tmp/conserved_regions_" . $id . ".png";

	file_put_contents($aln_file, $alignment);

	$cmd = "python3 /localdisk/home/s2794196/public_html/protein_site/plot_conserved_regions.py $aln_file $plot_file";
	shell_exec($cmd);

	return $plot_file;
}


// Generate statistics using Python and Biopython
function get_statistics($fasta)
{
	$fasta_file = "/tmp/stats.fasta";

	file_put_contents($fasta_file, $fasta);

	// Run statistics script
	$cmd = "python3 /localdisk/home/s2794196/public_html/protein_site/stats_biopython.py " . $fasta_file;

	return shell_exec($cmd);
}


// Save analysis results into database
function save_analysis($pdo, $protein, $taxon, $maxseq, $sequences, $exclude_partial, $manual_only, $exclude_frag)
{
	// Get logged in user and session id
	$id_user = $_SESSION["id_user"] ?? null;
	$session_id = session_id();

	// Insert analysis record
	$stmt = $pdo->prepare("Insert into analyses (name, protein, taxon, seq_max, id_user, session_id, exclude_partial, manual_only, exclude_frag) values (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->execute(["User Dataset", $protein, $taxon, $maxseq, $id_user, $session_id, $exclude_partial, $manual_only, $exclude_frag]);

	// Get new analysis id
	$id_analysis = $pdo->lastInsertId();

	// Save sequences
	$stmt = $pdo->prepare("Insert into sequences (id_analysis, fasta_data) values (?, ?)");
	$stmt->execute([$id_analysis, $sequences]);

	return $id_analysis;
}


// Check if a search already exists
function search_exists($pdo, $protein, $taxon, $seq_max, $exclude_partial, $manual_only, $exclude_frag)
{
	// Look for matching analysis
	$stmt = $pdo->prepare("Select 1 from analyses where protein = ? and taxon = ? and seq_max = ? and exclude_partial = ? and manual_only = ? and exclude_frag = ? limit 1");

	$stmt->execute([$protein, $taxon, $seq_max, $exclude_partial, $manual_only, $exclude_frag]);

	return $stmt->fetchColumn();
}

?>
