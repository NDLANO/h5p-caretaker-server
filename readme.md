# H5P Caretaker server reference implementation
PHP based reference implementation for a standalone server using the H5P Caretaker library and the reference implementation for a JavaScript client providing the user interface.

Please note that while you can use this implementation as is, it is only supposed to give you an idea about how the H5P Caretaker library can be used and how it can be hooked up to the H5P Careteker client reference implementation - which itself is also only a reference.

## Installation
You are required to be familiar with `composer` and `npm` in order to build the server application.

 - Run `git clone git@github.com/ndlano/h5p-caretaker-server` to get the code for this server
 - Run `cd h5p-caretaker-server` in order to change into the downloaded directory.
 - Run `composer install` to install the latest version of the H5P Caretaker library.
 - Run `npm install` to install the latest version of the H5P Caretaker client.
 - Copy the `h5p-caretaker-server` directory to your webserver - it should now be usable in general.
   Ensure to not copy the .git folder - it's not required and in general should never be put on servers for security reasons.
 - Ensure that the `h5p-caretaker-server/uploads` folder can be written by your server to
   temporarily unpack H5P files that will be uploaded.
 - Ensure that the `h5p-caretaker-server/cache` folder can be written by your server to
   cache LibreText recommendations

## Details
This server reference implementation integrates a server-side library (https://github.com/ndlano/h5p-caretaker) with a client for the browser (https://github.com/ndlano/h5p-caretaker-client).

The reference implementation essentially only manages available translations, starts up the client, handles the upload of an H5P file and passes it to the server-side library and sends the request back to the client.

Since it is only a reference implementation, while fully working, it is meant to be implemented in a larger context. For instance, there's a [H5P Caretaker WordPress plugin](https://github.com/ndlano/wp-ndla-h5p-caretaker) that offers the same functionality in a more convenient way.

## Future Development
This reference implementation will be changed as required, e.g. for writing to files.
