<?php

/**
 * English (United Kingdom) language pack
 * @package Sitemap Module
 * @subpackage i18n
 */

i18n::include_locale_file('cms', 'en_US');

global $lang;

if(array_key_exists('en_GB', $lang) && is_array($lang['en_GB'])) {
	$lang['en_GB'] = array_merge($lang['en_US'], $lang['en_GB']);
} else {
	$lang['en_GB'] = $lang['en_US'];
}

// Output for class or file: OptionalTreeDropdownField
$lang['en_GB']['OptionalTreeDropdownField']['NONE'] =
	'(None)';

$lang['en_GB']['SitemapModule']['SITEMAP'] = array('Sitemap',  PR_HIGH, 'Tab name');
$lang['en_GB']['SitemapModule']['INCLUDESITEMAP'] = "Include a sitemap on this page";

$lang['en_GB']['SitemapModule']['BASEPAGE'] = "Base page";
$lang['en_GB']['SitemapModule']['DEPTH'] = "Depth (0 = unlimited)";
$lang['en_GB']['SitemapModule']['SHOWPAGENAME'] = "Show page name";
$lang['en_GB']['SitemapModule']['SHOWMETATITLE'] = "Show meta title";
$lang['en_GB']['SitemapModule']['SHOWMETADESCRIPTION'] = "Show meta description";
$lang['en_GB']['SitemapModule']['SHOWPAGETHUMB'] = "Show page thumbnail";
$lang['en_GB']['SitemapModule']['EXCLUDEPAGE'] = "Exclude this page from sitemap";
$lang['en_GB']['SitemapModule']['STYLESHEET'] = "Stylesheet";