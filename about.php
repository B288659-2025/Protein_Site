<?php
require 'menu.php';
echo "<h2 class='section-title'>About Page</h2>";
require_once 'db.php';
?>
<div class="container">

    <div class="card">


    <p>
     This website is a Protein Sequence Analysis Portal designed to help users find and study protein sequence data from biological databases.
     The system allows users to search for protein sequences from the NCBI database using simple search options such as protein name, organism, and other filters.
    </p>

    <p>
     After retrieving sequences, users can carry out multiple sequence alignment and look for conserved motifs within the data.
     The website also offers extra analysis tools, such as creating dataset statistics, sequence length distribution plots, residue conservation plots, and amino acid composition plots.
     These tools help users understand the main features and patterns in the protein sequences.
    </p>

    <p>
    All results produced by the website can be saved and exported for later use. 
    This makes it easy for users to keep their analysis, return to previous searches, and use the data in other bioinformatics tools or research projects.
    </p>

    <p>
     This website was developed as part of a bioinformatics coursework project to show how biological databases, 
     sequence analysis tools, and web based interfaces can work together to support efficient protein sequence analysis.
    </p>

    <h2>Technologies Used</h2>

    <p>
    The system was developed using PHP for server side processing, HTML and CSS to create the website interface, and BioPython to generate graphs and calculate dataset statistics. 
    It also uses external bioinformatics tools and databases such as NCBI, Clustal Omega, and motif scanning tools to carry out sequence analysis.
    </p>

</div>
</div>


</body>
</html>
