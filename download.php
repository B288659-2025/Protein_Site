<?php

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

require_once "db.php";

$id = $_SESSION['id_analysis'] ?? null;

if (!$id)
{
    echo "Please select a dataset first";
    exit;
}


$tmp_dir = sys_get_temp_dir() . "/export_" . uniqid();

if (!mkdir($tmp_dir))
{
    echo "Could not create temporary directory";
    exit;
}


$something_selected = false;


if (isset($_POST['export_sequences']))
{
    $something_selected = true;

    $format = $_POST['sequences_format'] ?? "fasta";

    $stmt = $pdo->prepare("
        SELECT fasta_data
        FROM sequences
        WHERE id_analysis = ?
    ");

    $stmt->execute([$id]);

    $sequences = $stmt->fetchColumn();

    if ($sequences)
    {
        if ($format == "txt")
        {
            $filename = "sequences.txt";
        }
        else
        {
            $filename = "sequences.fasta";
        }

        file_put_contents(
            $tmp_dir . "/" . $filename,
            $sequences
        );
    }
}


if (isset($_POST['export_alignment']))
{
    $something_selected = true;

    $format = $_POST['alignment_format'] ?? "fasta";

    $source_file = "/tmp/alignment.aln";

    if (!file_exists($source_file))
    {
        echo "Alignment file not found";
        exit;
    }

    if ($format == "txt")
    {
        $filename = "alignment.txt";
    }
    else
    {
        $filename = "alignment.fasta";
    }

    copy(
        $source_file,
        $tmp_dir . "/" . $filename
    );
}

if (isset($_POST['export_motif_report']))
{
    $something_selected = true;

    $file = "/tmp/motifs.txt";

    if (file_exists($file))
    {
        copy(
            $file,
            $tmp_dir . "/motif_report.txt"
        );
    }
}



if (isset($_POST['export_figures']))
{
    $something_selected = true;

    $id = $_SESSION['id_analysis'];

    $figures = [
        "/tmp/length_plot_" . $id . ".png",
        "/tmp/conservation_plot_" . $id . ".png",
        "/tmp/aa_comp_" . $id . ".png"
    ];

    foreach ($figures as $file)
    {
        if (file_exists($file))
        {
            copy(
                $file,
                $tmp_dir . "/" . basename($file)
            );
        }
        else
        {
            echo "Missing figure: " . $file;
            exit;
        }
    }
}

if (!$something_selected)
{
    header("Location: export.php?error=1");
    exit;
}


$zip_file = $tmp_dir . ".zip";

$command = "zip -r " .
           escapeshellarg($zip_file) .
           " " .
           escapeshellarg($tmp_dir);

exec($command);


header("Content-Type: application/zip");
header("Content-Disposition: attachment; filename=export_results.zip");
header("Content-Length: " . filesize($zip_file));

readfile($zip_file);


unlink($zip_file);

exec(
    "rm -rf " .
    escapeshellarg($tmp_dir)
);

exit;

?>
