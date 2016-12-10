# PDFTron integration

## Installation
 - To run the bash installation script run:
 sudo ./pdftron_install.sh

### Manual Installation
 - sudo apt-get install cmake
 - sudo apt-get install swig
 - git clone https://github.com/irishdan/PDFNetWrappers # Git the code.
 - cd PDFNetWrappers/PDFNetC # Move to where we download PDFNet.
 - wget http://www.pdftron.com/downloads/PDFNetC64.tar.gz # Download PDFNet.
 - sudo tar xzvf PDFNetC64.tar.gz # sudo is better Unpack PDFNet.
 - mv PDFNetC64/Headers/ . # Move PDFNet Headers/ into place.
 - mv PDFNetC64/Lib/ . # Move PDFNet Lib/ into place.
 - cd .. # Go back up.
 - mkdir Build # Create a directory to create the Makefiles in.
 - cd Build # Move to that directory.
 - cmake -D BUILD_PDFNetPHP=ON .. # Create the Makefiles with CMake.
 - make # Build the PHP wrappers with SWIG.
 - sudo make install # Copy the PHP wrappers to suitable location
 
### PHP.ini
 - At this point PDFNetPHP.so has been added to your php extensions directory. 
   But you need to add it to your php.ini.