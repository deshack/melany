#!/bin/bash
# This script cleans Melany sources before each release.

# Save the version number in a variable for later use.
# List all git tags and sort them by version. Than get the last line.
version=$( git tag -l | sort -V | tail -1 )

# Remove all the development stuffs.
rm -rf .htaccess .directory .gitignore .git/ *.sublime* lib/bootstrap/.git lib/bootstrap/less/ less/

# Move out of the Melany directory, rename and copy it.
cd ..
mv melany/ melany-$version/
cp -r melany-$version melany

# Remove the clean script inside the copied directory and compress it.
rm melany/clean.sh
zip -r melany melany

# Rename the archive.
mv melany.zip melany-$version.zip

# Remove the melany and melany-$version directory.
rm -rf melany-$version/ melany
