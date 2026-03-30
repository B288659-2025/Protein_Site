import matplotlib
matplotlib.use("Agg")

import sys
import matplotlib.pyplot as plt
import numpy as np
from Bio import SeqIO
from collections import Counter

fasta_file = sys.argv[1]
output_png = sys.argv[2]

sequences = []

for record in SeqIO.parse(fasta_file, "fasta"):
    sequences.append(str(record.seq))

if len(sequences) == 0:
    print("No sequences found")
    sys.exit(1)

seq_length = len(sequences[0])

conservation_scores = []

for i in range(seq_length):

    column = []

    for seq in sequences:
        if i < len(seq):
            column.append(seq[i])

    counts = Counter(column)

    most_common = counts.most_common(1)[0][1]

    score = most_common / len(sequences)

    conservation_scores.append(score)

plt.figure(figsize=(12, 4))

plt.plot(
    conservation_scores,
    linewidth=2
)

plt.xlabel("Position")
plt.ylabel("Conservation")
plt.title("Conserved Regions")

plt.tight_layout()

plt.savefig(output_png)

plt.close()
