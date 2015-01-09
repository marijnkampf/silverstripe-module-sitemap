<?php

class Sitemap extends DataExtension {
	private static $db = array(
		'IncludeSitemap' => 'Boolean',
		'BasePage' => 'Text',
		'Depth' => 'Int',
		'ShowPageName' => 'Boolean',
		'ShowPageMetaTitle' => 'Boolean',
		'ShowPageMetaDescription' => 'Boolean',
		'ShowPageThumbnail' => 'Boolean',
		'ShowSelf' => 'Boolean',
		'Stylesheet' => 'Text',
	);

	private static $defaults = array(
		'IncludeSitemap' => 0,
		'Depth' => 0,
		'ShowPageName' => 1,
		'ShowPageMetaTitle' => 0,
		'ShowPageMetaDescription' => 0,
		'ShowPageThumbnail' => 0,
		'ShowSelf' => 1,
	);

	public function updateCMSFields(FieldList $fields) {
		$fields->addFieldToTab("Root." . _t('SitemapModule.SITEMAP', 'Sitemap'), new CheckboxField("IncludeSitemap", _t('SitemapModule.INCLUDESITEMAP',"Include a sitemap on this page")));
		$fields->addFieldToTab("Root." . _t('SitemapModule.SITEMAP'), new TreeDropdownField('BasePage', _t('SitemapModule.BASEPAGE',"Base page"), 'SiteTree', 'URLSegment', 'MenuTitle'));
		$fields->addFieldToTab("Root." . _t('SitemapModule.SITEMAP'), new NumericField("Depth", _t('SitemapModule.DEPTH',"Depth (0 = unlimited)")));
		$fields->addFieldToTab("Root." . _t('SitemapModule.SITEMAP'), new CheckboxField("ShowPageName", _t('SitemapModule.SHOWPAGENAME',"Show page name")));
		$fields->addFieldToTab("Root." . _t('SitemapModule.SITEMAP'), new CheckboxField("ShowPageMetaTitle", _t('SitemapModule.SHOWMETATITLE',"Show meta title")));
		$fields->addFieldToTab("Root." . _t('SitemapModule.SITEMAP'), new CheckboxField("ShowPageMetaDescription", _t('SitemapModule.SHOWMETADESCRIPTION',"Show meta description")));
		$fields->addFieldToTab("Root." . _t('SitemapModule.SITEMAP'), new CheckboxField("ShowPageThumbnail", _t('SitemapModule.SHOWPAGETHUMB',"Show page thumbnail")));
		$fields->addFieldToTab("Root." . _t('SitemapModule.SITEMAP'), new CheckboxField("ShowSelf", _t('SitemapModule.EXCLUDEPAGE',"Exclude this page from sitemap")));
		$fields->addFieldToTab("Root." . _t('SitemapModule.SITEMAP'), new TextField("Stylesheet", _t('SitemapModule.STYLESHEET',"Stylesheet")));
	}

	/**
	 * Determine root of sitemap and show sitemap
	 * @param boolean $showSitemap Overwrite DB settings
	 * @return String
	 **/
	public function ShowSitemap($showSitemap = false) {
		$output = "";
		if ($this->owner->IncludeSitemap || $showSitemap) {
			if (!is_null($this->owner->BasePage)) {
				$basePage = DataObject::get_one("Page", "URLSegment = '" . $this->owner->BasePage . "'");
				if ($basePage) $rootLevel = DataObject::get("Page", "ParentID = " . $basePage->ID); // Pages at the root level only
				else $rootLevel = null;
			} else $rootLevel = DataObject::get("Page", "ParentID = 0"); // Pages at the root level only
			$output .= $this->owner->makeSitemapList($rootLevel);
		}
		return $output;
	}

	/**
	 * Create an extended version of Sitemap and extend this function if you would like to add specific data to your sitemap entries templates.
	 * @param Array $pages
	 * @param int $depth current level
	 **/
	public function prepareTemplateData($page, $depth) {
		return array(
							'Page' => $page,
							'SMShowPageName' => ($this->owner->ShowPageName == 1),
							'SMShowMetaTitle' => ($this->owner->ShowPageMetaTitle == 1),
							'SMShowMetaDescription' => ($this->owner->ShowPageMetaDescription == 1),
							'SMShowPageThumbnail' => ($this->owner->ShowPageThumbnail == 1),
							'SMThumbnail' => Image::get_one("Image", "ID = '" . $page->ThumbnailID . "'"),
						);
	}

	/**
	 * Generates HTML for Sitemap
	 *
	 * @param Array $pages
	 * @param int $depth current level
	 * @return String
	 */
	public function makeSitemapList($pages, $depth = 1) {
		$output = "";
		if(count($pages) && (($this->owner->Depth == 0) || ($depth <= $this->owner->Depth))) {

			if (($depth == 1) && (!empty($this->owner->Stylesheet))) {
				$output .= '<div class="' . $this->owner->Stylesheet . '">';
			}

			$output .= '<ul ';
			if ($depth == 1) $output .= 'id="sitemap-list" ';
			$output .= 'class="level' . $depth .'">';
			foreach($pages as $page) {
				if(!($page instanceof ErrorPage) && $page->ShowInMenus && $page->canView()){
					if (($this->owner->ShowSelf == 0) || (($this->owner->ShowSelf == 1) &&  $page->URLSegment != $this->owner->URLSegment)) {
						$data = $this->owner->prepareTemplateData($page, $depth);
						$output .= "<li class='" . /*$page->FirstLast() . $page->MiddleString() .*/ "'>";

						$output .= $this->owner->customise($data)->renderWith(array('Sitemap_entry_' . $this->owner->Stylesheet, 'Sitemap_entry', 'Sitemap'));

						$whereStatement = "ParentID = ".$page->ID;
						$childPages = DataObject::get("Page", $whereStatement);
						$output .= $this->owner->makeSitemapList($childPages, $depth+1);
						$output .= '</li>';
					}
				}
			}
			$output .= '
			</ul>';
			if (($depth == 1) && (!empty($this->Stylesheet))) {
				$output .= '</div>';
			}
		}
		return $output;
	}

	/**
	 * Callback function for Shortcode Handler
	 *
	 * @param Array $arguments Any parameters attached to the shortcode as an associative array (keys are lower-case).
	 * @param String $content Any content enclosed within the shortcode (if it is an enclosing shortcode).
	 * @param ShortcodeParser $parser instance used to parse the content.
	 * @return String
	 */
	public function SitemapShortCodeHandler($arguments,$content = null,$parser = null) {
		return Director::get_current_page()->ShowSitemap(true);
	}

	/**
	 * Ensure that BasePage is valid:
	 * For New pages BasePage is set to their URLSegment. If URLSegment of page is changed this is updated.
	 * If URLSegment doesn't exist (page deleted e.g.) it is updated to URLSegment of current page.
	 */
	function onBeforeWrite() {
		if (!$this->owner->ID) {
			$this->owner->BasePage = $this->owner->URLSegment;
		} else if ($this->owner->BasePage != null) {
			$storedData = Page::get_by_id('Page', $this->owner->ID);
			if ((isset($storedData->BasePage)) &&						// Old data found
					(($storedData->BasePage != $this->owner->BasePage) || ($storedData->URLSegment != $this->owner->URLSegment)) &&  // BasePage or URLSegment have changed
					($storedData->BasePage == $storedData->URLSegment)) {
						$this->owner->BasePage = $this->owner->URLSegment;
			} else {
				$basePageSQL = Convert::raw2sql($this->owner->BasePage);
				$pageExists = DataObject::get_one('Page', "URLSegment = '{$basePageSQL}'");
				if (!$pageExists) {
					$this->owner->BasePage = $this->owner->URLSegment;
				}
			}
		}
		parent::onBeforeWrite();
	}

}
