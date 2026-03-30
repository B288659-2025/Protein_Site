<?php
session_start();


require_once 'menu.php';
echo "<h2 class='section-title'>Motif Scan</h2>";
require_once 'db.php';
echo "<div class = 'container'>";
$id_analysis = $_SESSION['id_analysis'] ?? null;
if(!$id_analysis)
{
    echo "<p class='info-text'>";
    echo "Please select a dataset first";
    echo "</p>";
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

function display_motifs($text)
{
    if (!$text)
    {
        echo "<p class='info-text'>";
        echo "No motif results found.";
        echo "</p>";
        echo "</div>";

        exit;
    }

    $lines = explode("\n", $text);

    $sequence = "";
    $motif = "";
    $start = "";
    $end = "";
    $length = "";

    $found = false;

    foreach ($lines as $line)
    {
        if (preg_match("/Sequence:\s+(\S+)/", $line, $m))
        {
            $sequence = $m[1];
        }

        if (preg_match("/Motif\s*=\s*(\S+)/", $line, $m))
        {
            $motif = $m[1];
        }

        if (preg_match("/Length\s*=\s*(\d+)/", $line, $m))
        {
            $length = $m[1];
        }

        if (preg_match("/Start\s*=\s*position\s*(\d+)/", $line, $m))
        {
            $start = $m[1];
        }

        if (preg_match("/End\s*=\s*position\s*(\d+)/", $line, $m))
        {
            $end = $m[1];

            if ($sequence != "" && $start != "" && $end != "")
            {
                if (!$found)
                {
                    echo "<div class='card'>";
                    echo "<table class='motif-table'>";
                    echo "<tr>
                            <th>Sequence</th>
                            <th>Motif</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Length</th>
                          </tr>";

                    $found = true;
                }

                echo "<tr>
                        <td>$sequence</td>
                        <td>$motif</td>
                        <td>$start</td>
                        <td>$end</td>
                        <td>$length</td>
                      </tr>";

                $motif = "";
                $start = "";
                $end = "";
                $length = "";
            }
        }
    }

    if ($found)
    {
        echo "</table>";
        echo "</div>";
    }
    else
    {
        echo "<p class='info-text'>";
        echo "No motif results found.";
        echo "</p>";
        echo "</div>";
    }
}

display_motifs($motifs);

echo "</div>";
?>
