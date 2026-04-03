<?php

// Add the menu navigation
require 'menu.php';

// Display page title
echo "<h2 class='section-title'>Help Page</h2>";
?>

<!-- Use the container and card classes for content organization -->
<div class="container">

	<div class="card">

		<h3>Overview</h3>
		<p>
			This application allows users to search for protein sequences from the NCBI database,
			perform multiple sequence alignment, scan for motifs and carry out additional analyses.
			These additional analyses include generating dataset statistics, producing
			sequence length distribution plots, creating residue conservation plots,
			and generating amino acid composition plots.
		</p>
		<h3>Biological Meaning of the Analysis</h3>

		<p>
			This system is designed to help scientists understand how proteins are related across different species and how their functions are preserved.
			By comparing protein sequences, researchers can identify important regions that are necessary for biological activity.
		</p>
		<p>
			<b>A protein sequence</b> is a chain of amino acids that determines the structure and function of a protein.
			Proteins carry out important biological roles in cells, such as catalysing chemical reactions,
			transporting molecules and supporting cellular structure.
			Comparing protein sequences from different organisms helps scientists understand how proteins function
			and how they have evolved over time.
		</p>
		<p>
			<b>Multiple sequence alignment</b> allows protein sequences from different species to be compared.
			Regions that remain similar across species are often important for the structure or function of the protein.
			These conserved regions may represent active sites or important structural components.
		</p>
		<p>
			<b>Motif scanning</b> searches for known patterns within protein sequences.
			Motifs are short sequence patterns that are linked to specific biological functions, such as enzyme activity or binding sites.
			Identifying motifs helps researchers determine the possible role of a protein.
		</p>
		<p>
			The additional analysis tools provide further biological insight into the dataset.
			For example:
		</p>

		<ul>

		<li>
			<b>Dataset statistics</b> summarise the basic properties of the protein sequences in the dataset.
			These values help users understand whether the proteins are similar in size and whether the dataset is biologically consistent.
			<ul>
			<br>
			<li>
				<b>Number of sequences:</b>
				This shows how many protein sequences were analysed.
				Using more sequences usually improves the reliability of comparisons and makes it easier to identify conserved regions that are important for protein function.
			</li>
			<br>
			<li>
				<b>Total residues:</b>
				This represents the total number of amino acids across all sequences.
				Larger datasets may provide more biological information but may also take longer to analyse.
			</li>
			<br>
			<li>
				<b>Shortest and longest sequence:</b>
				These values show the range of protein sizes in the dataset.
				Large differences in length may indicate incomplete sequences, protein fragments, or proteins with different functional domains.
			</li>
			<br>
			<li>
				<b>Average length:</b>
				This shows the typical size of proteins in the dataset.
				Proteins with similar lengths across species often perform the same biological function.
			</li>
			<br>
			<li>
				<b>Median length:</b>
				The median length represents the middle value when sequence lengths are ordered.
				It helps identify the typical protein size without being affected by unusually long or short sequences.
			</li>
			<br>
			<li>
				<b>Standard deviation:</b>
				This measures how much the sequence lengths vary.
				A low value suggests the proteins are structurally similar, while a high value may indicate biological diversity or the presence of different protein variants.
			</li>
			<br>
			<li>
				<b>GC content (%):</b>
				This shows the proportion of guanine and cytosine bases in the DNA sequences that encode the proteins.
				GC content can vary between species and may reflect evolutionary differences or adaptation to different environments.
			</li>

			</ul>

			</li>
			<br>
			<li>
				<b>Sequence length distribution</b> shows how protein sizes vary across species, which may reflect evolutionary differences.
			</li>

	                <br>
			<li>
				<b>Residue conservation plots</b> identify positions in the protein sequence that remain similar across species.
				Highly conserved residues are often essential for biological function.
			</li>
                	<br>
			<li>
				<b>Amino acid composition plots</b> show how frequently different amino acids occur in the dataset.
				This can help show structural or functional patterns in the proteins.
			</li>
                        <br>
			<li>
				<b>Sequence similarity heatmaps</b> compare how closely related different protein sequences are to each other.
			</li>
                        <br>
			<li>
				<b>Conservation region plots</b> find strongly conserved areas that may represent important functional domains.
			</li>

		</ul>

		<h3>How to Run a Search</h3>
		<ol>
			<li>Enter a protein name (can also select from the example drop down menu).</li>
                        <br>
			<li>Enter a taxon (can also select from the example drop down menu).</li>
                        <br>
			<li>Choose the maximum number of sequences.</li>
			<br>
			<li>Select any filters if required.</li>
                        <br>
			<li>Click the Run Analysis button.</li>
			<br>
			<li>Click the 'Use Example Dataset (Glucose-6-Phosphatase Aves)' button if you would like to view potential results.</li>
		</ol>

		<h3>Quality Filters</h3>
		<p>
			The quality filter options help users choose better quality protein sequences
			before running the analysis.
		</p>

		<!-- Use <ol> and <li> tags for numbering since this is a sequence of steps -->
		<!-- Source: https://www.w3schools.com/tags/tag_ol.asp -->
		<ol>
			<li>Exclude partial sequences removes incomplete sequences so the analysis uses full protein sequences.</li>
			<br>
			<li>Manual curated only selects sequences that have been checked and reviewed by experts, making the data more reliable.</li>
                        <br>
			<li>Exclude fragments removes very short pieces of sequences that may not represent complete proteins and could affect the results.</li>
		</ol>

		<h3>Viewing Results</h3>
		<p>
			After running a search, the system will display:
		</p>

		<!-- Use <ul> and <li> tags for bulleting non-sequential information -->
		<!-- Source: https://www.w3schools.com/tags/tag_ul.asp -->
		<ul>
			<li>Retrieved protein sequences</li>
                        <br>
			<li>Multiple sequence alignment</li>
			<br>
			<li>Motif scan results</li>
		</ul>

		<p>
			If you like, you can then perform additional analysis and generate figures by
			clicking the Analysis option in the menu.
		</p>


		<h3>Exporting Results</h3>
		<p>
			The system provides an export function that allows users to download generated results,
			including sequences, sequence alignments, motif findings, and
			analysis outputs.
			Files can be saved in common formats such as FASTA or text files.
			Users can select which dataset to download from a dropdown menu listing
			their previously generated analyses.
		</p>


		<h3>Troubleshooting</h3>
		<ul>
			<li>If no sequences are returned, check the protein name and taxon spelling. Sometimes, extreme filtering may result in no results.</li>
                        <br>
			<li>If alignment is not shown, ensure at least two sequences were retrieved.</li>
                        <br>
			<li>If motifs are not found, the protein may not contain known motif patterns.</li>
		</ul>

	</div>
</div>
