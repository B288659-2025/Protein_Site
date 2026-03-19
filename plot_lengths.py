import sys
import matplotlib.pyplot as plt

fasta_file = sys.argv[1]
output_png = sys.argv[2]

lengths = []

with open(fasta_file) as f:
    seq = ""
    for line in f:
        line = line.strip()
        if line.startswith(">"):
            if seq:
                lengths.append(len(seq))
                seq = ""
        else:
            seq += line
    if seq:
        lengths.append(len(seq))

plt.hist(lengths, bins=10)
plt.xlabel("Sequence length (aa)")
plt.ylabel("Number of sequences")
plt.title("Sequence length distribution")

plt.savefig(output_png)
