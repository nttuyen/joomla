
<?php
/**
 * @version		$Id: default.php 18650 2010-08-26 13:28:49Z ian $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');
?>
<div class="content-container">
	<?php foreach($this->categories as $cat): ?>
    <div class="content-wrap">
	    <span class="box-header">
            <span class="box-header-r">
		        <?php echo $cat->title; ?>
            </span>
	    </span>
	    
	    <div class="box-content">
		    <?php 
			    if($cat->listNews)
			    {
				    $this->listItems = &$cat->listNews;
				    echo $this->loadTemplate('item');
			    }
		    ?>
	    </div>
	    
	    <div class="clr"></div>
    </div>
	<?php endforeach;; ?>
	
</div>

