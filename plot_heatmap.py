import matplotlib
matplotlib.use("Agg")

import sys
import matplotlib.pyplot as plt
import numpy as np
from Bio import SeqIO

fasta_file = sys.argv[1]
output_png = sys.argv[2]

sequences = []

for record in SeqIO.parse(fasta_file, "fasta"):
    sequences.append(str(record.seq))

if len(sequences) == 0:
    print("No sequences found")
    sys.exit(1)

seq_length = len(sequences[0])

amino_acids = list("ACDEFGHIKLMNPQRSTVWY")

matrix = []

for aa in amino_acids:
    row = []

    for i in range(seq_length):
        count = 0

        for seq in sequences:
            if i < len(seq) and seq[i] == aa:
                count += 1

        frequency = count / len(sequences)
        row.append(frequency)

    matrix.append(row)

matrix = np.array(matrix)

plt.figure(figsize=(12, 6))

plt.imshow(
    matrix,
    aspect="auto",
    interpolation="nearest"
)

plt.colorbar(label="Frequency")

plt.xlabel("Position")
plt.ylabel("Amino Acid")
plt.title("Sequence Conservation Heatmap")

plt.yticks(
    np.arange(len(amino_acids)),
    amino_acids
)

plt.tight_layout()

plt.savefig(output_png)

plt.close()
