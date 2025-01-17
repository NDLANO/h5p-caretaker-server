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

// Set the language based on the browser's language
$locale = LocaleUtils::requestTranslation(
    $_GET['locale'] ?? locale_accept_from_http($_SERVER["HTTP_ACCEPT_LANGUAGE"])
);

$distFolder = './node_modules/h5p-caretaker-client/dist';

$distJS = basename(glob($distFolder . '/h5p-caretaker-client-*.js')[0] ?? '');
$distCSS = basename(glob($distFolder . '/h5p-caretaker-client-*.css')[0] ?? '');
?>

<!DOCTYPE html>
<html lang="<?php str_replace("_", "-", $locale) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo LocaleUtils::getString('site:title') ?></title>
  <link rel="stylesheet" href="node_modules/h5p-caretaker-client/dist/<?php echo $distCSS; ?>" />
  <script type="module" src="node_modules/h5p-caretaker-client/dist/<?php echo $distJS; ?>"></script>
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
            echo "<option value=\"$availableLocale\" $selected>" . $nativeName . "</option>";
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
          expandAllMessages: "<?php echo LocaleUtils::getString('expand:expandAllMessages') ?>",
          collapseAllMessages: "<?php echo LocaleUtils::getString('expand:collapseAllMessages') ?>",
          reportTitleTemplate: "<?php echo LocaleUtils::getString('report:titleTemplate') ?>",
        },
      });
    });
  </script>

</body>
</html>
