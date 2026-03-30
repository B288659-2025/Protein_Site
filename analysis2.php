<?php

session_start();

require_once 'db.php';
require_once 'analysis_functions.php';

require_once 'menu.php';
echo "<h2 class='section-title'>Additional Analysis</h2>";

echo "<div class = 'container'>";
if(!isset($_SESSION['id_analysis']))
{

    echo "<p class='info-text'>";
    echo "Please select a dataset first";
    echo "</p>";
    echo "</div>";
    exit;
}

$id = $_SESSION['id_analysis'];



$stmt = $pdo->prepare("
SELECT fasta_data
FROM sequences
WHERE id_analysis = ?
");

$stmt->execute([$id]);
$sequences = $stmt->fetchColumn();



if(!isset($_SESSION['generated_analyses']))
{
    $_SESSION['generated_analyses'] = [];
}


if(!isset($_POST['analysis']))
{
    $_SESSION['generated_analyses'] = [];
}

if(isset($_POST['analysis']))
{
    $clicked = $_POST['analysis'];

    if(!in_array($clicked, $_SESSION['generated_analyses']))
    {
        $_SESSION['generated_analyses'][] = $clicked;
    }
}

?>
<div class = 'container'>
<div class='dataset-grid'>

<form method="POST">
<button class = "history-card"  name="analysis" value="stats">
Generate Dataset Statistics
</button>
</form>

<form method="POST">
<button class="history-card" name="analysis" value="length_plot">
Generate Sequence Length Distribution
</button>
</form>

<form method="POST">
<button class="history-card" name="analysis" value="residue_conserve">
Generate Residue Conservation Plot
</button>
</form>

<form method="POST">
<button class="history-card" name="analysis" value="aa_comp">
Generate Amino Acid Composition Plot
</button>
</form>

<form method="POST">
<button class="history-card" name="analysis" value="heatmap">
Generate Sequence Similarity Heatmap
</button>
</form>


<form method="POST">
<button class="history-card" name="analysis" value="cons">
Generate Conservation Regions Plot
</button>
</form>




</div>


<br><br>


<div class="dataset-grid">


<?php

foreach($_SESSION['generated_analyses'] as $analysis)
{

    if($analysis == "length_plot")
    {
        echo "<div class='card'>";
        echo "<img src='plot.php?type=length&id=$id&t=".time()."'>";
        echo "</div>";
    }

    if($analysis == "residue_conserve")
    {
        echo "<div class='card'>";
        echo "<img src='plot.php?type=conservation&id=$id&t=".time()."'>";
        echo "</div>";
    }

    if($analysis == "aa_comp")
    {
        echo "<div class='card'>";
        echo "<img src='plot.php?type=aa&id=$id&t=".time()."'>";
        echo "</div>";
    }

    if($analysis == "stats")
    {
        echo "<div class='card'>";
        echo "<h4 style='text-align: center; margin-bottom: 20px;'>Dataset Statistics</h4>";
        echo get_statistics($sequences);
        echo "</div>";
    }


    if($analysis == "heatmap")
    {
        echo "<div class='card'>";
        echo "<img src='plot.php?type=heatmap&id=$id&t=".time()."'>";
        echo "</div>";
    }


    if($analysis == "cons")
    {
        echo "<div class='card'>";
        echo "<img src='plot.php?type=conserved_regions&id=$id&t=".time()."'>";
        echo "</div>";

    }


}

?>


</div>
</div>
