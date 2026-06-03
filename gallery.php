<?php
/* gallery.php was moved to pages/gallery.php.
   This file redirects any bookmarks or old links automatically. */
header('HTTP/1.1 301 Moved Permanently');
header('Location: pages/gallery.php');
exit;
