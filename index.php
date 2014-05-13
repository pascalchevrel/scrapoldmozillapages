#!/usr/bin/env php
<?php

// Script should not be called from the Web
if (php_sapi_name() != 'cli') {
    die('Nope');
}

date_default_timezone_set('Europe/Paris');

require_once __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/functions.php';

define('CACHE', __DIR__ . '/cache/');
define('CACHE_EXPIRE', 60000);

$locales = [
'af', 'ar', 'as', 'ast', 'be', 'bg', 'bn-BD', 'bn-IN', 'ca', 'cs', 'cy', 'da',
'de', 'el', 'en-GB', 'eo', 'es-AR', 'es-CL', 'es-ES', 'es-MX', 'et', 'eu',
'fa', 'fi', 'fr', 'fy-NL', 'ga-IE', 'gd', 'gl', 'gu-IN', 'he', 'hi-IN', 'hr',
'hu', 'hy-AM', 'id', 'is', 'it', 'ka', 'kk', 'kn', 'ko', 'ku', 'lt', 'lv',
'mk', 'ml', 'mr', 'nb-NO', 'nl', 'nn-NO', 'oc', 'pa-IN', 'pl', 'pt-BR',
'pt-PT', 'rm', 'ro', 'ru', 'si', 'sk', 'sl', 'sq', 'sr', 'sv-SE', 'ta', 'te',
'th', 'tr', 'uk', 'vi', 'zh-CN'
];

// $locales = ['or', 'zh-TW'];
$english = getGeolocationStrings('en-GB');

// print '<ol>';

// foreach ($english as $string) {
//     print '<li>' . htmlspecialchars(mtrim($string)) . '</li>';

// }
// print '<ol>';

foreach ($locales as $locale) {
    print 'Treating locale '. $locale . '... ';
    $strings = getGeolocationStrings($locale);
    $dotlang = function() use ($strings, $english) {
        $lang_file = "## active ##\n";
        $lang_file .= "## NOTE: url is https://www.mozilla.org/firefox/geolocation/\n\n\n";
        foreach ($english as $key => $source) {
            if ($source == 'Frequently Asked Questions') {
                $source = 'Frequently asked Questions';
            }

            if ($source == 'For a complete description of information collected and used by Firefox, please see the <a href="%(url)s">Firefox Privacy Policy</a> (in English).') {
                $source = 'For a complete description of information collected and used by Firefox, please see the <a href="%(url)s">Firefox Privacy Notice</a>.';
            }

            if ($source == 'Google Location Services then returns your estimated geolocation (e.g., latitude and longitude). For a complete description of information collected and used by Google, please see the <a href="%(url)s" class="%(class)s">Google Geolocation Privacy Policy</a> (in English).') {
                $source  = 'Google Location Services then returns your estimated geolocation (e.g., latitude and longitude). For a complete description of information collected and used by Google, please see the <a href="%(url)s" class="%(class)s">Google Geolocation Privacy Policy</a>.';
            }


            if ($source == "For information about what the requesting website does with your location information, please refer to that website's privacy policy.") {
                $source  = 'For information about what the requesting website does with your location information, please refer to that website’s privacy policy.';
            }


            if ($source == 'Mozilla Firefox privacy policy') {
                $source  = 'Mozilla Firefox Privacy Notice';
            }

            if ($source == "Navigate to the site to which you've given permission") {
                $source  = 'Navigate to the site to which you’ve given permission';
            }



            $lang_file .= ';' . $source . "\n";
            if ($strings[$key] == 'identical to English') {
                $lang_file .= $source;
            } else {
                $lang_file .= $strings[$key];
            }
            $lang_file .= "\n\n\n";
        }

        return $lang_file;
    };


    fileForceContents(__DIR__ . '/locales/' . $locale . '/firefox/geolocation.lang', $dotlang());
    print "$locale done \n";
    unset($strings);
}
