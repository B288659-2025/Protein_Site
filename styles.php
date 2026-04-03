<style>

/* Source: https://www.w3schools.com/css/default.asp */

/* buttons and forms */

.center-button {
    padding: 15px 25px;
    background: #5D6C7A;
    border-radius: 10px;
    border: 1px solid;
    font-size: 14px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    min-width: 240px;
}

.button-row {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 25px;
    margin-top: 30px;
    width: 100%;
}

.forgot-row {
    width: 100%;
    text-align: right;
    margin-top: -6px;
    margin-bottom: 14px;
}

.form-row {
    display: flex;
    align-content: center;
    margin-bottom: 12px;
}

.form-row label {
    width: 180px;
}

.login-card {
    display: inline-block;
    width: fit-content;
    max-width: 400px;
    padding: 15px;
    background: #5D6C7A;
    cursor: pointer;
    border-radius: 10px;
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


/* navigation and header */

.site-header {
    background-color: #2c3e50;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
}

.site-title {
    margin: 0;
    font-size: 34px;
}

.site-subtitle {
    margin-top: 6px;
    font-size: 14px;
    opacity: 0.85;
}

nav {
    background: #5D6C7A;
    padding: 10px 0px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

nav a {
    color: white;
    text-decoration: none;
    font-weight: 600;
}

.nav-left,
.nav-right {
    display: flex;
    gap: 18px;
}

.site-logo {
    height: 150px;
    width: auto;
}


/* layout and containers */

body {
    font-family: 'IBM Plex Sans', sans-serif;
    margin: 0;
    background: #E8E4E1;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

html, body {
    height: 100%;
    margin: 0;
}

.container {
    max-width: 1200px;
    margin: 10px auto;
    padding: 0 10px;
}

.page-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.section {
    max-width: 460px;
    margin: 60px auto;
    padding-top: 25px;
    border-top: 1px solid #ddd;
}

.dataset-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    max-width: 1000px;
    margin-left: auto;
    margin-right: auto;
}


/* cards */

.card {
    background: white;
    padding: 35px;
    border-radius: 10px;
    max-width: 800px;
    display: flex;
    flex-direction: column;
    margin: 20px auto;
    box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    flex: 0 0 auto;
    width: 100%;
    box-sizing: border-box;
}

.card img {
    width: 100%;
    height: auto;
    display: block;
}

.dash-card {
    background: white;
    padding: 35px;
    border-radius: 10px;
    max-width: 800px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin: 20px auto;
    box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    flex: 0 0 auto;
    width: 100%;
    box-sizing: border-box;
}

.dash-card form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.history-card {
    display: inline-block;
    width: 100%;
    padding: 30px;
    border: 2px solid #2c3e50;
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

.history-card:hover {
    background: #f5f7fa;
    transform: translateY(-2px);
}

.analysis-card {
    display: inline-block;
    width: 100%;
    padding: 30px;
    border: 2px solid #white;
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

.sequence-card {
    background: white;
    padding: 20px;
    margin-bottom: 19px;
    border-radius: 10px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
    font-size: 15px;
    margin-top: 15px;
    font-weight: 550;
    color: #A6361E;
}

.sequence-body {
    font-family: monospace;
    font-size: 15px;
    line-height: 1.4;
    background: #f5f7fa;
    padding: 12px;
    border-radius: 6px;
    color: #2c3e50;
    overflow-x: auto;
    white-space: pre-wrap;
    word-break: break-word;
}


/* tables and text */

textarea {
    resize: none;
}

.info-text {
    text-align: center;
    margin: 15px auto 20px auto;
    max-width: 700px;
    color: #555;
    font-size: 15px;
}

.motif-table {
    margin: 0 auto;
    border-collapse: collapse;
    width: 100%;
}

.motif-table th,
.motif-table td {
    border: 1px solid #ccc;
    padding: 10px;
}

.motif-table th {
    background-color: #f2f2f2;
}

.section-title {
    font-weight: bold;
    margin-top: 20px;
    font-family: 'IBM Plex Sans', sans-serif;
    font-size: 24px;
    margin-bottom: 0px;
    padding-bottom: 0px;
    color: #2c3e50;
    text-align: center;
    padding: 10px 0px 0px 0px;
}


/* stats */

.stats-card {
    width: 100%;
    padding: 0;
    background: transparent;
    box-shadow: none;
    border-radius: 0;
}

.stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
}

.stat-row:last-child {
    border-bottom: none;
}

.stat-row span {
    color: #374151;
    font-weight: 600;
}

.stat-row strong {
    color: #111827;
    font-size: 12px;
    font-weight: 500;
}


/* export dropdown */

.export-option {
    align-items: center;
    margin-bottom: 12px;
}

.export-option label {
    cursor: pointer;
    user-select: none;
}

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


/* spinner */

.spinner {
    border: 6px solid #f3f3f3;
    border-top: 6px solid #3498db;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    margin: 0 auto 20px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}


/* footer */

.footer {
    margin-top: auto;
    text-align: center;
    padding: 15px;
    background-color: #2c3e50;
    color: white;
    font-size: 14px;
    font-family: 'IBM Plex Sans', sans-serif;
}

</style>
