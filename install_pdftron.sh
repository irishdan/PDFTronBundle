#!/bin/sh
# Assume cmake and swig, wget are not installed on the server already.
apt-get update
apt-get install -y swig cmake wget git

# get the wrappers repo
git clone https://github.com/irishdan/PDFNetWrappers

# Move to where we download PDFNet.
cd PDFNetWrappers/PDFNetC

# Download PDFNet.
wget http://www.pdftron.com/downloads/PDFNetC64.tar.gz

# Is better Unpack PDFNet.
tar xzvf PDFNetC64.tar.gz

# Move PDFNet Headers/ into place.
mv PDFNetC64/Headers/ .

# Move PDFNet Lib/ into place.
mv PDFNetC64/Lib/ .

# Go back up.
cd ..

# Create a directory to create the Makefiles in.
mkdir Build

# Move to that directory.
cd Build

# Create the Makefiles with CMake.
cmake -D BUILD_PDFNetPHP=ON ..

# Build the PHP wrappers with SWIG.
make

# Copy the PHP wrappers to suitable location
make install