import sys
from Bio import SeqIO
from Bio.SeqUtils import gc_fraction
import statistics

fasta_file = sys.argv[1]

lengths = []
total_gc = 0
total_bases = 0

for record in SeqIO.parse(fasta_file, "fasta"):

    seq = record.seq
    length = len(seq)

    lengths.append(length)

    total_gc += gc_fraction(seq) * length
    total_bases += length

count = len(lengths)

min_len = min(lengths)
max_len = max(lengths)

avg_len = round(statistics.mean(lengths), 2)
median_len = statistics.median(lengths)
std_dev = round(statistics.stdev(lengths), 2)

gc_percent = round((total_gc / total_bases) * 100, 2)

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
