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

$stmt = $pdo->query("
    SELECT 
        id_analysis,
        name,
        protein,
        taxon,
        seq_max,
        created_at,
        exclude_partial,
        manual_only
    FROM analyses
    ORDER BY created_at DESC
");

echo "<div class='form-row'>";

echo "<label for='analysis_id'><strong>Dataset to export:</strong></label>";

echo "<select id='analysis_id' name='analysis_id' required>";

while ($row = $stmt->fetch())
{
    $id = $row['id_analysis'];

    $name = $row['name'];
    $taxon = $row['taxon'];
    $count = $row['seq_max'];

    $date = date("d M Y H:i", strtotime($row['created_at']));

    $filters = [];

    if ($row['exclude_partial'])
        $filters[] = "Exclude partial";

    if ($row['manual_only'])
        $filters[] = "Manual only";

    $filter_text = implode(", ", $filters);

    $label = "$name ($taxon) | $count sequences";

    if ($filter_text)
        $label .= " | $filter_text";

    $label .= " | $date";

    echo "<option value='$id'>$label</option>";
}

echo "</select>";

echo "</div>";



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
