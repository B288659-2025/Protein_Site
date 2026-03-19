<?php

echo "<html>";
echo "<body>";

echo "<h1 style='text-align:center;'>Protein Sequence Analysis </h1>";
require_once 'menu.php';

echo "<h2>Use Example Dataset</h2>";

echo "<form action='seq.php' method='post'>";
echo "<input type='hidden' name='id_analysis' value='1'>";
echo "<button type='submit'>Glucose-6-Phosphatase (Aves)</button>";
echo "</form>";

echo "<h2>Analyze Your Own Dataset</h2>";

echo "<form action='getseq.php' method='post'>";

echo "Protein family:<br>";
echo "<input type='text' name='protein' required><br><br>";

echo "Taxonomic group:<br>";
echo "<input type='text' name='taxon' required><br><br>";

echo "Maximum sequences to display:<br>";
echo "<input type='number' name='seq_max' value='30'><br><br>";

echo "<input type='submit' value='Run Analysis'>";

echo "</form>";

echo "</body>";
echo "</html>";

?>
