# Import system module for command line arguments
import sys

# Import plotting library
# Source for matplotlib which is used for plotting: https://matplotlib.org/stable/api/_as_gen/matplotlib.pyplot.plot.html
import matplotlib.pyplot as plt

# Import numpy for numerical operations
import numpy as np

# Import SeqIO for reading FASTA files
# Source for SeqIO from Biopython which is used to read a fasta file: https://biopython.org/wiki/SeqIO
from Bio import SeqIO

# Get file names from the command line
# First input is the FASTA file and second input is the output image name
fasta_file = sys.argv[1]
output_png = sys.argv[2]

# Create empty list to store sequences
sequences = []

# Loop through each sequence record in the FASTA file
# Convert sequence to string and store it
for record in SeqIO.parse(fasta_file, "fasta"):
	sequences.append(str(record.seq))

# Check if no sequences were found
if len(sequences) == 0:

	# Print error message
	print("No sequences found")

	# Exit the program
	sys.exit(1)

# Get length of the first sequence
seq_length = len(sequences[0])

# Create list of amino acid symbols
amino_acids = list("ACDEFGHIKLMNPQRSTVWY")

# Create empty list to store frequency matrix
matrix = []

# Loop through each amino acid
for aa in amino_acids:

	# Create empty list to store row values
	row = []

	# Loop through each sequence position
	for i in range(seq_length):

		# Set counter to zero
		count = 0

		# Loop through each sequence
		for seq in sequences:

			# Check if amino acid matches at this position
			if i < len(seq) and seq[i] == aa:

				# Increase counter
				count += 1

		# Calculate frequency of amino acid at this position
		frequency = count / len(sequences)

		# Add frequency to row
		row.append(frequency)

	# Add row to matrix
	matrix.append(row)

# Convert matrix list to numpy array
matrix = np.array(matrix)

# Create the figure window
plt.figure(figsize=(12, 6))

# Display matrix as heatmap
plt.imshow(
	matrix,
	aspect="auto",
	interpolation="nearest"
)

# Add color scale bar
plt.colorbar(label="Frequency")

# Set label for x axis
plt.xlabel("Position")

# Set label for y axis
plt.ylabel("Amino Acid")

# Set title of the plot
plt.title("Sequence Conservation Heatmap")

# Set y axis tick positions and labels
plt.yticks(
	np.arange(len(amino_acids)),
	amino_acids
)

# Adjust spacing so labels fit
plt.tight_layout()

# Save plot to output file
plt.savefig(output_png)

# Close the figure to free memory
plt.close()
