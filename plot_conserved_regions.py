import sys

# Source for matplotlip which is used for plotting: https://matplotlib.org/stable/api/_as_gen/matplotlib.pyplot.plot.html
import matplotlib.pyplot as plt
# Source for SeqIO from Biopython which is used to read a fasta file: https://biopython.org/wiki/SeqIO
from Bio import SeqIO
from collections import Counter

# Get file names from the command line
# First input is the FASTA file and second input is the output image name
input_fasta_file = sys.argv[1]
output_fasta_file = sys.argv[2]

# Store all sequences
all_sequences = []

# Read sequences from the FASTA file
for record in SeqIO.parse(input_fasta_file, "fasta"):
	all_sequences.append(str(record.seq))

# Stop the program if no sequences were found
if len(all_sequences) == 0:
	print("No sequences found")
	sys.exit(1)

# Get length of the first sequence. We assume alignment positions are based on this length
first_sequence_length = len(all_sequences[0])

# Store conservation values for each position
position_conservation_scores = []

# Check each position in the alignment
for alignment_position in range(first_sequence_length):

	# Store amino acids at this position
	residues_in_column = []

	for current_sequence in all_sequences:
		if alignment_position < len(current_sequence):
			residues_in_column.append(current_sequence[alignment_position])

	# Count how many times each amino acid appears
	residue_frequency_counts = Counter(residues_in_column)

	# Find the most common amino acid count
	highest_residue_count = residue_frequency_counts.most_common(1)[0][1]

	# Calculate conservation score
	conservation_score = highest_residue_count / len(all_sequences)

	# Save the score
	position_conservation_scores.append(conservation_score)

# Create the figure window
plt.figure(figsize=(12, 4))

# Draw the line plot
plt.plot(position_conservation_scores, linewidth=2)

# Add axis labels
plt.xlabel("Position")
plt.ylabel("Conservation")

# Add chart title
plt.title("Conserved Regions")

# Adjust spacing so labels fit
plt.tight_layout()

# Save the image file
plt.savefig(output_fasta_file)

# Close the figure to free memory
plt.close()
