<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="<?php echo $this->css;?>layout.css" />
</head>

<body>
<div id="wrap">
	<div id="header">
    	<a href="#"><img src="<?php echo $this->images;?>bg-header.jpg" border="0" alt="" width="776" height="175" /></a>
    </div>
    
    <div id="logo">
    	<span style="font-size:35px; color:#FFFFFF; font-weight:bold; font-family:'Times New Roman', Times, serif;"><?php echo $this->userdata['yours_name'];?></span>
		<p style="color:#fbef2f; font-size:14px; margin:7px 0 10px 0;"><?php echo $this->userdata['slogan'];?></p>
    </div>
    
    <div id="pad-wrap">
    	<div id="letf">
                <div id="count">
<?php if( $this->userdata['counter'] > 0 ): ?>
                    <p>Còn</p>
                      <p><span style="color:#f9e102; font-size:50px;"><?php echo $this->userdata['counter'];?></span></p>
                       <p>ngày nữa </p>
                       <p>tới ngày cưới chúng tôi
                     </p>
<?php elseif( $this->userdata['counter'] == 0 ): ?>
					<p>Chúc mừng Hai bạn</p>
                      <p><span style="color:#f9e102; font-size:50px;"></span></p>
                       <p>Hạnh phúc </p>
                     </p>
<?php else: ?>
					<p>Hai Bạn đã cưới</p>
					 <p> </p>
                      <p><span style="color:#f9e102; font-size:50px;"><?php echo abs($this->userdata['counter']); ?></span></p>
                      
                       <p>ngày</p>
<?php endif; ?>
                </div>
            
                <div id="menu">
                  <img src="<?php echo $this->images;?>heart.jpg" border="0" alt="" width="13" height="13" /><?php echo $this->menu;?>
                </div>
            
          <?php /*?>    <div id="ykien">
                    <h3>Tham do y kien</h3>
                    <p>
                        chung toi nen di trang mat o dau<br />
                        chung toi nen di trang mat o dau<br />
                        chung toi nen di trang mat o dau<br />
                    chung toi nen di trang mat o dau<br />
                    chung toi nen di trang mat o dau<br />
    
                    </p>
             </div><?php */?>
        </div>
    	
        
        <div id="right">
        	<div id="date">Welcome</div>
            
            <div id="banner">
                <?php foreach($this->userdata['homeimg'] as $img): ?>
                    <img src="<?php echo $img; ?>" alt="Banner" width="540px" height="343px" />
                <?php endforeach; ?>
            </div>
            
            <div id="text">
            	<p>Chào mừng bạn ghé thăm website đám cưới<br />
            	  <br />
					<span style="color:#FA0075;text-transform:uppercase; font-size:20px;"><?php echo $this->userdata['yours_name'];?></span>
			  </p>
            </div>
            <div id="icon">
            </div>
            
            <div id="content">
            	<?php echo $this->content;?>
            </div>
            
        </div>
    </div>
    
    <div id="footer">
    	<div id="footer-r">
    		Bản quyền thuộc về &copy; HANHPHUC.VN - 2010</div>
    </div>
    
</div>
</body>
</html>
