import sys

from Bio import SeqIO

# Import function to calculate GC fraction
from Bio.SeqUtils import gc_fraction

# Import statistics functions
import statistics

# Get the FASTA file name from command line
fasta_file = sys.argv[1]

# Store sequence lengths
lengths = []

# Store total GC count
total_gc = 0

# Store total number of bases
total_bases = 0

# Read each sequence in the FASTA file
for record in SeqIO.parse(fasta_file, "fasta"):

	# Get the sequence
	seq = record.seq

	# Get sequence length and apped to list
	length = len(seq)
	lengths.append(length)

	# Add GC amount for this sequence
	total_gc += gc_fraction(seq) * length

	# Add sequence length to total bases
	total_bases += length


# Count number of sequences
count = len(lengths)

# Find shortest and longest sequence length
min_len = min(lengths)
max_len = max(lengths)

# Calculate average sequence length
avg_len = round(statistics.mean(lengths), 2)

# Calculate median sequence length
median_len = statistics.median(lengths)

# Calculate standard deviation of lengths
std_dev = round(statistics.stdev(lengths), 2)

# Calculate overall GC percentage
gc_percent = round((total_gc / total_bases) * 100, 2)

# Print results as HTML to display on webpage

# Use the stat-row class for the design
# Strong makes the value bold. Source: https://www.w3schools.com/tags/tag_strong.asp
# Span shows the label text and makes it easier to style with CSS. Source: https://www.w3schools.com/tags/tag_span.asp

print(f"""
<div class='stats-card'>

<div class='stat-row'>
<span>Number of sequences</span>
<strong>{count}</strong>
</div>

<div class='stat-row'>
<span>Total residues</span>
<strong>{total_bases}</strong>
</div>

<div class='stat-row'>
<span>Shortest sequence</span>
<strong>{min_len}</strong>
</div>

<div class='stat-row'>
<span>Longest sequence</span>
<strong>{max_len}</strong>
</div>

<div class='stat-row'>
<span>Average length</span>
<strong>{avg_len}</strong>
</div>

<div class='stat-row'>
<span>Median length</span>
<strong>{median_len}</strong>
</div>

<div class='stat-row'>
<span>Standard deviation</span>
<strong>{std_dev}</strong>
</div>

<div class='stat-row'>
<span>GC content (%)</span>
<strong>{gc_percent}</strong>
</div>

</div>
""")
