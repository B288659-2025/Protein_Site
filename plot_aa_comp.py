import sys

# Source for matplotlip which is used for plotting: https://matplotlib.org/stable/api/_as_gen/matplotlib.pyplot.plot.html
import matplotlib.pyplot as plt
# Source for SeqIO from Biopython which is used to read a fasta file: https://biopython.org/wiki/SeqIO
from Bio import SeqIO

from collections import Counter
import matplotlib.cm as color_map
import numpy as np

# Get file names from the command line
# First input is the FASTA file and second input is the output image name
input_fasta_file = sys.argv[1]
output_image_file = sys.argv[2]

# Store all amino acids from all sequences
all_amino_acids = ""

# Read each sequence from the FASTA file and ddd every amino acid to one long string
for sequence_record in SeqIO.parse(input_fasta_file, "fasta"):
	all_amino_acids += str(sequence_record.seq)

# Count how many times each amino acid appears
amino_acid_counts = Counter(all_amino_acids)

# Get list of amino acid names
amino_acid_labels = list(amino_acid_counts.keys())

# Get list of frequencies
amino_acid_frequencies = list(amino_acid_counts.values())

# Create colors for each bar
bar_colors = color_map.tab20(np.linspace(0, 1, len(amino_acid_labels)))

# Create the figure window
plt.figure(figsize=(8, 5))

# Draw the bar chart
plt.bar(amino_acid_labels, amino_acid_frequencies, color=bar_colors)

# Add axis labels
plt.xlabel("Amino Acid")
plt.ylabel("Frequency")

# Add chart title
plt.title("Amino Acid Composition")

# Adjust spacing so labels fit
plt.tight_layout()

# Save the image file
plt.savefig(output_image_file)

# Close the figure to free memory
plt.close()
