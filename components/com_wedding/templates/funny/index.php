<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="<?php echo $this->css;?>layout.css" />
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr id="wrap">
    <td width="1000" height="500" align="center" valign="top"><table width="1000" border="0" cellspacing="0">
      <tr>
        <td height="200">
			<div id="logo">
				<span style="font-size:35px; color:#65071B; font-weight:bold; font-family:'Times New Roman', Times, serif;"><?php echo $this->userdata['yours_name'];?></span>
				<p style="color:#014D87; font-size:16px; margin:7px 0 10px 0;"><?php echo $this->userdata['slogan'];?></p>
		  </div>		</td>
        </tr>
      <tr>
        <td height="300" align="center" valign="top"><table width="660" height="280" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="480" valign="top">
			<?php if(jRequest::getVar('view') == 'home'): ?>
            <div id="banner">
                <?php foreach($this->userdata['homeimg'] as $img): ?>
                    <img src="<?php echo $img; ?>" alt="Banner" width="400px" height="250px" />
                <?php endforeach; ?>
            </div>
			<?php endif; ?>
			</td>
            <td width="180" align="left" valign="top">
                <div id="menu">
                <?php echo $this->menu;?></div></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr id="main">
    <td align="center" valign="top"><table width="660" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="480" valign="top">
            <div id="text">
              <p>Chào mừng bạn ghé thăm website đám cưới<br />
                  <br />
                  <span style="color:#FA0075;text-transform:uppercase; font-size:20px;"><?php echo $this->userdata['yours_name'];?></span> </p>
            </div>
          </td>
        <td width="180" align="left" valign="top">
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
		</td>
      </tr>
      <tr>
        <td colspan="2" valign="top">
			<div id="content">
		  	<?php echo $this->content;?></div>
			</td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td>
    <div id="footer">
    	<div id="footer-r">
    		Bản quyền thuộc về &copy; HANHPHUC.VN - 2010</div>
    </div>
	</td>
  </tr>
</table>
</body>
</html>
