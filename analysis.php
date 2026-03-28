<?php

session_start();

require_once 'db.php';
require_once 'analysis_functions.php';

require_once 'menu.php';

echo "<div class = 'container'>";
if(!isset($_SESSION['id_analysis']))
{
    echo "Please select a dataset first.";
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
<div class='analysis-grid'>

<form method="POST">
<button name="analysis" value="stats">
Generate Dataset Statistics
</button>
</form>

<form method="POST">
<button name="analysis" value="length_plot">
Generate Sequence Length Distribution
</button>
</form>

<form method="POST">
<button name="analysis" value="residue_conserve">
Generate Residue Conservation Plot
</button>
</form>

<form method="POST">
<button name="analysis" value="aa_comp">
Generate Amino Acid Composition Plot
</button>
</form>


</div>


<br><br>


<div class="plot-grid">


<?php

foreach($_SESSION['generated_analyses'] as $analysis)
{

    if($analysis == "length_plot")
    {
        echo "<div>";
        echo "<h4>Sequence Length Distribution</h4>";
        echo "<img src='plot.php?type=length&id=$id&t=".time()."'>";
        echo "</div>";
    }

    if($analysis == "residue_conserve")
    {
        echo "<div>";
        echo "<h4>Residue Conservation</h4>";
        echo "<img src='plot.php?type=conservation&id=$id&t=".time()."'>";
        echo "</div>";
    }

    if($analysis == "aa_comp")
    {
        echo "<div>";
        echo "<h4>Amino Acid Composition</h4>";
        echo "<img src='plot.php?type=aa&id=$id&t=".time()."'>";
        echo "</div>";
    }

    if($analysis == "stats")
    {
        echo "<div>";
        echo "<h4>Dataset Statistics</h4>";
        echo get_statistics($sequences);
        echo "</div>";
    }

}

?>


</div>
</div>
