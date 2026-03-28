<?php
session_start();


require_once 'menu.php';
require_once 'db.php';
echo "<div class = 'container'>";
$id_analysis = $_SESSION['id_analysis'] ?? null;
if(!$id_analysis)
{
    echo "Please select a dataset first.";
    echo "</div>";
    exit;
}
$stmt = $pdo->prepare("
SELECT motif_data
FROM motifs
WHERE id_analysis = ?
");

$stmt->execute([$id_analysis]);

$motifs = $stmt->fetchColumn();

echo "<pre>";
echo $motifs;
echo "</pre>";
echo "</div>";

