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
  <title><?php echo _("H5P Caretaker Reference Implementation") ?></title>
  <link rel="stylesheet" href="node_modules/h5p-caretaker-client/dist/<?php echo $distCSS; ?>" />
  <script type="module" src="node_modules/h5p-caretaker-client/dist/<?php echo $distJS; ?>"></script>
</head>
<body class="h5p-caretaker">

  <header class="header">
    <h1 class="title main-color"><?php echo _("H5P Caretaker"); ?></h1>
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
        <p class="main-color"><?php echo _('Take care of your H5P') ?></p>
        <h2 class="title"><?php echo _("Check your H5P file for improvements") ?></h2>
        <p>
          <?php // phpcs:ignore Generic.Files.LineLength.TooLong ?>
          <?php echo _("Upload your H5P file and uncover accessibility issues, missing information and best practices that can help you improve your H5P content.") ?>
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
          orDragTheFileHere: "<?php echo _("or drag the file here") ?>",
          removeFile: "<?php echo _("Remove file") ?>",
          selectYourLanguage: "<?php echo _("Select your language") ?>",
          uploadProgress: "<?php echo _("Upload progress") ?>",
          uploadYourH5Pfile: "<?php echo _("Upload your H5P file") ?>",
          yourFileIsBeingChecked: "<?php echo _("Your file is being checked") ?>",
          yourFileWasCheckedSuccessfully: "<?php echo _("Your file was checked successfully") ?>",
          totalMessages: "<?php echo _("Total messages") ?>",
          issues: "<?php echo _("issues") ?>",
          results: "<?php echo _("results") ?>",
          filterBy: "<?php echo _("Filter by") ?>",
          groupBy: "<?php echo _("Group by") ?>",
          download: "<?php echo _("Download") ?>",
          expandAllMessages: "<?php echo _("Expand all messages") ?>",
          collapseAllMessages: "<?php echo _("Collapse all messages") ?>",
          allFilteredOut: "<?php echo _("All messages have been filtered out by content.") ?>",
          reportTitleTemplate: "<?php echo _("H5P Caretaker report for @title") ?>",
          contentFilter: "<?php echo _("Content type filter") ?>",
          showAll: "<?php echo _("Show all") ?>",
          showSelected: "<?php echo _("Various selected contents") ?>",
          showNone: "<?php echo _("Show none") ?>",
          filterByContent: "<?php echo _("Filter by content:") ?>",
          reset: "<?php echo _("Reset") ?>",
        },
      });
    });
  </script>

</body>
</html>
