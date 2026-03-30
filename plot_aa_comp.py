import sys
import matplotlib.pyplot as plt
from collections import Counter
from Bio import SeqIO
import matplotlib.cm as cm
import numpy as np

fasta_file = sys.argv[1]
output_png = sys.argv[2]

all_residues = ""

for record in SeqIO.parse(fasta_file, "fasta"):
    all_residues += str(record.seq)

counts = Counter(all_residues)

amino_acids = list(counts.keys())
frequencies = list(counts.values())

colors = cm.tab20(np.linspace(0, 1, len(amino_acids)))

plt.figure(figsize=(8, 5))

plt.bar(
    amino_acids,
    frequencies,
    color=colors
)

plt.xlabel("Amino Acid")
plt.ylabel("Frequency")
plt.title("Amino Acid Composition")

plt.tight_layout()

plt.savefig(output_png)

plt.close()
