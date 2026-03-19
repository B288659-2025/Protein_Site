<?php

session_start();

require_once 'db.php';
require_once 'analysis_functions.php';



if(isset($_POST['example_dataset']))
{

    $stmt = $pdo->prepare("
        SELECT id_analysis
        FROM analyses
        WHERE protein = ?
        LIMIT 1
    ");

    $stmt->execute(['Glucose-6-Phosphatase']);
    $example_id = $stmt->fetchColumn();


    if(!$example_id)
    {
        require_once 'populate_example.php';

        $stmt = $pdo->prepare("
            SELECT id_analysis
            FROM analyses
            WHERE protein = ?
            LIMIT 1
        ");

        $stmt->execute(['Glucose-6-Phosphatase']);
        $example_id = $stmt->fetchColumn();
    }

    $_SESSION['id_analysis'] = $example_id;
}

if(isset($_POST['protein']) && isset($_POST['taxon']))
{

    $protein = $_POST['protein'];
    $taxon   = $_POST['taxon'];
    $maxseq  = $_POST['seq_max'] ?? 30;
    $stmt = $pdo->prepare("select id_analysis from analyses where protein = ? and taxon = ? and seq_max = ? limit 1");
    $stmt->execute([$protein,$taxon, $maxseq]);
    $existing_id = $stmt->fetchColumn();
    if($existing_id)
    {
      $_SESSION['id_analysis'] = $existing_id;
      header("Location: seq.php");
      exit;
    }
    $sequences = get_sequences_ncbi($protein,$taxon,$maxseq);

    $alignment = run_alignment($sequences);


    $motifs = run_motifs($sequences);

    $id_analysis = save_analysis(
        $pdo,
        $protein,
        $taxon,
        $maxseq,
        $sequences,
        $alignment,
        $motifs
    );
    $_SESSION['id_analysis'] = $id_analysis;
}

echo "<h1 style='text-align:center;'>Protein Sequences</h1>";

require_once 'menu.php';

echo "<div class='container'>";

$id = $_SESSION['id_analysis'] ?? null;

if(!$id)
{
    echo "Please select a dataset first.";
    echo "</div>"; 
    exit;
}


$stmt = $pdo->prepare("
SELECT fasta_data
FROM sequences
WHERE id_analysis = ?
");

$stmt->execute([$id]);

$sequences = $stmt->fetchColumn();
echo "<pre>";
echo $sequences;
echo "</pre>";
echo "</div>";

?>
