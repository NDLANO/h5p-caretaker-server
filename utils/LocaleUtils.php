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

/**
 * Locale utilities for the H5P Caretaker server.
 *
 * @category File
 * @package  H5PCaretakerServer
 * @author   Oliver Tacke <oliver@snordian.de>
 * @license  MIT License
 * @link     https://github.com/ndlano/h5p-caretaker
 */
class LocaleUtils
{
    private static $LOCALE_PATH = "lang";
    private static $DEFAULT_TEXT_DOMAIN = "h5p_caretaker_server";
    private static $DEFAULT_LOCALE = "en";
    private static $strings = [];
    private static $currentLocale = 'en';

    /**
     * Set the locale.
     *
     * @param string $locale The locale to set.
     *
     * @return string The current locale.
     */
    public static function setLocale($locale)
    {
        $langFile = join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'lang', $locale, 'strings.php']);

        if (!file_exists($langFile)) {
            $locale = explode("_", $locale)[0];
            $langFile = join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'lang', $locale, 'strings.php']);
        }

        if (file_exists($langFile)) {
            self::$currentLocale = $locale;
            include $langFile;
            self::$strings[self::$currentLocale] = $string;
        } else {
            self::$currentLocale = self::$DEFAULT_LOCALE;
        }

        return self::$currentLocale;
    }

    /**
     * Get a string by its identifier.
     *
     * @param string $identifier The identifier of the string.
     * @param string $specificLocale The locale to use. Optional.
     *
     * @return string The string.
     */
    public static function getString($identifier, $specificLocale = null)
    {
        if (!isset(self::$strings[self::$currentLocale])) {
            self::setLocale(self::$DEFAULT_LOCALE);
        }

        return self::$strings[$specificLocale ?? self::$currentLocale][$identifier] ??
            self::$strings[self::$DEFAULT_LOCALE][$identifier] ??
            $identifier;
    }

    /**
     * Get the complete (default) locale for a given language.
     *
     * @param string $language The language code.
     *
     * @return string The complete locale.
     */
    public static function getCompleteLocale($language)
    {
      // Define the mapping of short language codes to full locales
        $locales = [
          "af" => "af_ZA",
          "ar" => "ar_AE",
          "be" => "be_BY",
          "bg" => "bg_BG",
          "bn" => "bn_BD",
          "bs" => "bs_BA",
          "ca" => "ca_ES",
          "cs" => "cs_CZ",
          "cy" => "cy_GB",
          "da" => "da_DK",
          "de" => "de_DE",
          "el" => "el_GR",
          "en" => "en_US",
          "eo" => "eo",
          "es" => "es_ES",
          "et" => "et_EE",
          "eu" => "eu_ES",
          "fa" => "fa_IR",
          "fi" => "fi_FI",
          "fil" => "fil_PH",
          "fo" => "fo_FO",
          "fr" => "fr_FR",
          "ga" => "ga_IE",
          "gl" => "gl_ES",
          "gu" => "gu_IN",
          "he" => "he_IL",
          "hi" => "hi_IN",
          "hr" => "hr_HR",
          "hu" => "hu_HU",
          "hy" => "hy_AM",
          "id" => "id_ID",
          "is" => "is_IS",
          "it" => "it_IT",
          "ja" => "ja_JP",
          "ka" => "ka_GE",
          "kk" => "kk_KZ",
          "km" => "km_KH",
          "kn" => "kn_IN",
          "ko" => "ko_KR",
          "lt" => "lt_LT",
          "lv" => "lv_LV",
          "mk" => "mk_MK",
          "ml" => "ml_IN",
          "mn" => "mn_MN",
          "mr" => "mr_IN",
          "ms" => "ms_MY",
          "mt" => "mt_MT",
          "nb" => "nb_NO",
          "ne" => "ne_NP",
          "nl" => "nl_NL",
          "nn" => "nn_NO",
          "pa" => "pa_IN",
          "pl" => "pl_PL",
          "pt" => "pt_PT",
          "ro" => "ro_RO",
          "ru" => "ru_RU",
          "sk" => "sk_SK",
          "sl" => "sl_SI",
          "sq" => "sq_AL",
          "sr" => "sr_RS",
          "sv" => "sv_SE",
          "sw" => "sw_KE",
          "ta" => "ta_IN",
          "te" => "te_IN",
          "th" => "th_TH",
          "tr" => "tr_TR",
          "uk" => "uk_UA",
          "ur" => "ur_PK",
          "uz" => "uz_UZ",
          "vi" => "vi_VN",
          "zh" => "zh_CN",
          // Add more mappings if needed
        ];

        // Validate the input
        if (preg_match("/^[a-zA-Z]{2}_[a-zA-Z]{2}$/", $language)) {
            $split = explode("_", $language);
            $completeLocale = strtolower($split[0]) . "_" . strtoupper($split[1]);
        } elseif (preg_match("/^[a-zA-Z]{2}|fil|FIL$/", $language)) {
            $language = strtolower($language);

            if (isset($locales[$language])) {
                $completeLocale = $locales[$language];
            } else {
                $completeLocale = $language . "_" . strtoupper($language);
            }
        } else {
            return null;
        }

        return $completeLocale . ".UTF-8";
    }

    /**
     * Get the available locales.
     *
     * @return array The available locales.
     */
    public static function getAvailableLocales()
    {
        if (!is_dir(self::$LOCALE_PATH)) {
            return [self::$DEFAULT_LOCALE];
        }

        $foundlocales = array_filter(
            scandir(self::$LOCALE_PATH),
            function ($folder) {
                return is_dir(self::$LOCALE_PATH . DIRECTORY_SEPARATOR . $folder) &&
                    file_exists(
                        self::$LOCALE_PATH . DIRECTORY_SEPARATOR .
                            $folder . DIRECTORY_SEPARATOR .
                            'strings.php'
                    );
            }
        );

        return array_unique(array_merge([self::$DEFAULT_LOCALE], $foundlocales));
    }

    /**
     * Request a translation for a given locale.
     * If the locale is not available, the default locale is used.
     *
     * @param string $localeRequested The locale that could be served.
     */
    public static function requestTranslation($localeRequested)
    {
        $availableLocales = LocaleUtils::getAvailableLocales();

        if (!in_array($localeRequested, $availableLocales)) {
            $localeRequested = explode('_', $localeRequested)[0];
        }

        if (!in_array($localeRequested, $availableLocales)) {
            return self::$DEFAULT_LOCALE;
        }

        self::setLocale($localeRequested);

        return $localeRequested;
    }
}
