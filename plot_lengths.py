# Import system module for command line arguments
import sys

# Import plotting library
# Source for matplotlib which is used for plotting: https://matplotlib.org/stable/api/_as_gen/matplotlib.pyplot.plot.html
import matplotlib.pyplot as plt

# Import SeqIO for reading FASTA files
# Source for SeqIO from Biopython which is used to read a fasta file: https://biopython.org/wiki/SeqIO
from Bio import SeqIO

# Import numpy for numerical operations
import numpy as np


# Get file names from the command line
# First input is the FASTA file and second input is the output image name
fasta_file = sys.argv[1]
output_png = sys.argv[2]


# Create empty list to store sequence lengths
lengths = []


# Loop through each sequence record in the FASTA file
# Calculate length of sequence and store it
for record in SeqIO.parse(fasta_file, "fasta"):
	lengths.append(len(record.seq))


# Create histogram of sequence lengths with 5 bins
counts, bins, patches = plt.hist(lengths, bins=5)


# Import color map module
# Source for matplotlib which is used for plotting: https://matplotlib.org/stable/api/_as_gen/matplotlib.pyplot.plot.html
import matplotlib.cm as cm


# Generate colors for histogram bars
colors = cm.rainbow(np.linspace(0, 1, len(patches)))


# Assign a color to each histogram bar
for patch, color in zip(patches, colors):

	# Set color of the bar
	patch.set_facecolor(color)


# Set label for x axis
plt.xlabel("Sequence Length")

# Set label for y axis
plt.ylabel("Number of sequences")

# Set title of the plot
plt.title("Sequence Length Distribution")


# Save plot to output file
plt.savefig(output_png)
