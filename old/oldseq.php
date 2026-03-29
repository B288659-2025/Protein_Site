<?php
session_start();
if(isset($_POST['id_analysis']))
{
    $_SESSION['id_analysis'] = $_POST['id_analysis'];
}
echo "<h1 style='text-align:center;'>Protein Sequences</h1>";
require_once 'menu.php';
require_once 'db.php';
$id_analysis = $_SESSION['id_analysis'] ?? null;
if(!$id_analysis)
{
    echo "Please select a dataset first.";
    exit;
}

$stmt = $pdo->prepare("
SELECT fasta_data
FROM sequences
WHERE id_analysis = ?
");

$stmt->execute([$id_analysis]);

$output = $stmt->fetchColumn();

echo "<pre>";
echo $output;
echo "</pre>";

?>
