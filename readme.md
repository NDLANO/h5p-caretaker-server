# H5P Caretaker
PHP based reference implementation for a standalone server using the H5P Caretaker library
and the reference implementation for a JavaScript client providing the user interface.

## Installation
For now, you are required to be familiar with `composer` and `npm` in order to build the
server application.

 - Run `git clone git@github.com/ndlano/h5p-caretaker-server` to get the code for this server
 - Run `cd h5p-caretaker-server` in order to change into the downloaded directory.
 - Run `composer install` to install the latest version of the H5P Caretaker library.
 - Run `npm install` to install the latest version of the H5P Caretaker library.
 - Copy the `h5p-caretaker-server` directory to your webserver - it should now be usable in general.
 - Ensure that the `h5p-caretaker-server/uploads` folder can be written by your server to
   temporarily unpack H5P files that will be uploaded.
