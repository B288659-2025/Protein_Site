<?php

function get_sequences_ncbi($protein, $taxon, $maxseq, $exclude_partial, $manual_only,$exclude_frag)
{

    $query = $protein . " AND (" . $taxon . ")";

    if ($exclude_partial) {
       $query .= " NOT partial";
    }

    if ($exclude_frag) {
       $query .= " NOT fragment";
    }

    if ($manual_only) {
       $query .= " AND reviewed[filter]";
    }

    $term = urlencode($query);

    // Step 1: search for IDs
    $search_url =
       "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi".
       "?db=protein&term={$term}&retmax={$maxseq}&api_key=d41e452731cb27ccab32c0651c40b7dc5a08";

    $search_xml = file_get_contents($search_url);
    if(!$search_xml) {
        return "";
    }

    $xml = simplexml_load_string($search_xml);
    if(!$xml || !isset($xml->IdList->Id)) {
        return "";
    }

    // Collect IDs
    $ids = [];
    foreach($xml->IdList->Id as $id) {
        $ids[] = (string)$id;
    }

    if(empty($ids)) {
        return "";
    }

    $id_string = implode(",", $ids);

    // Step 2: fetch FASTA sequences
    $fetch_url =
        "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi".
        "?db=protein&id={$id_string}&rettype=fasta&retmode=text&api_key=d41e452731cb27ccab32c0651c40b7dc5a08";

    $fasta = file_get_contents($fetch_url);

    return $fasta ? $fasta : "";
}

function run_alignment($fasta)
{
    file_put_contents("/tmp/sequences.fasta", $fasta);

    $cmd = "clustalo -i /tmp/sequences.fasta -o /tmp/alignment.aln --force";
    shell_exec($cmd);

    if(file_exists("/tmp/alignment.aln"))
    {
        return file_get_contents("/tmp/alignment.aln");
    }

    return "";
}

function run_motifs($fasta)
{
    file_put_contents("/tmp/sequences.fasta", $fasta);

    $cmd = "patmatmotifs -sequence /tmp/sequences.fasta -outfile /tmp/motifs.txt -auto";
    shell_exec($cmd);

    if(file_exists("/tmp/motifs.txt"))
    {
        return file_get_contents("/tmp/motifs.txt");
    }

    return "";
}

function generate_length_plot($fasta, $id)
{
//    $fasta_file = "/tmp/sequences.fasta";
//    $plot_file = "/tmp/length_plot_$id_analysis.png";
    $fasta_file = "/tmp/sequences_" . $id . ".fasta";
    $plot_file  = "/tmp/length_plot_" . $id . ".png";
    file_put_contents($fasta_file, $fasta);

    $cmd = "/usr/bin/python3 /localdisk/home/s2794196/public_html/protein_site/plot_lengths.py $fasta_file $plot_file 2>&1";
    shell_exec($cmd);


    return $plot_file;
}

function generate_conservation_plot($alignment, $id)
{
    $aln_file = "/tmp/alignment_" . $id . ".fasta";
    $plot_file = "/tmp/conservation_plot_" . $id . ".png";

    file_put_contents($aln_file, $alignment);

    $cmd = "python3 /localdisk/home/s2794196/public_html/protein_site/plot_conservation.py $aln_file $plot_file";
    shell_exec($cmd);

    return $plot_file;
}

function generate_aa_composition_plot($fasta, $id)
{
    $fasta_file = "/tmp/sequences_" . $id . ".fasta";
    $plot_file = "/tmp/aa_comp_" . $id . ".png";

    file_put_contents($fasta_file, $fasta);

    $cmd = "python3 /localdisk/home/s2794196/public_html/protein_site/plot_aa_comp.py $fasta_file $plot_file";
    shell_exec($cmd);

    return $plot_file;
}

function generate_heatmap_plot($alignment, $id)
{
    $aln_file = "/tmp/alignment_" . $id . ".fasta";
    $plot_file = "/tmp/heatmap_" . $id . ".png";

    file_put_contents($aln_file, $alignment);

    $cmd = "python3 /localdisk/home/s2794196/public_html/protein_site/plot_heatmap.py $aln_file $plot_file";
    shell_exec($cmd);

    return $plot_file;
}
function generate_conserved_regions_plot($alignment, $id)
{
    $aln_file = "/tmp/alignment_" . $id . ".fasta";
    $plot_file = "/tmp/conserved_regions_" . $id . ".png";

    file_put_contents($aln_file, $alignment);

    $cmd = "python3 /localdisk/home/s2794196/public_html/protein_site/plot_conserved_regions.py $aln_file $plot_file";
    shell_exec($cmd);

    return $plot_file;
}

function get_statistics($fasta)
{
    $fasta_file = "/tmp/stats.fasta";

    file_put_contents($fasta_file, $fasta);

    $cmd =
        "python3 /localdisk/home/s2794196/public_html/protein_site/stats_biopython.py "
        . $fasta_file;

    return shell_exec($cmd);
}

function save_analysis(
    $pdo,
    $protein,
    $taxon,
    $maxseq,
    $sequences,
    $alignment,
    $motifs,
    $exclude_partial,
    $manual_only,
    $exclude_frag
)
{
    // Get logged in user
    $id_user = $_SESSION["id_user"] ?? null;
    $session_id = session_id();

    $stmt = $pdo->prepare("
        INSERT INTO analyses
        (
            name,
            protein,
            taxon,
            seq_max,
            id_user,
            session_id,
            exclude_partial,
            manual_only,
            exclude_frag
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        "User Dataset",
        $protein,
        $taxon,
        $maxseq,
        $id_user,
	$session_id,
        $exclude_partial,
        $manual_only,
        $exclude_frag
    ]);

    $id_analysis = $pdo->lastInsertId();


    $stmt = $pdo->prepare("
        INSERT INTO sequences
        (id_analysis, fasta_data)
        VALUES (?, ?)
    ");

    $stmt->execute([
        $id_analysis,
        $sequences
    ]);


    $stmt = $pdo->prepare("
        INSERT INTO alignments
        (id_analysis, alignment_data)
        VALUES (?, ?)
    ");

    $stmt->execute([
        $id_analysis,
        $alignment
    ]);


    $stmt = $pdo->prepare("
        INSERT INTO motifs
        (id_analysis, motif_data)
        VALUES (?, ?)
    ");

    $stmt->execute([
        $id_analysis,
        $motifs
    ]);

    return $id_analysis;
}
function search_exists($pdo, $protein, $taxon, $seq_max,
                       $exclude_partial, $manual_only, $exclude_frag)
{
    $stmt = $pdo->prepare("
        SELECT 1
        FROM analyses
        WHERE protein = ?
        AND taxon = ?
        AND seq_max = ?
        AND exclude_partial = ?
        AND manual_only = ?
        AND exclude_frag = ?
        LIMIT 1
    ");

    $stmt->execute([
        $protein,
        $taxon,
        $seq_max,
        $exclude_partial,
        $manual_only,
        $exclude_frag
    ]);

    return $stmt->fetchColumn();
}
?>
