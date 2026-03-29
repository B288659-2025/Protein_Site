<!DOCTYPE html>
<html>
<head>

<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;600&display=swap" rel="stylesheet">

<style>
.export-option select {
    appearance: none;
    background-color: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 6px 32px 6px 12px;
    font-size: 15px;
    color: #111827;
    cursor: pointer;
    transition: all 0.15s ease;
}

.export-option select:hover {
    border-color: #94a3b8;
    background-color: #f1f5f9;
}

.export-option select:focus {
    outline: none;
    border-color: #5f6b78;
    box-shadow: 0 0 0 3px rgba(95, 107, 120, 0.15);
}

.info-text
{
    text-align: center;
    margin: 15px auto 20px auto;
    max-width: 700px;
    color: #555;
    font-size: 15px;
}

.motif-table
{
    margin: 0 auto;
    border-collapse: collapse;
    width: 100%;
}

.motif-table th,
.motif-table td
{
    border: 1px solid #ccc;
    padding: 10px;
}

.motif-table th
{
    background-color: #f2f2f2;
}
.section-title {
    font-weight: bold;
    margin-top: 0px;
    font-family: 'IBM Plex Sans', sans-serif;
    font-size: 22px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    background:#2c3e50;
    color:white;
    text-align:center;
    padding:10px 0px 15px 0px;

}
.spinner {
    border:6px solid #f3f3f3;
    border-top:6px solid #3498db;
    border-radius:50%;
    width:60px;
    height:60px;
    margin:0 auto 20px;
    animation:spin 1s linear infinite;
}

@keyframes spin {
    0% { transform:rotate(0deg); }
    100% { transform:rotate(360deg); }
}
body{
    font-family: 'IBM Plex Sans', sans-serif;
    background:#D0D5DB;
    margin:0;
}

.site-header{
    background:#2c3e50;
    color:white;
    text-align:center;
    padding:25px 20px 0px 20px;
    border-bottom: 2px solid #525F6E;
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
    background:#525F6E;
    padding:10px 0;
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    border-bottom: 2px solid #525F6E;
    gap:20px;
}
nav a{
    color:white;
    text-decoration:none;
    font-weight:600;
}

.container{
    max-width:1200px;
    margin:40px auto;
    padding:0 20px;
}

.sequence-card{
    background:white;
    padding:18px;
    margin-bottom:16px;
    border-radius:10px;
    box-shadow:0 3px 8px rgba(0,0,0,0.08);
}

.sequence-body{
    font-family: monospace;
    font-size:14px;
    line-height:1.4;

    background:#f5f7fa;
    padding:12px;
    border-radius:6px;

    overflow-x: auto;
    white-space: pre-wrap;
    word-break: break-word;

}
.card {
    background: white;
    padding: 35px;
    border-radius: 10px;
    max-width: 800px;    
    display: flex;
    flex-direction: column;
    margin: 30px auto;
    box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    flex: 0 0 auto;
    width: 100%;
    box-sizing: border-box;

}
.card img
{
    width: 100%;
    height: auto;
   display: block;
}
.section {
    max-width: 460px;
    margin: 60px auto;
    padding-top: 25px;
    border-top: 1px solid #ddd;
}

.footer {
    margin-top: auto;
    text-align: center;
    padding: 15px;
    background-color: #525F6E;   
    color: white;
    font-size: 14px;
    font-family: 'IBM Plex Sans', sans-serif;

}

.dataset-grid
{
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-top: 24px;
    max-width: 1000px;
    margin-left: auto;
    margin-right: auto;
}
.history-card {

    display: block;
    width: 100%;
    padding: 30px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    background: white;
    cursor: pointer;
    text-align: left;
    font-size: 16px;
    box-shadow: 0 4x 10px rgba(0,0,0,0.06);
    transition: transform 0.15s ease,
                box-shadow 0.15s ease,
                background 0.15s ease;
}
.history-card:hover
{
    background: #f5f7fa;
    transform: translateY(-2px);
}

.history-title
{
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 6px;
}

.history-meta
{
    font-size: 14px;
    color: #666;
}

.history-time
{
    font-size: 12px;
    color: #999;
    margin-top: 6px;
}
html, body {
    height: 100%;
    margin: 0;
}

body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.page-content {
    flex: 1;
    display: flex;
    flex-direction: column; 
}

.stats-card
{
    width: 100%;
    padding: 0;
    background: transparent;
    box-shadow: none;
    border-radius: 0;
}
.stat-row
{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
}

.stat-row:last-child
{
    border-bottom: none;
}

.stat-row span
{
    color: #374151;
    font-weight: 600;
}

.stat-row strong
{
    color: #111827;
    font-size: 12px;
    font-weight: 500;
}
.login-card {

    display: block;
    width: auto;
    padding: 15px;
    background: #5D6C7A;
    cursor: pointer;
    border-radius:10px;
    border: 1px solid;
    text-align: left;
    font-size: 12px;
    color: white;
    font-weight: bold;
}
input[type="checkbox"] {
    accent-color: #5f6b78; 
    width: 18px;
    height: 18px;
    cursor: pointer;
}

label {
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.export-option {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
}

.export-option label {
    cursor: pointer;
    user-select: none;
}
</style>

</head>
<body>
