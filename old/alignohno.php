<?php
session_start();

require_once 'menu.php';
require_once 'db.php';

echo "<h2 class='section-title'>Sequence Alignment</h2>";
echo "<div class='container'>";

$id_analysis = $_SESSION['id_analysis'] ?? null;

if (!$id_analysis)
{
    echo "<p style='text-align:center;'>Please select a dataset first.</p>";
    echo "</div>";
    require 'footer.php';
    exit;
}

$stmt = $pdo->prepare("
SELECT alignment_data
FROM alignments
WHERE id_analysis = ?
");

$stmt->execute([$id_analysis]);

$alignment = $stmt->fetchColumn();

if (!$alignment)
{
    echo "<div class='card'>";
    echo "<p>No alignment results found.</p>";
    echo "</div>";
}
else
{
    echo "<div class='fasta-container'>";

    $entries = explode(">", $alignment);

    foreach ($entries as $entry)
    {
        if (trim($entry) == "") continue;

        $lines = explode("\n", trim($entry));

        $header = array_shift($lines);

        $sequence = implode("", $lines);

        echo "<div class='sequence-card'>";
        echo "<div class='sequence-header'>$header</div>";
        echo "<div class='sequence-body'>$sequence</div>";
        echo "</div>";
    }

    echo "</div>";
}

echo "</div>";

require 'footer.php';
?>
