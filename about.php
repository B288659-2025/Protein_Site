<?php

// Add the menu navigation
require 'menu.php';

// Display page title
echo "<h2 class='section-title'>About the System</h2>";

?>

<!-- Use the container and card classes for content organization -->
<div class="container">

	<div class="card">

		<p>
			The system follows a clear step by step workflow. First, the user provides a protein and a taxon.
			The user can also choose quality filters and set the number of sequences to retrieve. The default number of sequences is set to 25 to keep the analysis running smoothly,
			while the system internally allows up to 50 sequences if needed. After the search is submitted, the system retrieves the sequences from the database, 
			runs the selected analysis tools, and saves the results. Each analysis is given a unique identifier so the results can be stored and used again later 
			without repeating the same analysis. This helps the system run efficiently and keeps the results consistent.
		</p>

		<p>
			The system follows a step by step workflow. 
			First, the user enters a search. 
			The system then retrieves the sequences, runs the analysis tools, and saves the results. 
			Each analysis is given its own ID so the results can be stored and used again later without running the same analysis again. 
			This helps the system run faster and keeps the results consistent.
		</p>

                <p>
                        The system follows a step by step workflow. 
                        First, the user enters a search. 
                        The system then retrieves the sequences, runs the analysis tools, and saves the results. 
                        Each analysis is given its own ID so the results can be stored and used again later without running the same analysis again. 
                        This helps the system run faster and keeps the results consistent.
                </p>

		<p>
			In addition to alignment and motif scanning, the system also provides optional analyses. 
			These analyses use Python tools such as Biopython, Matplotlib, and NumPy to create graphs and statistics. 
			Examples include sequence length plots, conservation plots, amino acid composition plots, 
			similarity heatmaps, and conserved region plots. 
			These outputs help users understand patterns in their data.
		</p>

		<p>
			All completed analyses are saved in a database so users can return to their previous searches. 
			If a user has an account, their analyses are saved permanently. 
			If a user is using guest mode, their results are only saved for the current session or for up to 24 hours. 
			This allows the system to manage storage while still giving users access to their results.
		</p>

		<p>
			The system keeps track of users using sessions. 
			Registered users are linked to their account, while guest users are linked to a temporary session. 
			This allows guest users to run searches without signing up, 
			and it also helps stop the system from repeating the same search more than once in the same session.
		</p>

		<p>
			The system also includes an export feature that allows users to download their results. 
			Users can download protein sequences, alignments, motif results, and analysis plots. 
			This makes it easy to use the data in other bioinformatics tools or future research.
		</p>

		<p>
			The system connects to external bioinformatics tools to perform the analysis. 
			These tools run automatically on the server after sequences are retrieved. 
			The system handles file storage and result processing so that everything runs smoothly between the web interface 
			and the analysis programs.
		</p>

		<p>
			This website was developed as part of a bioinformatics coursework project to show how databases, 
		 web technologies, and external analysis tools can be combined into one working system for protein sequence analysis.
		</p>

		<h2>Technologies Used</h2>

		<p>
			The system was built using PHP for server side processing and database communication, 
			HTML and CSS for the user interface, and Python scripts to generate graphs and calculate statistics. 
			A relational database is used to store analyses and user data. 
			The system also uses external bioinformatics tools such as the NCBI database for sequence retrieval, 
			Clustal Omega for sequence alignment, and EMBOSS tools for motif detection. 
			All of these technologies work together to run the protein sequence analysis system.
		</p>

	</div>

</div>
