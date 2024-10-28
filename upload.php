<?php
/**
 * Tool for helping people to take care of H5P content.
 *
 * PHP version 8
 *
 * @category Tool
 * @package  H5PCaretaker
 * @author   Oliver Tacke <oliver@snordian.de>
 * @license  MIT License
 * @link     https://todo
 */

require __DIR__ . '/vendor/autoload.php';
use Ndlano\H5PCaretaker\H5PCaretaker;

 /**
  * Convert a human-readable size to bytes.
  *
  * @param string $size The human-readable size.
  */
 function convertToBytes($size) {
    $unit = substr($size, -1);
    $value = (int)$size;

    switch (strtoupper($unit)) {
        case 'G':
            return $value * 1024 * 1024 * 1024;
        case 'M':
            return $value * 1024 * 1024;
        case 'K':
            return $value * 1024;
        default:
            return $value;
    }
}

/**
 * Exit the script with an optional HTTP status code.
 *
 * @param int    $code    The HTTP status code to send.
 * @param string $message The message to display.
 *
 * @return void
 */
function done($code, $message)
{
    if (isset($message)) {
        echo $message;
    }

    if (isset($code)) {
        http_response_code($code);
    };

    exit();
}

$maxFileSize = convertToBytes(min(ini_get('post_max_size'), ini_get('upload_max_filesize')));

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['file'])) {
    done(
        422,
        'It seems that no file was provided or it exceeds the file upload size limit of ' . $maxFileSize / 1024 . 'KB.'
    );
}

$file = $_FILES['file'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    done(500, 'Something went wrong with the file upload.');
}

if ($file['size'] > $maxFileSize) {
    done(413, 'The file is larger than the allowed maximum file size of ' . $maxFileSize / 1024 . 'KB.');
}

$config = [
    'uploadsPath' => './uploads',
    'cachePath' => './cache',
];

if (isset($_POST['locale'])) {
    $config['locale'] = $_POST['locale'];
}

$h5pCaretaker = new H5PCaretaker($config);

// TODO add an action parameter:
// - analyze (default)
// - write (with optional overwrite parameters)

$analysis = $h5pCaretaker->analyze(['file' => $file['tmp_name']]);

if (isset($analysis['error'])) {
    done(422, $analysis['error']);
}

done(200, $analysis['result']);
?>
