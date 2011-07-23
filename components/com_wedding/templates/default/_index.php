<?php
//echo $this->css;
//echo $this->images;
$document = & JFactory::getDocument();
$document->addStyleSheet($this->css.'general.css');
//echo($this->images);exit();
?>
<div id="pagewrap">
    <div id="wrapper">
        <div class="header">
        	<div class="yours-name"><?php echo $this->userdata['yours_name'];?></div>
        	<div class="yours-name"><?php echo $this->userdata['slogan'];?></div>
        </div>
        <div id="leftcol">
            <div class="menu">
            	<?php echo $this->menu;?>
            	<?php if(!$this->userdata['unknown'] && $this->userdata['counter'] > 0) { ?>            	
            	<div class="counter">Còn <?php echo $this->userdata['counter'];?> ngày nữa là tới ngày cưới của chúng tôi</div>
            	<?php } ?>
            </div>
            <div class="content"><?php echo $this->content;?></div>
        </div>
    </div>
</div>