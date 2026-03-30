<?php
require 'menu.php';
echo "<h2 class='section-title'>Help Page</h2>";
require_once 'db.php';
?>
<div class="container">

    <div class="card">


        <h3>Overview</h3>
        <p>
            This application allows users to search for protein sequences from the NCBI database,
            perform multiple sequence alignment, scan for motifs and carry out additional analyses. 
            These additional analyses include generating dataset statistics, producing sequence length distribution plots, creating residue conservation plots, 
            and generating amino acid composition plots. 
        </p>

        <h3>How to Run a Search</h3>
        <ol>
            <li>Enter a protein name (can also select from the example drop down menu).</li>
            <li>Enter a taxon (can also select from the example drop down menu).</li>
            <li>Choose the maximum number of sequences.</li>
            <li>Select any filters if required.</li>
            <li>Click the Run Analysis button.</li>
            <li>Click the 'Use Example Dataset (Glucose-6-Phosphatase Aves)' button if you would like to view potential results.</li>

        </ol>

        <h3>Maximum Sequences</h3>
        <p>
         The maximum number of sequences is set to 30 by default to keep the system running smoothly and to reduce waiting time. 
         When too many sequences are selected, the analysis takes longer because the computer has to process more data.
         Limiting the number of sequences helps the system give results faster while still providing enough data for useful analysis.
        </p>


        <h3>Quality Filters</h3>
	<p>
	The quality filter options help users choose better quality protein sequences before running the analysis.
	</p>
	<ol>
            <li>Exclude partial sequences removes incomplete sequences so the analysis uses full protein sequences.</li>
            <li>Manual curated only selects sequences that have been checked and reviewed by experts, making the data more reliable.</li>
            <li>Exclude fragments removes very short pieces of sequences that may not represent complete proteins and could affect the results.</li>

        </ol>


        <h3>Viewing Results</h3>
        <p>
            After running a search, the system will display:
        </p>

        <ul>
            <li>Retrieved protein sequences</li>
            <li>Multiple sequence alignment</li>
            <li>Motif scan results</li>
        </ul>

	<p>
         If you like, you can then perform additional analysis and generate figures by clicking the Analysis option in the menu.
	</p>


        <h3>Previous Searches</h3>
        <p>
            All completed analyses are stored in the database. You can revisit them at any time
            by clicking the History option in the menu.
        </p>

        <h3>Exporting Results</h3>
        <p>
            The system provides an export function that allows users to download generated results,
            including retrieved sequences, sequence alignments, motif findings, and analysis outputs.
            Files can be saved in common formats such as FASTA or text files. 
            Users can select which dataset to download from a dropdown menu listing their previously generated analyses.
        </p>


        <h3>User Accounts</h3>
        <p>
            Registered users can save their searches permanently. Guest users can still run
            analyses, but their results will only be stored for the current session.
        </p>

        <h3>Troubleshooting</h3>
        <ul>
            <li>If no sequences are returned, check the protein name and taxon spelling. Sometimes, extreme filtering may result in no results. </li>
            <li>If alignment is not shown, ensure at least two sequences were retrieved.</li>
            <li>If motifs are not found, the protein may not contain known motif patterns.</li>
        </ul>

    </div>

</div>

