import sys
import matplotlib.pyplot as plt
from Bio import SeqIO
import numpy as np

fasta_file = sys.argv[1]
output_png = sys.argv[2]

lengths = []

for record in SeqIO.parse(fasta_file, "fasta"):
    lengths.append(len(record.seq))

counts, bins, patches = plt.hist(lengths, bins=10)

import matplotlib.cm as cm

colors = cm.rainbow(np.linspace(0, 1, len(patches)))

for patch, color in zip(patches, colors):
    patch.set_facecolor(color)

plt.xlabel("Sequence Length")
plt.ylabel("Number of sequences")
plt.title("Sequence Length Distribution")

plt.savefig(output_png)
