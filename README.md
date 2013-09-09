####################################################
Sitemap Module
####################################################

# Description
Easily create a user friendly sitemaps for your whole or parts of your website. Ideal for your users when they have created a page with several sub pages and want the parent page to show the available underlying pages.
Download source code

    It lets a user easily create a sitemap for the whole website.
    In a hierarchical website users often organise pages using subpages. They often do not include any information in the parent page, or fail to maintain the parent page properly. The sitemap module allows a user to quickly add a sitemap to such a parent page. The sitemap will be automatically updated with the information from the child pages.

Differences with Google Sitemaps

The sitemap generated with the Sitemap module is intended for visitors to your website and search engines.
Features

    Allows a sitemap to be create for any page in the website.
    Create a sitemap for a different section of the website (you can set the parent page to any site page).
    Set a maximum depth for the sitemap.
    User can select which page attributes to include.
    Allows for specification of separate stylesheet.
    Easy extend module with your own page attributes.


# Maintainer Contact
Marijn Kampf 
<marijn (at) exadium (dot) com>

# Sponsored by
Exadium Web Development and Online Marketing. Visit http://www.exadium.com for more information.

# Installation
Copy files in 'sitemap' folder to the root of your SilverStripe installation. Sitemap will be added to automatically to the Page class.

All you need to do is include $ShowSitemap in your templates. (For beginners add $ShowSitemap to themes/yourtheme/templates/Layout/Page.ss)
Or include shortcode [Sitemap] in your content. 
Still to do: Enable changing of settings through shortcode, currently settings from page on which Sitemap is included are used.

# Extending
This module is ready to be extended if you would like to add specific data to your sitemap entries templates.

Extend the Sitemap class and extend the prepareTemplateData() function with data specific to your requirements. 

# Requirements
SilverStripe minimum version 2.3.3.
Works with 2.4