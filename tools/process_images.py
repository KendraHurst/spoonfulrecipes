import subprocess
import argparse
from os.path import exists
import os
import re
from pathlib import Path

def crop_photo(photo, width, height, gravity, directory, ext, darken=False):
	if darken:
		subprocess.run([
			'convert', directory + '/' + photo,
			'-auto-orient',
			'-gravity', gravity,
			'-crop', str(width) + ':' + str(height) + '^',
			'-resize', str(width) + 'x' + str(height) + '!',
			'-fill',  'black',
			'-colorize', '40%',
			'-quality', '75',
			directory + '/sized/' + Path(photo).stem + ext
		])
	else:
		subprocess.run([
			'convert', directory + '/' + photo,
			'-auto-orient',
			'-gravity', gravity,
			'-crop', str(width) + ':' + str(height) + '^',
			'-resize', str(width) + 'x' + str(height) + '!',
			'-quality', '75',
			directory + '/sized/' + Path(photo).stem + ext
		])

def recipe_photos(folder):

	folder_structure = os.scandir(folder)

	if not os.path.exists(f"{folder}/sized"):
		os.mkdir("sized")

	for folder_item in folder_structure:

		if folder_item.is_file(follow_symlinks=False):

			stem_name = Path(folder_item).stem

			if stem_name == "main":
				crop_photo(folder_item.name, 1920, 1080, "center", folder, ".16x9.jpg")
				crop_photo(folder_item.name, 1920, 1080, "center", folder, ".16x9.webp")
				crop_photo(folder_item.name, 800, 600, "center", folder, ".4x3.jpg")
				crop_photo(folder_item.name, 800, 600, "center", folder, ".4x3.webp")
				crop_photo(folder_item.name, 800, 800, "center", folder, ".1x1.jpg")
				crop_photo(folder_item.name, 800, 800, "center", folder, ".1x1.webp")

				crop_photo(folder_item.name, 1920, 1080, "center", folder, ".bg.jpg", True)
				crop_photo(folder_item.name, 1920, 1080, "center", folder, ".bg.webp", True)
				crop_photo(folder_item.name, 800, 800, "center", folder, ".bg-sm.jpg", True)
				crop_photo(folder_item.name, 800, 800, "center", folder, ".bg-sm.webp", True)

			elif re.match(r"image-.", stem_name):
				crop_photo(folder_item.name, 800, 600, "center", folder, ".jpg")
				crop_photo(folder_item.name, 800, 600, "center", folder, ".webp")

if __name__ == "__main__":
	parser = argparse.ArgumentParser()

	parser.add_argument("path", type=str,
		help="The path to the recipe folder whose images should be processed"
	);
	args = parser.parse_args()

	recipe_path = args.path

	recipe_photos(recipe_path)
