import csv

filename = "training_dataset.csv"  # Replace with the name of your CSV file
my_array = []

try:
    with open(filename, "r") as file:
        csv_reader = csv.reader(file)
        for row in csv_reader:
            my_array.append(row[7])

        my_array = set(my_array)

        print(my_array)
except FileNotFoundError:
    print(f"Error: File '{filename}' not found.")
except IOError:
    print(f"Error: Failed to open file '{filename}'.")
