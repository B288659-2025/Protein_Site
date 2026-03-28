<?php

session_start();

require_once 'menu.php';
?>

<!-- <div style='background:white;padding:30px;border-radius:10px;max-width:600px;margin:40px auto;box-shadow:0 5px 15px rgba(0,0,0,0.1);'> -->
<div style='background:white;padding:30px;border-radius:10px;max-width:600px;max-height:550px;margin:40px auto;box-shadow:0 5px 15px rgba(0,0,0,0.1);font-size:18px;'>
<h3>Select a Database :)</h3>

<!-- Use Example Dataset -->

<form id="example_form" method = "POST" action = "seq.php">

<input type="hidden" name="example_dataset" value="1">

<button type="submit">
Use Example Dataset (Glucose-6-Phosphatase Aves)
</button>

</form>

<div style='height:40px'></div>

<!-- Run Custom Search -->

<form id="analysis_form" method = "POST" action = "seq.php">

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
<input type="checkbox" name="manual_curated">
Manual curated only
</label>
<br>

<label>
<input type="checkbox" name="exclude_fragments">
Exclude fragments
</label>

<br><br>

<button type="submit">Run Analysis</button>

</form>
<div style='height:40px'></div>

</div>
<div id="results"></div>


</body>
</html>
