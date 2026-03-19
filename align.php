<?php
session_start();
echo "<h1 style='text-align:center;'>Aligned Protein Sequences</h1>";

require_once 'menu.php';
require_once 'db.php';
echo "<div class='container'>";

$id_analysis = $_SESSION['id_analysis'] ?? null;
if(!$id_analysis)
{
    echo "Please select a dataset first.";
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

echo "<pre>";
echo $alignment;
echo "</pre>";
echo "</div>";
