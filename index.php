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

require_once __DIR__ . "/utils/LocaleUtils.php";

$DEFAULT_LOCALE_KEY = "locale";

function getFileByPattern($dir, $pattern)
{
    $files = glob($dir . DIRECTORY_SEPARATOR . $pattern);
    if (empty($files)) {
        return '';
    }

    $versioned_files = array();
    foreach ($files as $file) {
        $filename = basename($file);
        if (preg_match('/(\d+\.\d+\.\d+)/', $filename, $matches)) {
            $version                      = $matches[1];
            $versioned_files[ $filename ] = $version;
        }
    }

    arsort($versioned_files, SORT_NATURAL);

    return !empty($versioned_files) ? key($versioned_files) : basename($files[0] ?? '');
}

// Set the language based on the browser's language
$locale = LocaleUtils::requestTranslation(
    $_GET['locale'] ?? locale_accept_from_http($_SERVER["HTTP_ACCEPT_LANGUAGE"])
);

$distBase = './node_modules/@explorendla/h5p-caretaker-client/dist/@explorendla';
$distJS = getFileByPattern($distBase, 'h5p-caretaker-client-*.js');
$distCSS = getFileByPattern($distBase, 'h5p-caretaker-client-*.css');
?>

<!DOCTYPE html>
<html lang="<?php echo str_replace("_", "-", $locale); ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo LocaleUtils::getString('site:title'); ?></title>

  <!-- Using $distBase to avoid redundancy -->
  <link rel="stylesheet" href="<?php echo $distBase . '/' . $distCSS; ?>" />
  <script type="module" src="<?php echo $distBase . '/' . $distJS; ?>"></script>
</head>
<body class="h5p-caretaker">

  <header class="header">
    <h1 class="title main-color"><?php echo LocaleUtils::getString('h5pcaretaker'); ?></h1>
    <select
      class="select-language" name="language" id="select-language" data-locale-key=<?php echo $DEFAULT_LOCALE_KEY ?>
    >
      <?php
        $availableLocales = LocaleUtils::getAvailableLocales();
        $localesLookup = array_combine(
            $availableLocales,
            array_map('\Locale::getDisplayLanguage', $availableLocales, $availableLocales)
        );
        asort($localesLookup);

        foreach ($localesLookup as $availableLocale => $nativeName) {
            $selected = ($availableLocale === $locale) ? "selected" : "";
            $capitalizedNativeName = ucfirst($nativeName);
            echo "<option value=\"$availableLocale\" $selected>" . $capitalizedNativeName . "</option>";
        }
        ?>
    </select>
  </header>

  <main class="page">
      <div class="block background-dark">
        <div class="centered-row block-visible">
        <p class="main-color"><?php echo LocaleUtils::getString('headline') ?></p>
        <h2 class="title"><?php echo LocaleUtils::getString('callToAction') ?></h2>
        <p>
          <?php // phpcs:ignore Generic.Files.LineLength.TooLong ?>
          <?php echo LocaleUtils::getString('callToActionDetails') ?>
        </p>

        <div class="dropzone">
          <!-- Will be filled by dropzone.js -->
        </div>

      </div>
    </div>

    <div class="block background-dark">
      <div class="centered-row">
        <div class="filter-tree">
          <!-- Will be filled by content-filter.js -->
        </div>
    </div>
    </div>

    <div class="block background-light">
      <div class="output centered-row">
        <!-- Will be filled by main.js -->
      </div>
    </div>

  </main>

  <div class="branding">
    <span class="powered-by"></span><svg class="ndla-logo"></svg>
  <div/>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      new H5PCaretaker({
        endpoint: './upload.php',
        l10n: {
          selectYourLanguage: "<?php LocaleUtils::getString('languageSelect:a11ySelectLanguage') ?>",
          orDragTheFileHere: "<?php echo LocaleUtils::getString('dropzone:orDragTheFileHere') ?>",
          removeFile: "<?php echo LocaleUtils::getString('dropzone:removeFile') ?>",
          uploadProgress: "<?php echo LocaleUtils::getString('dropzone:uploadProgress') ?>",
          uploadYourH5Pfile: "<?php echo LocaleUtils::getString('dropzone:uploadH5PFile') ?>",
          yourFileIsBeingChecked: "<?php echo LocaleUtils::getString('dropzone:fileBeingChecked') ?>",
          yourFileWasCheckedSuccessfully: "<?php echo LocaleUtils::getString('dropzone:fileCheckedSuccessfully') ?>",
          instructions: "<?php echo LocaleUtils::getString('dropzone:instructions') ?>",
          allFilteredOut: "<?php LocaleUtils::getString('filter:allFilteredOut') ?>",
          contentFilter: "<?php echo LocaleUtils::getString('filter:contentFilter') ?>",
          showAll: "<?php echo LocaleUtils::getString('filter:showAll') ?>",
          showSelected: "<?php echo LocaleUtils::getString('filter:showSelected') ?>",
          showNone: "<?php echo LocaleUtils::getString('filter:showNone') ?>",
          filterByContent: "<?php echo LocaleUtils::getString('filter:filterByContent') ?>",
          reset: "<?php echo LocaleUtils::getString('filter:reset') ?>",
          totalMessages: "<?php echo LocaleUtils::getString('results:totalMessages') ?>",
          issues: "<?php echo LocaleUtils::getString('results:issues') ?>",
          results: "<?php echo LocaleUtils::getString('results:results') ?>",
          filterBy: "<?php echo LocaleUtils::getString('results:filterBy') ?>",
          groupBy: "<?php echo LocaleUtils::getString('results:groupBy') ?>",
          download: "<?php echo LocaleUtils::getString('results:download') ?>",
          downloadEditedH5P: "<?php echo LocaleUtils::getString('results:downloadEditedH5P') ?>",
          showDetails: "<?php echo LocaleUtils::getString('results:showDetails') ?>",
          hideDetails: "<?php echo LocaleUtils::getString('results:hideDetails') ?>",
          unknownError: "<?php echo LocaleUtils::getString('error:unknownError') ?>",
          checkServerLog: "<?php echo LocaleUtils::getString('error:checkServerLog') ?>",
          expandList: "<?php echo LocaleUtils::getString('filter:expandList') ?>",
          collapseList: "<?php echo LocaleUtils::getString('filter:collapseList') ?>",
          changeSortingGrouping: "<?php echo LocaleUtils::getString('results:changeSortingGrouping') ?>",
          previousMessage: "<?php echo LocaleUtils::getString('results:previousMessage') ?>",
          nextMessage: "<?php echo LocaleUtils::getString('results:nextMessage') ?>",
        },
      });
    });
  </script>

</body>
</html>
