import sys
import matplotlib.pyplot as plt
from Bio import SeqIO

alignment_file = sys.argv[1]
output_png = sys.argv[2]

# Read sequences using Biopython
records = list(SeqIO.parse(alignment_file, "fasta"))

if not records:
    print("No sequences found")
    sys.exit(1)

# Convert sequences to strings
seqs = [str(record.seq) for record in records]

# Use shortest sequence length for safety
length = min(len(s) for s in seqs)

conservation = []

for i in range(length):

    column = [s[i] for s in seqs]

    most_common = max(set(column), key=column.count)

    score = column.count(most_common) / len(column)

    conservation.append(score)

plt.figure()

plt.plot(conservation)

plt.xlabel("Alignment Position")
plt.ylabel("Conservation Score")
plt.title("Residue Conservation")

plt.tight_layout()

plt.savefig(output_png)

plt.close()

print("Plot generated successfully")
