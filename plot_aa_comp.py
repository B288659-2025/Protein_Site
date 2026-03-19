import sys
import matplotlib.pyplot as plt
from collections import Counter

fasta_file = sys.argv[1]
output_png = sys.argv[2]

seq = ""
with open(fasta_file) as f:
    for line in f:
        if not line.startswith(">"):
            seq += line.strip()

counts = Counter(seq)

aa = list(counts.keys())
freq = list(counts.values())

plt.bar(aa, freq)

plt.xlabel("Amino Acid")
plt.ylabel("Frequency")
plt.title("Amino Acid Composition")

plt.savefig(output_png)
