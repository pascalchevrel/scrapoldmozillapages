<?php
use Sunra\PhpSimple\HtmlDomParser;

function mtrim($string)
{
    $string = explode(' ', $string);
    $string = array_filter($string);
    $string = implode(' ', $string);

    return $string;
}

function getGeolocationStrings($locale)
{
    $file_name = 'https://www.mozilla.org/' . $locale . '/firefox/geolocation/';
    $html = HtmlDomParser::file_get_html(cacheUrl($file_name));

    $str = [];

    /* meta */
    if ($locale == 'vi') {
        $str[0] = "Định vị Địa lí trong Firefox";
    } else {
        $str[0] = $html->find("title", 0)->innertext;
    }

    /* header */
    $str[1] = $html->find("#main-feature h2", 0)->innertext;
    $str[2] = $html->find("#main-feature p", 0)->innertext;
    $str[2] = str_replace(
        '<a href="#geo-demo" id="try-geolocation" style="display:none">',
        '<a href="%(url)s" id="%(id)s" style="%(style)s">',
        $str[2]
    );

    $str[3] = $html->find("#main-content h3", 0)->innertext;

    /* What is Location-Aware Browsing? */
    $str[4] = $html->find("#main-content h4", 0)->innertext;
    $str[5] = $html->find("#main-content",0)->children(1)->find('p', 0)->innertext;
    $str[6] = $html->find("#main-content",0)->children(1)->find('p', 1)->innertext;
    $str[7] = $html->find("#main-content",0)->children(1)->find('p', 2)->innertext;

    /* How does it work? */
    $str[8] = $html->find("#main-content h4", 1)->innertext;
    $str[9] = $html->find("#main-content",0)->children(2)->find('p', 0)->innertext;
    $str[10] = $html->find("#main-content",0)->children(2)->find('p', 1)->innertext;
    if ($locale == 'si') {
        $str[11] = "identical to English";
    } else {
        $str[11] = $html->find("#main-content",0)->children(2)->find('p', 2)->innertext;
    }

    /* How accurate are the locations? */
    $str[12] = $html->find("#main-content h4", 2)->innertext;
    $str[13] = $html->find("#main-content",0)->children(3)->find('p', 0)->innertext;

    /* What information is being sent, and to whom? How is my privacy protected? */
    $str[14] = $html->find("#main-content h4", 3)->innertext;
    $str[15] = $html->find("#main-content",0)->children(4)->find('p', 0)->innertext;
    $str[16] = $html->find("#main-content",0)->children(4)->find('p', 1)->innertext;
    $str[17] = $html->find("#main-content",0)->children(4)->find('li', 0)->innertext;
    $str[18] = $html->find("#main-content",0)->children(4)->find('li', 1)->innertext;
    $str[19] = $html->find("#main-content",0)->children(4)->find('li', 2)->innertext;

    if ($locale == 'pt-BR') {
        $str[20] = "identical to English";
        $str[21] = $html->find("#main-content",0)->children(4)->find('p', 2)->innertext;
        $str[21] = str_replace(
            '<a href="http://www.google.com/privacy-lsf.html" class="external">',
            '<a href="{{ url }}" class="{{ class }}">',
            $str[21]
        );
        $str[22] = $html->find("#main-content",0)->children(4)->find('p', 3)->innertext;
        $str[23] = $html->find("#main-content",0)->children(4)->find('p', 4)->innertext;
        $str[24] = $html->find("#main-content",0)->children(4)->find('p', 5)->innertext;
        $str[25] = $html->find("#main-content",0)->children(4)->find('p', 6)->innertext;
    }

    if ($locale == 'cs') {
        $str[20] = $html->find("#main-content",0)->children(4)->find('p', 2)->innertext;
        $str[20] = preg_replace('/<a(.*?)href=(["\'])(.*?)\\2(.*?)>/i', '<a href="%(url)s">', $str[20]);

        $str[21] = $html->find("#main-content",0)->children(4)->find('p', 3)->innertext;
        $str[21] = str_replace(
            '<a href="http://www.google.com/privacy-lsf.html" class="external">',
            '<a href="{{ url }}" class="{{ class }}">',
            $str[21]
        );

        $str[22] = $html->find("#main-content",0)->children(4)->find('p', 4)->innertext;
        $str[23] = $html->find("#main-content",0)->children(4)->find('p', 5)->innertext;
        $str[24] = "identical to English";
        $str[25] = $html->find("#main-content",0)->children(4)->find('p', 6)->innertext;
    }

    if (! in_array($locale, ['cs', 'pt-BR'])) {
        $str[20] = $html->find("#main-content",0)->children(4)->find('p', 2)->innertext;
        $str[20] = preg_replace('/<a(.*?)href=(["\'])(.*?)\\2(.*?)>/i', '<a href="%(url)s">', $str[20]);

        $str[21] = $html->find("#main-content",0)->children(4)->find('p', 3)->innertext;
        $str[21] = str_replace(
            '<a href="http://www.google.com/privacy-lsf.html" class="external">',
            '<a href="%(url)s" class="%(class)s">',
            $str[21]
        );
        $str[22] = $html->find("#main-content",0)->children(4)->find('p', 4)->innertext;
        $str[23] = $html->find("#main-content",0)->children(4)->find('p', 5)->innertext;
        $str[24] = $html->find("#main-content",0)->children(4)->find('p', 6)->innertext;
        $str[25] = $html->find("#main-content",0)->children(4)->find('p', 7)->innertext;
    }

    $str[26] = $html->find("#main-content",0)->children(4)->find('li', 3)->find('a', 0)->innertext;
    $str[27] = $html->find("#main-content",0)->children(4)->find('li', 4)->find('a', 0)->innertext;

    /* Am I being tracked as I browse the web? */
    $str[28] = $html->find("#main-content h4", 4)->innertext;
    $str[29] = $html->find("#main-content",0)->children(5)->find('p', 0)->innertext;

    /* How do I undo a permission granted to a site? */
    $str[30] = $html->find("#main-content h4", 5)->innertext;
    $str[31] = $html->find("#main-content",0)->children(6)->find('p', 0)->innertext;
    $str[32] = $html->find("#main-content",0)->children(6)->find('li', 0)->innertext;
    $str[33] = $html->find("#main-content",0)->children(6)->find('li', 1)->innertext;
    $str[34] = $html->find("#main-content",0)->children(6)->find('li', 2)->innertext;
    $str[35] = $html->find("#main-content",0)->children(6)->find('li', 3)->innertext;

    /* How do I clear the “random client identification number”? */
    $str[36] = $html->find("#main-content h4", 6)->innertext;
    $str[37] = $html->find("#main-content",0)->children(7)->find('li', 0)->innertext;
    $str[38] = $html->find("#main-content",0)->children(7)->find('li', 1)->innertext;
    $str[39] = $html->find("#main-content",0)->children(7)->find('li', 2)->innertext;
    $str[40] = $html->find("#main-content",0)->children(7)->find('li', 3)->innertext;


    /* How do I turn off Location-Aware Browsing permanently? */
    $str[41] = $html->find("#main-content h4", 7)->innertext;
    if ($locale == 'uk') {
        $str[42] = "identical to English";
    } else {
        $str[42] = $html->find("#main-content",0)->children(8)->find('p', 0)->innertext;
    }

    $str[43] = $html->find("#main-content",0)->children(8)->find('li', 0)->innertext;
    $str[44] = $html->find("#main-content",0)->children(8)->find('li', 1)->innertext;
    $str[45] = $html->find("#main-content",0)->children(8)->find('li', 2)->innertext;
    $str[46] = $html->find("#main-content",0)->children(8)->find('li', 3)->innertext;

    /* map */
    $str[47] = $html->find("#locateButton", 0)->innertext;
    $str[48] = $html->find("#geodemo-error", 0)->innertext;

    $str = array_map('trim', $str);
    $str = array_map('mtrim', $str);
    return $str;
}

function cacheUrl($url, $time = CACHE_EXPIRE)
{
    $cache = CACHE . sha1($url) . '.cache';

    if (is_file($cache)) {
        $age = $_SERVER['REQUEST_TIME'] - filemtime($cache);
        if ($age < $time) {
            return $cache;
        }
    }

    $file = file_get_contents($url);
    file_put_contents($cache, $file);

    return $cache;
}


function fileForceContents($dir, $contents)
{
    $parts = explode('/', $dir);
    $file  = array_pop($parts);
    $dir   = '';

    foreach ($parts as $part) {
        if (! is_dir($dir .= "/{$part}")) {
            mkdir($dir);
        }
    }

    return file_put_contents("{$dir}/{$file}", $contents);
}
