<?php

session_start();

require_once 'db.php';


if(isset($_POST['id_analysis']))
{
    $_SESSION['id_analysis'] = $_POST['id_analysis'];

    header("Location: seq.php");
    exit;
}


$stmt = $pdo->query("
select id_analysis, protein, taxon, seq_max
from analyses
where protein != 'glucose-6-phosphatase'
order by id_analysis desc
");

$analyses = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<h1 style='text-align:center;'>Previous Searches</h1>";
require_once 'menu.php';


if(empty($analyses))
{
    echo "<p>No previous analyses found.</p>";
}
else
{
    echo "<div class='dataset-grid'>";
    foreach($analyses as $a)
    {
        $id = $a['id_analysis'];
        $protein = $a['protein'];
        $taxon = $a['taxon'];
        $seq_max = $a['seq_max'];
        echo "
          <form method='POST'>
            <input type='hidden' name='id_analysis' value='$id'>
            <button type='submit'>
                $protein ($taxon) - $seq_max sequences
            </button>
        </form>
    ";
    }
}
echo "</div>";
?>
