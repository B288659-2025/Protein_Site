<?php
// Include navigation menu
require 'menu.php';
?>

<h2 class="section-title">Credits</h2>

<div class="container">


<div class="card">

<h3>Data Sources</h3>

<p>
The protein sequence data used in this system was retrieved from the
National Center for Biotechnology Information (NCBI) database.
</p>

</div>



<div class="card">

<h3>Bioinformatics Tools</h3>

<ul>
<li><a href="https://www.ncbi.nlm.nih.gov/books/NBK25499/#chapter4.Introduction" target="_blank">NCBI E-Utilities for sequence retrieval</a></li>

<br>

<li><a href="https://www.ebi.ac.uk/jdispatcher/msa/clustalo" target="_blank">Clustal Omega for multiple sequence alignment</a></li>

<br>

<li><a href="https://prosite.expasy.org/" target="_blank">PROSITE database for motif scanning</a></li>

<br>

<li><a href="https://www.ebi.ac.uk/jdispatcher/emboss" target="_blank">EMBOSS tools for sequence analysis</a></li>
</ul>

</div>



<div class="card">

<h3>Technologies and Tutorials Used</h3>

<ul>
<li><a href="https://www.php.net/" target="_blank">PHP for web programming</a></li>

<br>

<li><a href="https://www.w3schools.com" target="_blank">HTML and CSS for user interface design</a></li>

<br>

<li><a href="https://www.w3schools.com/js/" target="_blank">JavaScript for interactive features</a></li>

<br>

<li><a href="https://www.linux.org/" target="_blank">Linux command line environment</a></li>

<br>

<li><a href="https://www.python.org/" target="_blank">Python programming</a></li>

<br>

<li><a href="https://bioinfmsc8.bio.ed.ac.uk/IWD2.html" target="_blank">IWDD Class tutorials</a></li>

</ul>

</div>



<div class="card">

<h3>Detailed Code References</h3>

<p>
The following sources were used to help develop specific parts of the website. Codes were implemented with slight modification.
</p>

<ul>

<li>
<a href="https://www.w3schools.com/css/default.asp" target="_blank">
CSS styling and page layout guidance
</a>
--> Used to design the layout and visual of the web pages.
</li>

<br>

<li>
<a href="https://www.php.net/manual/en/pdostatement.fetch.php" target="_blank">
PDO fetch function
</a>
--> Used to retrieve data from the database after running SQL queries.
</li>

<br>

<li>
<a href="https://dev.mysql.com/doc/refman/8.4/en/date-and-time-functions.html" target="_blank">
MySQL date and time functions
</a>
--> Used to store and manage timestamps for saved results.
</li>

<br>


<li>
<a href="https://stackoverflow.com/questions/8544438/select-records-from-now-1-day" target="_blank">
MySQL interval command
</a>
--> Used to delete guest data after 24 hours.
</li>

<br>

<li>
<a href="https://www.php.net/manual/en/function.implode.php" target="_blank">
implode function
</a>
--> Used to combine values from arrays into text for output and export.
</li>

<br>

<li>
<a href="https://www.php.net/manual/en/function.preg-match.php" target="_blank">
preg_match function
</a>
--> Used to search and extract motif patterns from scan results.
</li>

<br>

<li>
<a href="https://www.php.net/manual/en/function.readfile.php" target="_blank">
readfile function
</a>
--> Used to allow users to download exported files.
</li>

<br>

<li>
<a href="https://www.php.net/manual/en/function.header.php" target="_blank">
header function
</a>
--> Used to redirect users and handle file downloads.
</li>

<br>

<li>
<a href="https://www.php.net/manual/en/function.http-response-code.php" target="_blank">
http_response_code function
</a>
--> Used to manage server responses during errors.
</li>

<br>

<li>
<a href="https://www.php.net/manual/en/function.array-shift.php" target="_blank">
array_shift function
</a>
--> Used to process arrays when handling data.
</li>

<br>

<li>
<a href="https://www.php.net/manual/en/function.explode.php" target="_blank">
explode function
</a>
--> Used to split strings into smaller parts during data processing.
</li>

<br>

<li>
<a href="https://www.w3schools.com/tags/tag_ul.asp" target="_blank">
HTML ul tag
</a>
--> Used to create lists in menus and content sections.
</li>

<br>

<li>
<a href="https://www.w3schools.com/tags/tag_li.asp" target="_blank">
HTML li tag
</a>
--> Used to display list items.
</li>

<br>

<li>
<a href="https://www.w3schools.com/tags/tag_span.asp" target="_blank">
HTML span tag
</a>
--> Used to format small sections of text.
</li>

<br>

<li>
<a href="https://www.w3schools.com/tags/tag_datalist.asp" target="_blank">
HTML datalist tag
</a>
--> Used to provide suggestions in input fields.
</li>

<br>

<li>
<a href="https://www.php.net/manual/en/function.strtotime.php" target="_blank">
strtotime function
</a>
--> Used to convert time values for storing analysis history.
</li>

<br>

<li>
<a href="https://www.php.net/manual/en/function.password-verify.php" target="_blank">
password_verify function
</a>
--> Used to check user login passwords.
</li>

<br>

<li>
<a href="https://board.phpbuilder.com/d/10383423-resolved-password-strength" target="_blank">
Password strength discussion
</a>
--> Used as guidance for validating password strength.
</li>

<br>

<li>
<a href="https://www.php.net/manual/en/function.password-hash.php" target="_blank">
password_hash function
</a>
--> Used to securely store user passwords.
</li>

<br>

<li>
<a href="https://matplotlib.org/" target="_blank">
Matplotlib library
</a>
--> Used to generate graphs and visual plots such as sequence length distributions, conservation plots, and heatmaps.
</li>

<br>

<li>
<a href="https://biopython.org/" target="_blank">
Biopython library
</a>
--> Used to process biological sequence data and perform calculations such as amino acid composition and sequence statistics.
</li>

</ul>

</div>



<div class="card">

<h3>AI Tools Used</h3>

<p>
AI tools were used during development to help with problem solving and debugging.
</p>

<ul>

<li>
<b>ChatGPT</b> was used to:
<ul>

<br>

<li>create the spinning loading animation while analysis runs</li>

<br>

<li>fix session handling issues and ensure the session ID remains stable across pages</li>

<br>

<li>debug PHP syntax errors and improve motif parsing logic</li>

<br>

<li>improve the clarity of text on the Help, About, and Read More pages</li>

<br>

<li>format the dataset export dropdown text</li>

<br>

<li>help position the footer so it stays at the bottom of the page</li>

<br>

<li>check that data is correctly passed between pages</li>

<br>

<li>suggest resources</li>

<br>

<li>clarify the reason behind errors such as: you ran a search for 1 sequence but alignment requires a minimum of 2 sequences</li>

<br>

<li>help plan and fix logical and syntax errors in the python files which generate the additional analyses</li>

<br>

<li>explain how to display an image on the webpage</li>

<br>

<li>suggest solutions for orientation issues in display in styles.php</li>

</ul>
</li>

<br>

<li>

<b>Google Gemini</b> was used to:
<ul>

<br>

<li>generate the website logo image</li>

<br>

<li>suggest creative name ideas for the website</li>

</ul>
</li>

</ul>

</div>



