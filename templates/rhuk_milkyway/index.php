<?php
/**
 * @version    $Id: index.php 17191 2010-05-19 15:33:13Z infograf768 $
 * @package    Joomla.Site
 * @copyright  Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$xp_right = $this->countModules('right-content');
if ( !$xp_right ){
  $divid = '-fl';
  } else {
  $divid = '';
}
//echo '<pre>'; print_r($_GET); die;  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/rhuk_milkyway/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/rhuk_milkyway/css/<?php echo $this->params->get('colorVariation'); ?>.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/rhuk_milkyway/css/<?php echo $this->params->get('backgroundVariation'); ?>_bg.css" type="text/css" />
<!--[if lte IE 6]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ieonly.css" rel="stylesheet" type="text/css" />
<![endif]-->
<?php if ($this->direction == 'rtl') : ?>
  <link href="<?php echo $this->baseurl ?>/templates/rhuk_milkyway/css/template_rtl.css" rel="stylesheet" type="text/css" />
<?php endif; ?>

</head>
<body id="page_bg" class="color_<?php echo $this->params->get('colorVariation'); ?> bg_<?php echo $this->params->get('backgroundVariation'); ?> width_<?php echo $this->params->get('widthStyle'); ?>">
<a name="up" id="up"></a>
<div class="center" align="center">
  <div id="wrapper">
          <div id="topmenu">
              <jdoc:include type="modules" name="top" />
            </div>
      <div id="header">
                <a href="index.php"><img src="<?php echo $this->baseurl ?>/templates/rhuk_milkyway/images/logo.png" width="204" height="69" alt="" id="logo" /></a>
                <jdoc:include type="modules" name="position-12" />
      </div>

      <div id="tabarea">
                <div id="tabmenu">
                    <div id="pillmenu">
                        <jdoc:include type="modules" name="user3" />
                        <jdoc:include type="modules" name="position-1" />
                    </div>
                </div>
      </div>
      <?php if($this->countModules('user4') || $this->countModules('position-12') || $this->countModules('position-0')) : ?>
      <div id="search">
        <jdoc:include type="modules" name="user4" />
        <jdoc:include type="modules" name="position-12" />
        <jdoc:include type="modules" name="position-0" />          
      </div>
      <?php endif; ?>
            <?php if($this->countModules('breadcrumb') || $this->countModules('position-2')) : ?>
      <div id="pathway">
        <jdoc:include type="modules" name="breadcrumb" />
        <jdoc:include type="modules" name="position-2" />
      </div>
      <?php endif; ?>
      <div class="clr"></div>
            
            
      <div id="whitebox">
            
        <div id="whitebox_m">
          <div id="area">
                                           
            <div id="leftcolumn">
            <?php if ($this->countModules('left')
                or $this->countModules('position-7')
            ) : ?>
              <jdoc:include type="modules" name="left" style="rounded" />
              <jdoc:include type="modules" name="position-7" style="rounded" />
            <?php endif; ?>
            </div>

            <?php if ($this->countModules('left')
                  or $this->countModules('position-7')
            ) : ?>
            <div id="maincolumn">
            <?php else: ?>
            <div id="maincolumn_full">
            <?php endif; ?>
              <?php if ($this->countModules('user1')  or  $this->countModules('user2')
              or ($this->countModules('position-9')  or  $this->countModules('position-10') ) ) : ?>
                <table class="nopad user1user2">
                  <tr valign="top">
                    <?php if ($this->countModules('user1') or $this->countModules('position-9')) : ?>
                      <td>
                        <jdoc:include type="modules" name="user1" style="xhtml" />
                        <jdoc:include type="modules" name="position-9" style="xhtml" />
                      </td>
                    <?php endif; ?>
                    <?php if ($this->countModules('user1') or $this->countModules('position-9')
                    and $this->countModules('user2') or $this->countModules('position-10')) : ?>
                      <td class="greyline">&nbsp;</td>
                    <?php endif; ?>
                    <?php if ($this->countModules('user2') or $this->countModules('position-10')) : ?>
                      <td>
                        <jdoc:include type="modules" name="user2" style="xhtml" />
                        <jdoc:include type="modules" name="position-10" style="xhtml" />
                      </td>
                    <?php endif; ?>
                  </tr>
                </table>

                <div id="maindivider"></div>
              <?php endif; ?>

              <table class="nopad">
                <tr valign="top">
                  <td>
                                      <?php if ($this->countModules('slideshow') && $_GET['view'] != 'detail') : ?>
                                        <div id="slideshow">
                                            <jdoc:include type="modules" name="slideshow" />
                                        </div>
                                        <?php endif; ?>
                                        <?php if ($this->countModules('scroll')) : ?>
                                        <div id="scroll">
                                            <jdoc:include type="modules" name="scroll" />
                                        </div>
                                        <?php endif; ?>
                                        <div id="maincontent">
                                          <?php if ($_GET['view'] == 'detail' || $_GET['option']=='com_wedding' || $_GET['option']=='com_je_faq' || $_GET['option']=='com_users') { ?>
                                            <div id="left-content-fl">
                                            <?php } else { ?>
                                          <div id="left-content">
                                            <?php } ?>
                                                <jdoc:include type="message" />
                                                <jdoc:include type="component" />    
                                                <jdoc:include type="modules" name="footer" style="xhtml"/>
                                                <jdoc:include type="modules" name="position-5" style="xhtml" />
                                                <jdoc:include type="modules" name="position-8"  style="xhtml" />
                                                <jdoc:include type="modules" name="position-11"  style="xhtml" />
                                            </div>
                                            
                                            <?php if (($this->countModules('right-content') && $_GET['view'] != 'detail' && $_GET['option'] != 'com_je_faq' ) && $_GET['option'] != 'com_users' ) : ?>
                                           <div id="right-content">
                                              <jdoc:include type="modules" name="right-content" style="xhtml"/>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($this->countModules('content-bottom')) : ?>
                                        <div id="content-bottom">
                                          <jdoc:include type="modules" name="content-bottom" style="rounded"/>
                                        </div>
                                        <?php endif; ?>
                    </td>
                  <?php if (($this->countModules('right') or
                      $this->countModules('position-3') or
                      $this->countModules('position-4')
                      )
                  and JRequest::getCmd('layout') != 'form') : ?>
                    <td class="greyline">&nbsp;</td>
                    <td width="297">
                      <jdoc:include type="modules" name="right" style="rounded"/>
                      <jdoc:include type="modules" name="position-3" style="xhtml"/>
                      <jdoc:include type="modules" name="position-4" style="xhtml"/>
                      </td>
                  <?php endif; ?>
                </tr>
              </table>

            </div>
            <div class="clr"></div>
          </div>
          <div class="clr"></div>
        </div>

      </div>

      <div id="footerspacer"></div>
    </div>

    <div id="footer">
          Copyright &copy; 2010 by Hanhphuc.vn - Liên hệ: Mr. Trần Lê Phúc - Mobile: 0912.933.361
    </div>
</div>
<jdoc:include type="modules" name="debug" />

</body>
</html>

