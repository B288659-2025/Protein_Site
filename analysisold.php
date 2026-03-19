<?php

session_start();

require_once 'db.php';
require_once 'analysis_functions.php';
echo "<h1 style='text-align:center;'>Additional Analysis</h1>";
require_once 'menu.php';


if(!isset($_SESSION['id_analysis']))
{
    echo "Please select a dataset first.";
    exit;
}

$id = $_SESSION['id_analysis'];

echo "<h3>Choose an analysis:</h3>";

?>

<div class="analysis-grid">
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

<form method="POST">
<button name="analysis" value="stats">
Generate Statistics
</button>
</form>
</div>
<br>

<?php

if(isset($_POST['analysis']))
{
    echo "<h3>Results</h3>";
    echo "<div class='analysis-results'>";

    if($_POST['analysis'] == "length_plot")
    {
        echo "<img src='plot.php?type=length'>";
    }

    if($_POST['analysis'] == "residue_conserve")
    {
        echo "<img src='plot.php?type=conservation'>";
    }

    if($_POST['analysis'] == "aa_comp")
    {
        echo "<img src='plot.php?type=aa'>";
    }

    if($_POST['analysis'] == "stats")
    {
        echo "<div class='stats-box'>";
        echo "Statistics go here";
        echo "</div>";
    }

    echo "</div>";
}
?>
