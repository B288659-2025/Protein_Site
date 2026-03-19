import sys
import matplotlib.pyplot as plt

alignment_file = sys.argv[1]
output_png = sys.argv[2]

seqs = []

with open(alignment_file) as f:
    seq = ""
    for line in f:
        line = line.strip()
        if line.startswith(">"):
            if seq:
                seqs.append(seq)
                seq = ""
        else:
            seq += line
    if seq:
        seqs.append(seq)

length = len(seqs[0])
conservation = []

for i in range(length):
    column = [s[i] for s in seqs if i < len(s)]
    most_common = max(set(column), key=column.count)
    score = column.count(most_common) / len(column)
    conservation.append(score)

plt.plot(conservation)
plt.xlabel("Alignment Position")
plt.ylabel("Conservation Score")
plt.title("Residue Conservation")

plt.savefig(output_png)
