<?php

session_start();
if (isset($_POST['id_analysis'])) {
    $_SESSION['id_analysis'] = $_POST['id_analysis'];
    $_SESSION['generated_analyses'] = [];
}
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
    $_SESSION['generated_analyses'] = [];
}

if(isset($_POST['protein']) && isset($_POST['taxon']))
{

    $protein = $_POST['protein'];
    $taxon   = $_POST['taxon'];
    $maxseq  = $_POST['seq_max'] ?? 30;
    $id_user = $_SESSION['id_user'] ?? null;
    $exclude_partial = isset($_POST['exclude_partial']) ? 1 : 0;
    $manual_only     = isset($_POST['manual_only']) ? 1: 0;
    $exclude_frag    = isset($_POST['exclude_frag']) ? 1 : 0;
    $stmt = $pdo->prepare("select id_analysis from analyses where protein = ? and taxon = ? and seq_max = ? and id_user = ? and exclude_partial = ? and manual_only = ? and exclude_frag = ? limit 1");
    $stmt->execute([$protein,$taxon, $maxseq, $id_user, $exclude_partial, $manual_only, $exclude_frag]);
    $existing_id = $stmt->fetchColumn();
    if($existing_id)
    {
       $_SESSION['id_analysis'] = $existing_id;
       $_SESSION['generated_analyses'] = [];
       header("Location: seq.php");
       exit;
    }
    $sequences = get_sequences_ncbi($protein,$taxon,$maxseq,$id_user, $exclude_partial, $manual_only, $exclude_frag);

unset($_SESSION['id_analysis']);
$maxseq = substr_count($sequences, ">");
require_once "menu.php";

if ($maxseq > 0)
{
    if ($maxseq >= 2)
    {
        $alignment = run_alignment($sequences);
    }
    else
    {
        $alignment = "";
    }

$motifs = run_motifs($sequences);

if (search_exists(
        $pdo,
        $protein,
        $taxon,
        $maxseq,
        $exclude_partial,
        $manual_only,
        $exclude_frag
))
{
    require_once "menu.php";

    echo "<div class='container'>";
    echo "<p class='info-text'>";
    echo "This search already exists.";
    echo "<br>";
    echo "Visit Previous Searches to view results or run a new search.";
    echo "</p>";
    echo "</div>";

    exit;
}

    $id_analysis = save_analysis(
        $pdo,
        $protein,
        $taxon,
        $maxseq,
        $sequences,
        $alignment,
        $motifs,
        $exclude_partial,
        $manual_only,
        $exclude_frag
    );

    $_SESSION['id_analysis'] = $id_analysis;
}
else
{
    echo "<p class='info-text'>";
    echo "No sequences found! Try again :(";
    echo "</p>";

     exit;
}

}
require_once "menu.php";
echo "<h2 class='section-title'>Sequences</h2>";
echo "<div class='container'>";

$id = $_SESSION['id_analysis'] ?? null;
if(!$id)
{
    echo "<p class='info-text'>";
    echo "Please select a dataset first";
    echo "</p>";
}
else
{
    $stmt = $pdo->prepare("
        SELECT fasta_data
        FROM sequences
        WHERE id_analysis = ?
    ");

    $stmt->execute([$id]);

    $sequences = $stmt->fetchColumn();

    if(empty($sequences))
    {
        echo "<p style='text-align:center;'>No sequences found.</p>";
}
    else
    {
        echo "<div class='fasta-container'>";

        $entries = explode(">", $sequences);

        foreach ($entries as $seq)
        {
            if (trim($seq) == "") continue;

            $lines = explode("\n", trim($seq));
            $header = array_shift($lines);
            $sequence = implode("", $lines);

            echo "<div class='sequence-card'>";
            echo "<div class='sequence-header'> >$header</div>";
            echo "<div class='sequence-body'>$sequence</div>";
            echo "</div>";
        }

        echo "</div>";
    }
}
?>
