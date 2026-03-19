<?php

session_start();

require_once 'db.php';
require_once 'analysis_functions.php';

$type = $_GET['type'] ?? 'length';
$id = $_SESSION['id_analysis'] ?? null;

if(!$id)
{
    http_response_code(404);
    exit("No analysis selected");
}

# fetch sequences
$stmt = $pdo->prepare("
SELECT fasta_data
FROM sequences
WHERE id_analysis = ?
");

$stmt->execute([$id]);
$sequences = $stmt->fetchColumn();

if(!$sequences)
{
    exit("No sequences found");
}

# decide which plot to generate
if($type == "length")
{
    $file = "/tmp/length_plot_" . $id . ".png";

    if(!file_exists($file))
    {
        generate_length_plot($sequences, $id);
    }
}

elseif($type == "conservation")
{
    $file = "/tmp/conservation_plot_" . $id . ".png";

    if(!file_exists($file))
    {
        generate_conservation_plot($sequences, $id);
    }
}

elseif($type == "aa")
{
    $file = "/tmp/aa_comp_" . $id . ".png";

    if(!file_exists($file))
    {
        generate_aa_composition_plot($sequences, $id);
    }
}

elseif($type == "stats")
{
    header("Content-Type: text/html");
    echo get_statistics($sequences);
    exit;
}

header("Content-Type: image/png");
readfile($file);
