<?php
session_start();
require 'menu.php';
require 'db.php';
echo "<h2 class='section-title'>Export Results</h2>";
if (isset($_GET['error']))
{
    echo "<p class='info-text'>Please select something to export</p>";
}
$id = $_SESSION['id_analysis'] ?? null;

if (!$id)
{
    echo "<p class='info-text'>Please select a dataset first</p>";
    exit;
}
echo "<form method='POST' action='download.php'>";

echo "<div class='card'>";

echo "<h4>Choose data to export</h4>";

echo "<div class='export-option'>";
echo "<label>";
echo "<input type='checkbox' name='export_sequences'>";
echo " Sequences";
echo "<select name='sequences_format'>";
echo "<option value='fasta'>FASTA</option>";
echo "<option value='txt'>TXT</option>";
echo "</select>";
echo "</div>";

echo "<br>";

echo "<div class='export-option'>";
echo "<label>";
echo "<input type='checkbox' name='export_alignment'>";
echo " Alignment";
echo "<select name='alignment_format'>";
echo "<option value='fasta'>FASTA</option>";
echo "<option value='txt'>TXT</option>";
echo "</select>";
echo "</div>";

echo "<br>";

echo "<label>";
echo "<input type='checkbox' name='export_motif_report'>";
echo " Motif report";
echo "</label>";

echo "<br>";

echo "<label>";
echo "<input type='checkbox' name='export_figures'>";
echo " Figures";
echo "</label>";

echo "<br><br>";

echo "<button class='login-card' type='submit'>Download</button>";

echo "</div>";

echo "</form>";
?>
