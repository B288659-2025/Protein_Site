import sys
import matplotlib.pyplot as plt
from Bio import SeqIO

fasta_file = sys.argv[1]
output_png = sys.argv[2]

lengths = []

for record in SeqIO.parse(fasta_file, "fasta"):
    lengths.append(len(record.seq))

plt.hist(lengths, bins=10)

plt.xlabel("Sequence Length")
plt.ylabel("Number of sequences")
plt.title("Sequence Length Distribution")

plt.savefig(output_png)
