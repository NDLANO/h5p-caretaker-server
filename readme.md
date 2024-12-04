# H5P Caretaker server reference implementation
PHP based reference implementation for a standalone server using the H5P Caretaker library
and the reference implementation for a JavaScript client providing the user interface.

Please note that while you can use this implementation as is, it is only supposed to give you an idea
about how the H5P Caretaker library can be used and how it can be hooked up to the H5P Careteker client
reference implementation - which itself is also only a reference.

## Installation
For now, you are required to be familiar with `composer` and `npm` in order to build the
server application.

 - Run `git clone git@github.com/ndlano/h5p-caretaker-server` to get the code for this server
 - Run `cd h5p-caretaker-server` in order to change into the downloaded directory.
 - Run `composer install` to install the latest version of the H5P Caretaker library.
 - Run `npm install` to install the latest version of the H5P Caretaker client.
 - Copy the `h5p-caretaker-server` directory to your webserver - it should now be usable in general.
 - Ensure that the `h5p-caretaker-server/uploads` folder can be written by your server to
   temporarily unpack H5P files that will be uploaded.
 - Ensure that the `h5p-caretaker-server/cache` folder can be written by your server to
   cache LibreText recommendations
