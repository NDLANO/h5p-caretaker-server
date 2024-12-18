<?php

namespace Ndlano\H5PCaretakerServer;

/**
 * Convert a human-readable size to bytes.
 *
 * @param string $size The human-readable size.
 */
function convertToBytes($size, $foo)
{
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
