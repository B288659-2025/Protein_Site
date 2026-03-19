<?php

require_once 'db.php';

/* read the files */

$fasta = file_get_contents("example_sequences.fasta");
$alignment = file_get_contents("example_alignment.fasta");
$motifs = file_get_contents("example_motifs.txt");

/* insert analysis */

$stmt = $pdo->prepare("
INSERT INTO analyses (name, protein, taxon, seq_max)
VALUES (?, ?, ?, ?)
");

$stmt->execute([
    "Example Dataset",
    "glucose-6-phosphatase",
    "Aves",
    30
]);

$id_analysis = $pdo->lastInsertId();

/* insert sequences */

$stmt = $pdo->prepare("
INSERT INTO sequences (id_analysis, fasta_data)
VALUES (?, ?)
");

$stmt->execute([$id_analysis, $fasta]);

/* insert alignment */

$stmt = $pdo->prepare("
INSERT INTO alignments (id_analysis, alignment_data)
VALUES (?, ?)
");

$stmt->execute([$id_analysis, $alignment]);

/* insert motifs */

$stmt = $pdo->prepare("
INSERT INTO motifs (id_analysis, motif_data)
VALUES (?, ?)
");

$stmt->execute([$id_analysis, $motifs]);


?>
