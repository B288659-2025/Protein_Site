<?php

require_once 'db.php';

// Read the contents from the example files which are saved to reduce the need for search and retrieval
$fasta = file_get_contents("example_sequences.fasta");
$alignment = file_get_contents("example_alignment.fasta");
$motifs = file_get_contents("example_motifs.txt");


// Prepare the PDO query to insert data into analyses table
$stmt = $pdo->prepare("Insert into analyses (name, protein, taxon, seq_max) values (?, ?, ?, ?)");

// Pass the values and execute the query 
$stmt->execute(["Example Dataset", "glucose-6-phosphatase", "Aves", 30]);
// Get the ID of the most recent insert to use in other tables due to foreign key constraints
$id_analysis = $pdo->lastInsertId();

// Prepare the PDO query to insert data into sequences table
$stmt = $pdo->prepare("Insert into sequences (id_analysis, fasta_data) values (?, ?)");

// Pass the values and execute the query
$stmt->execute([$id_analysis, $fasta]);

// Prepare the PDO query to insert data into alignments table
$stmt = $pdo->prepare("Insert into alignments (id_analysis, alignment_data) values (?, ?)");

// Pass the values and execute the query
$stmt->execute([$id_analysis, $alignment]);

// Prepare the PDO query to insert data into motifs table
$stmt = $pdo->prepare("Insert into motifs (id_analysis, motif_data) values (?, ?)");

// Pass the values and execute the query
$stmt->execute([$id_analysis, $motifs]);


?>
