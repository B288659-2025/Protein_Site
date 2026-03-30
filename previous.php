<?php

session_start();

require_once 'db.php';
require_once 'menu.php';

echo "<h2 class='section-title'>Previous Searches</h2>";

if (!isset($_SESSION['id_user']))
{
    if (isset($_SESSION['id_analysis']))
    {
        echo "<p class='info-text'>";
        echo "You are currently using the system as a guest. ";
        echo "Your analyses are stored only for this session.";
        echo "</p>";
    }
    else
    {
        echo "<p class='info-text'>";
        echo "No history available.";
        echo "<br>";
        echo "Please log in to retrieve saved history or perform a new analysis.";
        echo "</p>";

        exit;
    }
}

$id_user = $_SESSION['id_user'] ?? null;

if ($id_user != null)
{
    $stmt = $pdo->prepare("
        select
            id_analysis,
            protein,
            taxon,
            seq_max,
            created_at,
            exclude_partial,
            manual_only,
            exclude_frag
        from analyses
        where id_user = ?
        order by id_analysis desc
    ");

    $stmt->execute([$id_user]);
}
else
{
    $stmt = $pdo->prepare("
        select
            id_analysis,
            protein,
            taxon,
            seq_max,
            created_at,
            exclude_partial,
            manual_only,
            exclude_frag
        from analyses
        where session_id = ?
        order by id_analysis desc
    ");

    $stmt->execute([session_id()]);
}

$analyses = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($analyses))
{
    echo "<p class='info-text'>No previous analyses found.</p>";
}
else
{
    echo "<div class='card'>";
    echo "<div class='dataset-grid'>";

    foreach ($analyses as $a)
    {
        $id = $a['id_analysis'];
        $protein = htmlspecialchars($a['protein']);
        $taxon = htmlspecialchars($a['taxon']);
        $seq_max = htmlspecialchars($a['seq_max']);

        $filters = [];

        if ($a['exclude_partial'])
        {
            $filters[] = "Exclude partial";
        }

        if ($a['manual_only'])
        {
            $filters[] = "Manual only";
        }

        if ($a['exclude_frag'])
        {
            $filters[] = "Exclude fragments";
        }

        if (empty($filters))
        {
            $filter_text = "No filters";
        }
        else
        {
            $filter_text = implode(", ", $filters);
        }

        $time = date("d M Y H:i", strtotime($a['created_at']));

        echo "
        <form method='POST' action='seq.php'>

            <input type='hidden'
                   name='id_analysis'
                   value='$id'>

            <button type='submit'
                    class='history-card'>

                <div class='history-title'>
                    $protein ($taxon)
                </div>

                <div class='history-meta'>
                    $seq_max sequences
                </div>

                <div class='history-meta'>
                    $filter_text
                </div>

                <div class='history-time'>
                    $time
                </div>

            </button>

        </form>
        ";
    }

    echo "</div>";
    echo "</div>";
}


?>
