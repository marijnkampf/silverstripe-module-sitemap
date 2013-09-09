<?php

/**
 * Dutch (Netherlands) language pack
 * @package Sitemap module
 * @subpackage i18n
 */

i18n::include_locale_file('cms', 'en_US');

global $lang;

if(array_key_exists('nl_NL', $lang) && is_array($lang['nl_NL'])) {
	$lang['nl_NL'] = array_merge($lang['en_US'], $lang['nl_NL']);
} else {
	$lang['nl_NL'] = $lang['en_US'];
}

// Output for class or file: OptionalTreeDropdownField
$lang['nl_NL']['OptionalTreeDropdownField']['NONE'] =
	'(Geen)';


$lang['nl_NL']['SitemapModule']['SITEMAP'] = array('Sitemap',  PR_HIGH, 'Tab name');
$lang['nl_NL']['SitemapModule']['INCLUDESITEMAP'] = "Toon Sitemap op deze pagina";

$lang['nl_NL']['SitemapModule']['BASEPAGE'] = "Basis pagina";
$lang['nl_NL']['SitemapModule']['DEPTH'] = "Diepte (0 = ongelimiteerd)";
$lang['nl_NL']['SitemapModule']['SHOWPAGENAME'] = "Toon paginanaam";
$lang['nl_NL']['SitemapModule']['SHOWMETATITLE'] = "Toon meta-titel";
$lang['nl_NL']['SitemapModule']['SHOWMETADESCRIPTION'] = "Toon meta-omschrijving";
$lang['nl_NL']['SitemapModule']['SHOWPAGETHUMB'] = "Toon pagina thumbnail";
$lang['nl_NL']['SitemapModule']['EXCLUDEPAGE'] = "Verberg deze pagina in de sitemap";
$lang['nl_NL']['SitemapModule']['STYLESHEET'] = "Stylesheet";