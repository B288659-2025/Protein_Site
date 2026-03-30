<?php
session_start();

require_once 'menu.php';
echo "<h2 class='section-title'>Sequence Alignment</h2>";
require_once 'db.php';
echo "<div class='container'>";

$id_analysis = $_SESSION['id_analysis'] ?? null;
if(!$id_analysis)
{
    echo "<p class='info-text'>";
    echo "Please select a dataset first";
    echo "</p>";

    echo "</div>";
    exit;
}

$stmt = $pdo->prepare("
SELECT alignment_data
FROM alignments
WHERE id_analysis = ?
");

$stmt->execute([$id_analysis]);

$alignment = $stmt->fetchColumn();
if (!$alignment || trim($alignment) == "")
{
    echo "<p class='info-text'>";
    echo "Alignment requires at least 2 sequences.";
    echo "</p>";

    echo "</div>";
    exit;
}

echo "<div class='fasta-container'>";

$alignment = explode(">", $alignment);

foreach ($alignment as $align)
{
    if (trim($align) == "") continue;

    $lines = explode("\n", trim($align));
    $header = array_shift($lines);
    $sequence = implode("", $lines);

    echo "<div class='sequence-card'>";
    echo "<div class='sequence-header'> >$header</div>";
    echo "<div class='sequence-body'>" . $sequence . "</div>";
    echo "</div>";
}

echo "</div>";

?>
