<?php

/**
 * Reference server for the H5P Caretaker library.
 *
 * PHP version 8
 *
 * @category Tool
 * @package  H5PCaretakerServer
 * @author   Oliver Tacke <oliver@snordian.de>
 * @license  MIT License
 * @link     https://github.com/ndlano/h5p-caretaker-server
 */

namespace Ndlano\H5PCaretakerServer;

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/utils/LocaleUtils.php';

use Ndlano\H5PCaretaker\H5PCaretaker;

$maxFileSize = convertToBytes(min(ini_get('post_max_size'), ini_get('upload_max_filesize')));

if (! isset($_SERVER['REQUEST_METHOD']) || 'POST' !== $_SERVER['REQUEST_METHOD']) {
    done(405, LocaleUtils::getString('error:methodNotAllowed'));
}

if (!isset($_FILES['file'])) {
    done(
        422,
        sprintf(
            LocaleUtils::getString('error:noFileOrTooLarge'),
            $maxFileSize / 1024
        )
    );
}

$file = $_FILES['file'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    done(500, LocaleUtils::getString('error:unknownError'));
}

if ($file['size'] > $maxFileSize) {
    done(
        413,
        sprintf(
            LocaleUtils::getString('error:fileTooLarge'),
            $maxFileSize / 1024
        )
    );
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
