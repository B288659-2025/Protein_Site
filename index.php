<?php

session_start();

require_once 'menu.php';
echo "<h2 class='section-title'>Search Page</h2>";

?>

<div class = "card">
<h3>Select a Database :)</h3>

<!-- Use Example Dataset -->

<form id="example_form" method = "POST" action = "seq.php">

<input type="hidden" name="example_dataset" value="1">

<button type="submit" class="login-card">
Use Example Dataset (Glucose-6-Phosphatase Aves)
</button>

</form>

<div style='height:40px'></div>

<!-- Run Custom Search -->

<form id="analysis_form" method="POST" action="seq.php" onsubmit="showLoading()">
Protein family:<br>
<input type="text" name="protein" required><br><br>

Taxonomic group:<br>
<input type="text" name="taxon" required><br><br>

Maximum sequences:<br>
<input type="number" name="seq_max" value="30"><br><br>

<h4>Quality filters (optional)</h4>

<label>
<input type="checkbox" name="exclude_partial">
Exclude partial sequences
</label>
<br>

<label>
<input type="checkbox" name="manual_only">
Manual curated only
</label>
<br>

<label>
<input type="checkbox" name="exclude_frag">
Exclude fragments
</label>

<br><br>

<button type="submit" class="login-card">Run Analysis</button>

</form>
<div style='height:40px'></div>

</div>
<div id="results"></div>

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

        <div class="spinner"></div>

        <h2 id="progressText">Processing your request</h2>
    </div>

</div>
<script>

function showLoading() {

    document.getElementById("loadingPopup").style.display = "block";

    // after 10 seconds
    setTimeout(function() {
        var el = document.getElementById("progressText");
        if (el) {
            el.innerText = "Thank you for your patience! This analysis is processing a large dataset.";
        }
    }, 20000);

    setTimeout(function() {
        var el = document.getElementById("progressText");
        if (el) {
            el.innerText = "Almost there!";
        }
    }, 30000);
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
