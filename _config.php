<?php

Object::add_extension('Page', 'Sitemap');

ShortcodeParser::get()->register('Sitemap',array('Sitemap','SitemapShortCodeHandler'));