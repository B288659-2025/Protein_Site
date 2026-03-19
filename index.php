<?php

session_start();

echo "<h1 style='text-align:center;margin-top:30px;'>Protein Analysis Home Page</h1>";
require_once 'menu.php';
?>

<div style='background:white;padding:30px;border-radius:10px;max-width:600px;margin:40px auto;box-shadow:0 5px 15px rgba(0,0,0,0.1);'>
<h3>Select a Database :)</h3>

<!-- Example dataset -->

<form id="example_form" method = "POST" action = "seq.php">

<input type="hidden" name="example_dataset" value="1">

<button type="submit">
Use Example Dataset (Glucose-6-Phosphatase Aves)
</button>

</form>

<div style='height:40px'></div>

<!-- Custom dataset -->

<form id="analysis_form" method = "POST" action = "seq.php">

Protein family:<br>
<input type="text" name="protein" required><br><br>

Taxonomic group:<br>
<input type="text" name="taxon" required><br><br>

Maximum sequences:<br>
<input type="number" name="seq_max" value="30"><br><br>

<button type="submit">Run Analysis</button>

</form>
<div style='height:40px'></div>

</div>
<div id="results"></div>


</body>
</html>
