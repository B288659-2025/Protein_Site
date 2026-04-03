<?php

session_start();

// Include navigation menu and database connection
require 'menu.php';
require 'db.php';

// Show page title
echo "<h2 class='section-title'>Search Page</h2>";

?>

<!-- Use card class for visualisation -->
<div class = "card">

<h3>Select a Database: </h3>

<!-- Form to use the example dataset -->

<form id="example_form" method="POST" action="seq.php">

<!-- Hidden value to tell the system to load example data -->
<input type="hidden" name="example_dataset" value="1">

<!-- Button to start example dataset -->
<button type="submit" class="login-card">
Use Example Dataset (Glucose-6-Phosphatase Aves)
</button>

</form>

<div style='height:40px'></div>

<!-- Form to run a custom analysis -->

<form id="analysis_form" method="POST" action="seq.php" onsubmit="showLoading()">

<div class="form-row">

    <!-- Input for protein family -->
    <label for="protein">Protein family:</label>

    <input
        type="text"
        id="protein"
        name="protein"
        list="protein_list"
        required
    >

    <!-- Suggested protein names. Datalist source: https://www.w3schools.com/tags/tag_datalist.asp  -->
    <datalist id="protein_list">
        <option value="glucose-6-phosphatase">
        <option value="cytochrome c">
        <option value="hemoglobin">
        <option value="insulin">
        <option value="kinase">
        <option value="ATP synthase">
        <option value="ABC transporter">
        <option value="adenylyl cyclase">

    </datalist>

</div>


<div class="form-row">

    <!-- Input for taxonomic group -->
    <label for="taxon">Taxonomic group:</label>

    <input
        type="text"
        id="taxon"
        name="taxon"
        list="taxon_list"
        required
    >

    <!-- Suggested taxonomic groups -->
    <datalist id="taxon_list">
        <option value="Aves">
        <option value="Mammalia">
        <option value="Rodentia">
        <option value="Primates">
        <option value="Vertebrata">
        <option value="Reptilia">
    </datalist>

</div>


<div class="form-row">

    <!-- Input for maximum number of sequences. For maximum sequences, by default set it to 25 to avoid heavy queries. Maximum number of sequences is set to 50, again, to avoid very heavy queries. -->
    <label for="seq_max">Sequences:</label>

    <input
        type="number"
        id="seq_max"
        name="seq_max"
        value="25"
	min = "1"
	max="50"
    >

</div>


<h4>Quality filters (optional)</h4>

<!-- Optional filter: remove partial sequences -->
<label>
<input type="checkbox" name="exclude_partial">
Exclude partial sequences
</label>

<br>

<!-- Optional filter: only manual curated sequences -->
<label>
<input type="checkbox" name="manual_only">
Manual curated only
</label>

<br>

<!-- Optional filter: remove fragments -->
<label>
<input type="checkbox" name="exclude_frag">
Exclude fragments
</label>

<br><br>

<!-- Button to start analysis -->
<button type="submit" class="login-card">
Run Analysis
</button>

</form>

<div style='height:40px'></div>

</div>


<!-- Area where results will be shown -->
<div id="results"></div>


<!-- Loading popup while analysis runs. Generated using ChatGPT -->
<div id="loadingPopup" style="
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
    z-index:9999;
">

    <div style="
        background:white;
        width:420px;
        padding:30px;
        border-radius:12px;
        text-align:center;
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%, -50%);
        box-shadow:0 8px 20px rgba(0,0,0,0.2);
        font-family:Arial;
    ">

        <!-- Spinner animation -->
        <div class="spinner"></div>

        <!-- Text that updates during processing -->
        <h2 id="progressText">
            Processing your request
        </h2>

    </div>

</div>


<script>

// Show loading popup when form is submitted. I thought of the idea but the implementation was generated using ChactGPT. 
function showLoading() {

    document.getElementById("loadingPopup").style.display = "block";

    // After 20 seconds show patience message
    setTimeout(function() {
        var el = document.getElementById("progressText");
        if (el) {
            el.innerText = "Thank you for your patience!";
        }
    }, 20000);

    // After 30 seconds show progress message
    setTimeout(function() {
        var el = document.getElementById("progressText");
        if (el) {
            el.innerText = "Almost there!";
        }
    }, 30000);

    // After 50 seconds show final message
    setTimeout(function() {
        var el = document.getElementById("progressText");
        if (el) {
            el.innerText = "Finalizing results :)";
        }
    }, 50000);

}

</script>

</body>
</html>
