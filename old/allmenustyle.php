<?php
// menu.php
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;600&display=swap" rel="stylesheet">

<style>

body{
    font-family: 'IBM Plex Sans', sans-serif;
    background:#D0D5DB;
    margin:0;
}

.site-header{
    background:#2c3e50;
    color:white;
    text-align:center;
    padding:25px 20px 15px 20px;
}

.site-title{
    margin:0;
    font-size:34px;
}

.site-subtitle{
    margin-top:6px;
    font-size:14px;
    opacity:0.85;
}

nav{
    margin-top:15px;
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:20px;
}

nav a{
    color:white;
    text-decoration:none;
    font-weight:600;
}

.fasta-container{
    margin-top:20px;
}

.sequence-card{
    background:white;
    padding:18px;
    margin-bottom:16px;
    border-radius:10px;
    box-shadow:0 3px 8px rgba(0,0,0,0.08);
}

.sequence-header{
    font-weight:600;
    color:#2c3e50;
    margin-bottom:10px;
}

.sequence-body{
    font-family: monospace;
    font-size:14px;
    word-wrap: break-word;
    line-height:1.4;
    background:#f5f7fa;
    padding:12px;
    border-radius:6px;
}

.container{
    max-width:1200px;
    margin:40px auto;
    padding:0 20px;
}

</style>
</head>

<body>

<header class="site-header">

<h1 class="site-title">
Protalyze
</h1>

<p class="site-subtitle">
Protein Analysis Toolkit
</p>

<nav>
<a href="index.php">Home</a>
<a href="seq.php">Sequences</a>
<a href="align.php">Alignment</a>
<a href="motif.php">Motif Scan</a>
<a href="analysis.php">Analysis</a>
<a href="previous.php">History</a>
<a href="export.php">Export Results</a>
<a href="about.php">About</a>
<a href="help.php">Help</a>
<a href="read.php">Read More</a>
<a href="contact.php">Contact</a>
<a href="credits.php">Credits</a>
</nav>

</header>

<div class="container">
