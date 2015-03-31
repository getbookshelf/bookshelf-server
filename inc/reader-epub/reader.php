<?php
if(!isset($id)) { exit(); } // This file may only be included. Then, $id will be set.
if(empty($id)) {
    \Bookshelf\Utility\ErrorHandler::throwError('No book specified.', \Bookshelf\Utility\ErrorLevel::ERROR);
    header('Location: ../../index.php');
    exit();
}
$lib_man = new \Bookshelf\Core\LibraryManager();
$config = new \Bookshelf\Core\Configuration(true);
$book_title = $lib_man->getBookById($id)->metadata->title;
$base_url = $config->getBaseUrl();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?> — Bookshelf ePUB Reader</title>
        <link rel="stylesheet" href="<?php echo $base_url . '/inc/reader-epub'; ?>/css/normalize.css">
        <link rel="stylesheet" href="<?php echo $base_url . '/inc/reader-epub'; ?>/css/main.css">
        <link rel="stylesheet" href="<?php echo $base_url . '/inc/reader-epub'; ?>/css/popup.css">

        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="<?php echo $base_url . '/inc/reader-epub'; ?>/js/zip.min.js"></script>
        <script>
            "use strict";

            document.onreadystatechange = function() {
                if(document.readyState == "complete") {
                    EPUBJS.filePath = "js/";
                    EPUBJS.cssPath = "css/";

                    var reader = ePubReader("https://bookshelf.my-server.in/bookshelf/download.php?id=<?php echo $id; ?>", {contained: true});
                }
            };
        </script>
        <script src="<?php echo $base_url . '/inc/reader-epub'; ?>/js/epub.min.js"></script>
        <script src="<?php echo $base_url . '/inc/reader-epub'; ?>/js/hooks.min.js"></script>
        <script src="<?php echo $base_url . '/inc/reader-epub'; ?>/js/reader.min.js"></script>
        <script src="<?php echo $base_url . '/inc/reader-epub'; ?>/js/search.js"></script>
        <script src="<?php echo $base_url . '/inc/reader-epub'; ?>/js/jquery.highlight.js"></script>
        <script src="<?php echo $base_url . '/inc/reader-epub'; ?>/js/highlight.js"></script>
        <script src="<?php echo $base_url . '/inc/reader-epub'; ?>/js/screenfull.min.js"></script>
    </head>
    <body>
    <div id="sidebar">
        <div id="panels">
            <input id="searchBox" placeholder="search" type="search">

            <a id="show-Search" class="show_view icon-search" data-view="Search">Search</a>
            <a id="show-Toc" class="show_view icon-list-1 active" data-view="Toc">TOC</a>
            <a id="show-Bookmarks" class="show_view icon-bookmark" data-view="Bookmarks">Bookmarks</a>
            <a id="show-Notes" class="show_view icon-edit" data-view="Notes">Notes</a>

        </div>
        <div id="tocView" class="view">
        </div>
        <div id="searchView" class="view">
            <ul id="searchResults"></ul>
        </div>
        <div id="bookmarksView" class="view">
            <ul id="bookmarks"></ul>
        </div>
        <div id="notesView" class="view">
            <div id="new-note">
                <textarea id="note-text"></textarea>
                <button id="note-anchor">Anchor</button>
            </div>
            <ol id="notes"></ol>
        </div>
    </div>
    <div id="main">

        <div id="titlebar">
            <div id="opener">
                <a id="slider" class="icon-menu">Menu</a>
            </div>
            <div id="metainfo">
                <span id="book-title"></span>
                <span id="title-seperator">&nbsp;&nbsp;–&nbsp;&nbsp;</span>
                <span id="chapter-title"></span>
            </div>
            <div id="title-controls">
                <a id="bookmark" class="icon-bookmark-empty">Bookmark</a>
                <a id="setting" class="icon-cog">Settings</a>
                <a id="fullscreen" class="icon-resize-full">Fullscreen</a>
            </div>
        </div>

        <div id="divider"></div>
        <div id="prev" class="arrow">‹</div>
        <div id="viewer"></div>
        <div id="next" class="arrow">›</div>

        <div id="loader"><img src="<?php echo $base_url . '/inc/reader-epub'; ?>/img/loader.gif"></div>
    </div>
    <div class="modal md-effect-1" id="settings-modal">
        <div class="md-content">
            <h3>Settings</h3>
            <div>
                <p>
                    <input type="checkbox" id="sidebarReflow" name="sidebarReflow">Reflow text when sidebars are open.</input>
                </p>
            </div>
            <div class="closer icon-cancel-circled"></div>
        </div>
    </div>
    <div class="overlay"></div>
    </body>
</html>
