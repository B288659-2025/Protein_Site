import sys
import matplotlib.pyplot as plt
from collections import Counter
from Bio import SeqIO

fasta_file = sys.argv[1]
output_png = sys.argv[2]

all_residues = ""

for record in SeqIO.parse(fasta_file, "fasta"):
    all_residues += str(record.seq)

counts = Counter(all_residues)

plt.bar(counts.keys(), counts.values())

plt.xlabel("Amino Acid")
plt.ylabel("Frequency")
plt.title("Amino Acid Composition")

plt.savefig(output_png)
