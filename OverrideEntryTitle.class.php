<?php
/** @class OverrideEntryTitle.
  * This extension adds an <entry-title> element into MediaWiki mark-up
  * allowing pages to have the displayed title overriden. For example:
  * 
  * The page /wiki/hcard can have its displayed title overridden to 'hCard'
  * The page /wiki/hcard-issues can have a title 'hCard Issue Tracking'
  * The page /wiki/t can have an overridden title 'Tantek Çelik'
  * 
  * @author Ben Ward
  */
class OverrideEntryTitle {

    public static function parseEntryTitle($text, $attributes, $parser) {
        global $wgOut, $wgArticle;
        $parser->disableCache(); // EPIC hack. Need to instead cache/restore this value
        $wgOut->setPageTitle($text);
        # For the main page, overwrite the <title> element with the con-
        # tents of 'pagetitle-view-mainpage' instead of the default (if
        # that's not empty).
        if( $wgArticle->mTitle && $wgArticle->mTitle->equals( Title::newMainPage() ) &&
        wfMsgForContent( 'pagetitle-view-mainpage' ) !== '' )
            $wgOut->setHTMLTitle( wfMsgForContent( 'pagetitle-view-mainpage' ) );
        return '';
    }

    public static function registerHooks() {
        global $wgParser;
        $wgParser->setHook('entry-title', array('OverrideEntryTitle', 'parseEntryTitle'));
    }
}
?>
