import sys
# Source for matplotlip which is used for plotting: https://matplotlib.org/stable/api/_as_gen/matplotlib.pyplot.plot.html
import matplotlib.pyplot as plt
# Source for SeqIO from Biopython which is used to read a fasta file: https://biopython.org/wiki/SeqIO
from Bio import SeqIO

# Get file names from the command line
# First input is the alignment file and second input is the output image name
input_alignment_file = sys.argv[1]
output_image_file = sys.argv[2]

# Read sequences from the FASTA file
sequence_records = list(SeqIO.parse(input_alignment_file, "fasta"))

# Stop if no sequences were found
if not sequence_records:
	print("No sequences found")
	sys.exit(1)

# Convert sequences into simple text strings
sequence_strings = [str(record.seq) for record in sequence_records]


# Find the shortest sequence length to  prevents errors if sequences are different sizes
shortest_length = min(len(seq) for seq in sequence_strings)

# Store conservation values for each position
conservation_scores = []

# Check each position in the alignment
for position_index in range(shortest_length):

	# Get all amino acids at this position
	column_residues = [seq[position_index] for seq in sequence_strings]

	# Find the most common amino acid
	most_common_residue = max(set(column_residues), key=column_residues.count)

	# Calculate conservation score
	conservation_value = column_residues.count(most_common_residue) / len(column_residues)

	# Save the score
	conservation_scores.append(conservation_value)


# Create the figure window
plt.figure()

# Draw the line plot
plt.plot(conservation_scores)

# Add axis labels
plt.xlabel("Alignment Position")
plt.ylabel("Conservation Score")

# Add chart title
plt.title("Residue Conservation")

# Adjust spacing so labels fit
plt.tight_layout()

# Save the image file
plt.savefig(output_image_file)

# Close the figure to free memory
plt.close()


