ReadMe
	1. Templates
	2. Page title
	3. Download and hyperlink counter
	4. Decreasing the script execution time of chCounter




1. Templates
=========
The templates define the layout of the counter.php and the whole
statistics section. These files, located in the "templates" directory,
are plain text files with HTML which are read in by the counter, filled
with dynamic data and printed out afterwards.
The templates may be easily customized to fit to your needs. In
addition to the HTML code the special placeholders (enclosed by curly
brackets) and some control structures that occur may be removed
arbitrarily as well from the templates.
Important: If you use non-ASCII chars within the templates (see
http://en.wikipedia.org/wiki/ASCII), they must by saved in the UTF-8
charset.





2. Page title
===========
The counter attempts to detect the page title of each page into which
it is included (provided that this feature was not deactivated, e.g.
for reasons of performance). The page title can be assigned via PHP
(see install_en.txt) or can be extracted from the HTML code. This title
will be displayed within the statistics instead of the path of the
page.

ATTENTION: The counter only scans that file for a title which is
requested by the visitor - if the (HTML) page title is swapped out into
an inclusion file on the server file system, the title will not be
found.

If a title is assigned via PHP (recommended!), the counter will not
search further for a page title. Otherwise it will look first for the
following construct:

<!-- BEGIN CHCOUNTER_PAGE_TITLE -->This is the page title...<!-- END 
CHCOUNTER_PAGE_TITLE -->

If this construct cannot be found, the counter will attempt to find the
regular HTML title (<title>...</title>).





3. Download and hyperlink counter
=======================
Version 3.1.0 of chCounter introduced a simple download- and hyperlink
counting functionality. However, this is deactivated by default. To
enable it, the following line of the file includes/common.inc.php:

define( 'CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED', FALSE );

must be changed to:

define( 'CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED', TRUE );

(Save the file and upload it to your server.)
Now you can add downloads and hyperlinks at the now displayed categories
"Downloads" and "Hyperlinks" in the Admin Control Panel. Additionally,
a new rubric is displayed in the statistic area.
Attention: The downloads need a complete, absolute URL to the file, too!
The chCounter cannot upload new files to your webspace.


Counting of downloads and clicks
----------------------------------------
In order to get a download counted, you have to link to the file
counter/getfile.php instead of the real download file:

counter/getfile.php?id=x

As ID, you have to specify the ID which is shown in the Admin Control
Panel.

With the hyperlinks, it is nearly the same:

counter/refer.php?id=y

The same with downloads and hyperlinks, the request will be counted and
the visitor then redirected with a 301-HTTP status code to the download
file respectively the link target.



How to display data like number of downloads, name, URL, ... of certain
downloads/hyperlinks outside of the counter statistic page
 (PHP knowledge required)
----------------------------------------------------------------------------------
Using the file counter/get_dl_or_link_details.php and the class of
counter/includes/dl_or_link_details.class.php, such data can be printed
out separately. There is no documentation available, but with basic PHP
knowledge and having looked into the code, you should be able to use
this class.





4. Decreasing the script execution time of chCounter
==================================
If the script execution time of chCounter should be too high, have a look
an the following tips and tweaks:

- Deactivate unused statistics
By deactiviating statistics which are superfluous for you needs, the
number of database queries may be decreased significantly.

- Disable the automatical search for page titles
The automatic search for the page title (see docs/readme_en.txt, 2) may
cause a high server load. Using the Admin Control Panel, you can disable
this feature. You should use the variable $chCounter_page_title instead
(see install_en.txt, 3.2.3).

- Page views of the current page
If you do not use the value {V_MAX_VISITORS_ONLINE_DATE} within your
template file (templates/counter.tpl.html), you may already prevent that
this value is read out from the database. This saves one database query
per script execution.

<?php
$chCounter_show_page_views_of_the_current_page = FALSE;
include( 'counter.php' );
?>


- Use existent database connection / force new connection
See docs/install_en.txt: 3.2.5: Use existent database connection /
force new connection